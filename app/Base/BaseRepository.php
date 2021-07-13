<?php

namespace App\Base;

use Illuminate\Support\Facades\DB;

class BaseRepository
{
    protected $model; //This model needs to be instantiated from the child constructor

    //Get the model
    public function getModel() {
        return $this->model;
    }
    //Get Record By ID
    public function getByID(int $id) {
       return $this->model->find($id);
    }

    //Get Record By UUID
    public function getByUUID(string $uuid) {
        return $this->model->where('uuid',$uuid)->get();
    }

    //Get all Records
    public function getAllRecords() {
        return $this->model::all();
    }

    //Get PaginatedRecords
    public function getPaginatedRecords(int $recordsPerPage = 15){
        return $this->model::paginate($recordsPerPage);
    }

    /**
     * requires $tableTransactionColumns protected variable to be declared on the calling child class
     * this is function will only be called for data validation based on the table transaction Columns
     * @return array
     * @var array, $strict =  force validation against all columns marked as 1
     *                     = true, when validating a new record which means the key or id = empty or is not set
     * array values will contain table column as key and a value of 1 when required and 0 if not required
     *
     */
    public function validateTransactionColumns(array $data, $strict = false) {
        if (!$data) { return array('status'=>FAILURE,'result'=>"Invalid Passed Parameter. Data passed for saving must be an Array."); }
        if (isset($this->tableTransactionColumns) && $this->tableTransactionColumns) {
            foreach ($this->tableTransactionColumns as $key => $value) {
                if (array_key_exists($key,$data)) {
                    if ($value && IsNullOrEmptyString($data[$key])) {
                        return array('status'=>FAILURE,'result'=>$key." must contain a valid value for saving!");
                    }
                } elseif ($value && $strict) {
                    return array('status'=>FAILURE,'result'=>$key." must be passed with a valid value for saving!");
                }
            }
            if ($strict) {
                foreach ($data as $key => $value) {
                    if (!array_key_exists($key,$this->tableTransactionColumns) && $key <> $this->model->getKeyName() && $value) {
                        return array('status'=>FAILURE,'result'=>$key." not found from the list of valid table transaction columns!");
                    }
                }
            }
        }
        return array('status' => SUCCESS,'result'=>'Data valid for saving!');
    }

    /* Saving a record
     * $datastore : array of values for saving
    */
    public function store(array $datastore) {

        $result = array("status" => SUCCESS,"result"=>"");
        if ($datastore) {
            //Perform the saving process
            //lets check if the passed datastore is an array of record rows
            $isMultipleRecord = false;
            foreach ($datastore as $key => $el) {
                if (is_array($el)) {
                    $isMultipleRecord = true;
                }
                break;
            }
            if ($isMultipleRecord) { // Multiple records passed for saving
                $result['result'] = array();
                foreach ($datastore as $data) {
                    $storeResult = $this->storeData($data);
                    $result['status'] = $storeResult['status'] ?: FAILURE;
                    $result['result'][] = $storeResult['result'];
                }
            } else { // single record is being passed for saving
                $result = $this->storeData($datastore);
            }
        }
        return $result;
    }

    //Storing valid data for saving
    private function storeData(array $data) {
        //this will set the validation $strict parameter to true you passed a new record for saving
        $result = $this->validateTransactionColumns($data,(!array_key_exists($this->model->getKeyName(), $data) ? true : !$data[$this->model->getKeyName()]));
        if ($result['status'] == SUCCESS) {
            $ret = $this->model->store($data);
            if ($ret) {
                $result['result'] = $ret;
            } else {
                $result['status'] = FAILURE;
                $result['result'] = 'Failure to save data '.json_encode($data);
            };
        }
        return $result;
    }

    /* Deleting a record
    * parameter
     * $recordID : array of ID or a single ID for deleting
     * $autocommit : default to TRUE, store will not issue Begin transaction
    */
    public function deleteRecord($recordID, $autocommit = TRUE) {
        $responses = array("status" => FAILURE,"result"=>"Invalid parameter ID");
        if ($recordID) {
            if (!$autocommit) { //Issue begin transaction
                DB::beginTransaction();
            }
            try {
                if (is_array($recordID)) { // Multiple records passed for saving
                    $responses['result'] = array();
                    foreach ($recordID as $key => $id) {
                        $result = $this->model->find($id);
                        if ($result && $result->delete()) {
                            $responses['result'][] = 'Record ID ' . $id . ($autocommit ? ' has been successfully deleted.' : ' OK for deletion.');
                        } else {
                            $responses['status'] = FAILURE;
                            $responses['result'][] = 'Record ID ' . $id . ' not found!';
                        }
                    }
                } else { // single record is being passed for saving
                    $result = $this->model->find($recordID);
                    if ($result && $result->delete()) {
                        $responses['result'] = 'Record ID ' . $recordID . ' has been successfully deleted.';
                    } else {
                        $responses['status'] = FAILURE;
                        $responses['result'] = 'Record ID ' . $recordID . ' not found!';
                    }
                }
            } catch (\Exception $e) {
                $responses['status'] = FAILURE;
                $responses['result'] = $e->getMessage();
            }
            if (!$autocommit) { //Issue begin transaction
                if ($responses['status'] == SUCCESS) {
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            }
        }
        return $responses;
    }

    //Search record from an array of fields to search
    public function searchRecord(array $fieldsArray, $searchValue) {
        $result = $this->model->Where(function ($q) use ($fieldsArray, $searchValue) {
            $q->orWhere($fieldsArray[0], 'LIKE', '%' . $searchValue . '%');
            for ($i = 1; $i < count($fieldsArray); $i++) {
                $q->orWhere($fieldsArray[$i], 'LIKE', '%' . $searchValue . '%');
            }
        });
       return $result;
    }

    /**
     * This function will set the value of validField arrays of the model which will be used for validating passed data attributes before saving
     * @var array
     */
    public function setTableTransactionColumns(array $tableColumns){
        if (!isset($this->tableTransactionColumns)) {
            abort(403,get_called_class().' : '.'Table Transaction Columns needs to be declared from the child repository!');
        } else {
            $this->tableTransactionColumns = $tableColumns;
        }
    }

    /**
     * This function will get the value of validField arrays of the model which will be used for validating passed data attributes before saving
     * @return  array
     */
    public function getTableTransactionColumns(){
        if (!isset($this->tableTransactionColumns)) {
            abort(403,get_called_class().' : '.'Table Transaction Columns needs to be declared from the child repository!');
        }
        return $this->tableTransactionColumns;
    }
}
