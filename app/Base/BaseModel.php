<?php

namespace App\Base;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class BaseModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;


    protected $guarded = ['id', 'uuid'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'uuid')) {
                $model->uuid = (string)Str::uuid();
            }
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = Auth::id() ? Auth::id() : 1;
            }
        });
        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = Auth::id() ? Auth::id() : $model->updated_by;
            }
        });
        static::retrieved(function ($model) {
            $result = DB::select("SHOW COLUMNS FROM " . $model->getTable() . "");
            foreach ($result as $key => $value) {
                if (($model[$value->Field] != "0000-00-00 00:00:00") && ($model[$value->Field] != "")) {
                    if (strtolower($value->Type) == 'timestamp' || strtolower($value->Type) == 'datetime') {
                        $dateTime = explode(' ', $model[$value->Field]);
                        $datePart = explode('-', $dateTime[0]);
                        $hourPart = explode(':', $dateTime[1]);
                        $model[$value->Field] = Carbon::create($datePart[0], $datePart[1], $datePart[2], $hourPart[0], $hourPart[1], $hourPart[2], date_default_timezone_get());
                    }
                }
            }
            return $model;
        });
    }

    //Get Record By ID
    public function getByID(int $id)
    {
        return $this->find($id);
    }

    //Get Record By UUID
    public function getByUUID(string $uuid)
    {
        return $this::where('uuid', $uuid)->get();
    }

    //Get all Records
    public function getAllRecords()
    {
        return $this::all();
    }

    //Get PaginatedRecords
    public function getPaginatedRecords(int $recordsPerPage = 15)
    {
        return $this::paginate($recordsPerPage);
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
    public function validateTransactionColumns(array $data, $strict = false)
    {
        if (!$data) {
            return array('status' => FAILURE, 'result' => "Invalid Passed Parameter. Data passed for saving must be an Array.");
        }
        if (isset($this->tableTransactionColumns) && $this->tableTransactionColumns) {
            foreach ($this->tableTransactionColumns as $key => $value) {
                if (array_key_exists($key, $data)) {
                    if ($value && IsNullOrEmptyString($data[$key])) {
                        return array('status' => FAILURE, 'result' => $key . " must contain a valid value for saving!");
                    }
                } elseif ($value && $strict) {
                    return array('status' => FAILURE, 'result' => $key . " must be passed with a valid value for saving!");
                }
            }
            if ($strict) {
                foreach ($data as $key => $value) {
                    if (!array_key_exists($key, $this->tableTransactionColumns) && $key <> $this->getKeyName() && $value) {
                        return array('status' => FAILURE, 'result' => $key . " not found from the list of valid table transaction columns!");
                    }
                }
            }
        }
        return array('status' => SUCCESS, 'result' => 'Data valid for saving!');
    }

    //saving the record : expecting a single record transaction
    public function store(array $attributes)
    {
        $recordID = 0;
        //we ensure that the attribute being passed only contain a single record data for saving
        foreach ($attributes as $key => $el) {
            if (is_array($el)) {
                abort(403, $this->getMorphClass() . ' : Passed attribute must be a single record transaction');
            }
            break;
        }
        //saving data
        if (array_key_exists($this->getKeyName(), $attributes)) {
            $recordID = $attributes[$this->getKeyName()];
        }
        try {
            if ($recordID) {
                $result = $this->find($recordID);
                if ($result) {

                    if ($result->update($attributes)) {
                        $result['status'] = SUCCESS;
                    }
                } else {
                    $result['status']  = FAILURE;
                }
            } else {
                $result = $this->create($attributes);
            }
        } catch (\Exception $e) {
            abort(403, $this->getMorphClass() . ' : ' . $e->getMessage());
        }
        return $result;
    }

    //    /* Saving a record
    //     * $datastore : array of values for saving
    //    */
    //    public function save(array $datastore) {
    //
    //        $result = array("status" => SUCCESS,"result"=>"");
    //        if ($datastore) {
    //            //Perform the saving process
    //            //lets check if the passed datastore is an array of record rows
    //            $isMultipleRecord = false;
    //            foreach ($datastore as $key => $el) {
    //                if (is_array($el)) {
    //                    $isMultipleRecord = true;
    //                }
    //                break;
    //            }
    //            if ($isMultipleRecord) { // Multiple records passed for saving
    //                $result['result'] = array();
    //                foreach ($datastore as $data) {
    //                    $storeResult = $this->storeData($data);
    //                    $result['status'] = $storeResult['status'] ?: FAILURE;
    //                    $result['result'][] = $storeResult['result'];
    //                }
    //            } else { // single record is being passed for saving
    //                $result = $this->storeData($datastore);
    //            }
    //        }
    //        return $result;
    //    }

    //Storing valid data for saving
    private function storeData(array $data)
    {
        //this will set the validation $strict parameter to true you passed a new record for saving
        $result = $this->validateTransactionColumns($data, (!array_key_exists($this->getKeyName(), $data) ? true : !$data[$this->getKeyName()]));
        if ($result['status'] == SUCCESS) {
            $ret = $this->store($data);
            if ($ret) {
                $result['result'] = $ret;
            } else {
                $result['status'] = FAILURE;
                $result['result'] = 'Failure to save data ' . json_encode($data);
            };
        }
        return $result;
    }

    /* Deleting a record
    * parameter
     * $recordID : array of ID or a single ID for deleting
     * $autocommit : default to TRUE, store will not issue Begin transaction
    */
    public function deleteRecord($recordID, $autocommit = TRUE)
    {
        $responses = array("status" => FAILURE, "result" => "Invalid parameter ID");
        if ($recordID) {
            if (!$autocommit) { //Issue begin transaction
                DB::beginTransaction();
            }
            try {
                if (is_array($recordID)) { // Multiple records passed for saving
                    $responses['result'] = array();
                    foreach ($recordID as $key => $id) {
                        $result = $this->find($id);
                        if ($result && $result->delete()) {
                            $responses['result'][] = 'Record ID ' . $id . ($autocommit ? ' has been successfully deleted.' : ' OK for deletion.');
                        } else {
                            $responses['status'] = FAILURE;
                            $responses['result'][] = 'Record ID ' . $id . ' not found!';
                        }
                    }
                } else { // single record is being passed for saving
                    $result = $this->find($recordID);
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
    public function searchRecord(array $fieldsArray, $searchValue)
    {
        $result = $this->Where(function ($q) use ($fieldsArray, $searchValue) {
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
    public function setTableTransactionColumns(array $tableColumns)
    {
        if (!isset($this->tableTransactionColumns)) {
            abort(403, get_called_class() . ' : ' . 'Table Transaction Columns needs to be declared from the child repository!');
        } else {
            $this->tableTransactionColumns = $tableColumns;
        }
    }

    /**
     * This function will get the value of validField arrays of the model which will be used for validating passed data attributes before saving
     * @return  array
     */
    public function getTableTransactionColumns()
    {
        if (!isset($this->tableTransactionColumns)) {
            abort(403, get_called_class() . ' : ' . 'Table Transaction Columns needs to be declared from the child repository!');
        }
        return $this->tableTransactionColumns;
    }
}
