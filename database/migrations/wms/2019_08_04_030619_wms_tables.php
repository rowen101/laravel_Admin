<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*  wms_dropdown table
            This table stores the constants and collective information that will be used accross the system
            This is not a transactional table but a storage for modules to identify values inside a dropdown or selections
        */
        Schema::create('wms_dropdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_key',50); // 1st level filter as basis from the view to be created
            $table->string('column_key',50); // 2nd level filter normally the column or field
            $table->string('identity_code',50);
            $table->string('description',255);
            $table->integer('sort_order')->default(10);
            $table->integer('trace_code')->default(50);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->index(['table_key','column_key'],'wi_tbl_idx_table_column');
            $table->index(['identity_code','trace_code'],'wi_tbl_idx_code_map');
            $table->unique(['table_key','column_key','identity_code'],'unique_table_column_code');
            $table->engine = 'InnoDB';
        });

        //adding wms_message table
        Schema::create('wms_message', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_type',255); //SUCCESS,FAILURE,WARNING,SYSERROR
            $table->string('message_code',50);
            $table->string('message',255);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //items stored in warehouses will be defined as to which class does the storage belong and which area in the warehouse that can accommodate the storage
        Schema::create('wms_storageclass', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_code',20)->deault('')->index();
            $table->string('description',250)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //measuring unit of Measure
        Schema::create('wms_unitofmeasure', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uom_code',20)->deault('')->index();
            $table->string('description',250)->index();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the abcCode of item
        Schema::create('wms_abcMovement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('abc_code',20);
            $table->string('description',100);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Stores the list of warehouse
        Schema::create('wms_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('warehouse_code',20)->deault('')->index();
            $table->string('warehouse_name',250);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('wms_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->string('setting_group',20); //group name of the settings
            $table->string('setting_name',50)->index(); //Unique name of the settings
            $table->string('setting_value',100); // the value of the setting based on the input type
            $table->boolean('is_active')->default(true);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->unique(['setting_group','setting_name']);
            $table->engine = 'InnoDB';
        });

        // Here we are able to know what storage class can be stored to the warehouse
        Schema::create('wms_warehousestorageclass', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('storageclass_id')->unsigned();
            $table->foreign('storageclass_id')->references('id')->on('wms_storageclass');
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Stores the list of warehouse area, this we can segregate stock inventory per area created in the warehouse
        Schema::create('wms_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('area_code',20); // default value will be the warehouseCode. This is will become the owner Code for safe pick on customer-stock
            $table->string('area_name',100); // This is the name of the area based on the specified code
            $table->string('area_label',50); // This is a printed signage or label of the area... this could be default to warehouse name
            $table->boolean('is_active')->default(true);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Stores the list of warehouse users
        Schema::create('wms_userwarehouse', function (Blueprint $table) {
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('user_id')->index();
            $table->string('user_name',150);
            $table->string('warehouse_name',250);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Stores the list of location
        Schema::create('wms_location', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('wms_area');
            $table->string('location_code',20)->index();
            $table->string('trace_code',20)->nullable(); // used for mapping external system code
            $table->string('location_name',250);
            $table->string('location_type',20); // SHIPPING,RECEIVING,RESTRICTED,STORAGE,PICKING,DISCREPANCY
            $table->string('size_code',20)->nullable(); // value to store what size of s can be stored in this bin
            $table->string('abc_code',20)->index()->nullable(); // location prioritization based on storage velocity of consumption
            $table->string('check_digit',20)->nullable();
            $table->integer('capacity' )->default(1);
            $table->string('drive_zone',20)->nullable(); // zoning of locations where specific MHE operators can be assigned
            $table->string('drive_sequence',20)->default('100');
            $table->string('pick_zone',20)->nullable(); // zoning of locations where specific pickers can be assigned
            $table->string('pick_sequence',20)->default('100');
            $table->boolean('is_locked')->default(false);
            $table->string('lock_type',20)->default('LOCKALL'); //LOCKOUT, LOCKIN, LOCKALL
            $table->boolean('is_fix_item')->default(false);
            $table->string('fix_item_code',20)->nullable();
            $table->boolean('is_overflow')->default(false);
            $table->boolean('is_virtual')->default(false); // location not exists physically
            $table->string('is_block_stock',20); // This will determine the movement of stock from this location in uom FULL or LOOSE
            $table->boolean('is_active')->default(true);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Holds the product type master definition
        Schema::create('wms_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('storageclass_id')->unsigned();
            $table->foreign('storageclass_id')->references('id')->on('wms_storageclass');
            $table->string('product_code',20)->index();
            $table->string('product_name',20);
            $table->string('product_type',20); //Like POWDER, RTD, PERSONAL CARE, HAIR CARE
            $table->string('product_category',20); //Like MILK, COFFEE, JEANS
            $table->integer('shelf_life')->default(0); //0 = no expiry
            $table->string('shelf_life_uom',20)->default('DAYS'); //DAY, MONTH
            $table->integer('salvage_life')->default(0); // no salvage
            $table->string('withdrawal_strategy', 10)->default('FEFO'); //FEFO.FIFO.LIFO
            $table->string('location_shared_expiry_unit', 10)->default('MONTH'); //DAY , MONTH, OPEN also known as Rotadate
            $table->string('lot_format',20)->default('MMDDYY');
            $table->string('lot_type',20)->default('EXPIRY'); //For  expiry date or manufacturing date
            $table->boolean('is_active')->default(true)->index();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Holds the product item master definition
        Schema::create('wms_productitem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('wms_product');
            $table->string('item_code',20)->index();
            $table->string('item_name',200);
            $table->string('description',150)->nullable();
            $table->string('barcode',20)->nullable(); // Scannable code for this item
            $table->string('trace_code',20)->nullable();
            $table->string('abc_code',20)->index()->nullable();
            $table->string('batch_uom', 20)->default('batch');
            $table->foreign('batch_uom')->references('uom_code')->on('wms_unitofmeasure');
            $table->string('inventory_uom', 20)->default('CASE');
            $table->foreign('inventory_uom')->references('uom_code')->on('wms_unitofmeasure');
            $table->string('smallest_uom', 20)->default('PIECE');
            $table->foreign('smallest_uom')->references('uom_code')->on('wms_unitofmeasure');
            $table->string('unit_cost_uom',20)->nullable();
            $table->decimal('unit_cost', 18,8)->default(0);
            $table->decimal('unit_length', 10,3)->default(0);
            $table->decimal('unit_width', 10,3)->default(0);
            $table->decimal('unit_height', 10,3)->default(0);
            $table->decimal('unit_weight', 10,3)->default(0);
            $table->decimal('safe_inventory_level', 18,8)->default(0);
            $table->integer('replenish_min')->default(0);
            $table->integer('replenish_max')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding wms_productitemcon table is product type item unit conversion Qty and the packaging barcode. converting the smallest uom of each item to the specified uom
        Schema::create('wms_productitemconversion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('conversion_uom',20)->index();//wms_unitofmeasure of uom
            $table->integer('conversion_qty')->default(1);
            $table->string('barcode',50);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the abcCode of item when choosing location for auto putaway
        Schema::create('wms_itemputawaypriority', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('abc_code',20)->index();//wms_unitofmeasure of uom
            $table->foreign('abc_code')->references('abc_code')->on('wms_productitem');
            $table->integer('priority_no')->default(1);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //contact source or stock destination
        Schema::create('wms_trucktype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('truck_type_code',20)->index();
            $table->string('truck_type_name',200);//name of the contact
            $table->decimal('load_weight',18,3)->default(0);
            $table->string('load_weight_uom',20)->nullable();
            $table->decimal('load_volume',18,3)->default(0);
            $table->string('load_volume_uom',20)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Supplier
        Schema::create('wms_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('supplier_code',20)->index();
            $table->string('supplier_name',200);//name of the contact
            $table->string('status',20)->default('ACTIVE')->index(); //ACTIVE,INACTIVE,ONHOLD
            $table->string('supplier_category',20); //LOCAL,INTERNATIONAL
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Customer
        Schema::create('wms_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('customer_code',20)->index();
            $table->string('customer_name',200);//name of the contact
            $table->string('status',20)->default('ACTIVE')->index(); //ACTIVE,INACTIVE,ONHOLD
            $table->integer('freshness_requirement')->default(0); //0 = based on item salvage days
            $table->string('freshness_unit',10)->default('days'); //days or percent
            $table->string('customer_category',20); //SALES,EMPLOYEE
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Trucker
        Schema::create('wms_trucker', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('trucker_code',20)->index();
            $table->string('trucker_name',200);//name of the contact
            $table->string('status',20)->default('ACTIVE')->index(); //ACTIVE,INACTIVE,ONHOLD
            $table->string('trucker_category',20); //INBOUND,OUTBOUND, BOTH
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });


        //contact source or stock destination
        Schema::create('wms_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->string('contact_code',20)->index(); // supplier code, customer code, trucker code
            $table->string('contact_name',200);//name of the contact
            $table->string('contact_address',200)->nullable();
            $table->string('contact_town',200)->nullable();
            $table->string('contact_province',200)->nullable();
            $table->string('contact_country',200)->nullable();
            $table->string('contact_postal',200)->nullable();
            $table->string('contact_person',200)->nullable();
            $table->string('email_address',100)->nullable();
            $table->string('cellphone_no',30)->nullable();
            $table->string('telephone_no',30)->nullable();
            $table->string('contact_type',20); //SUPPLIER, CUSTOMER, TRUCKER
            $table->string('status',20)->default('ACTIVE')->index(); //ACTIVE,INACTIVE,ONHOLD
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Inventory Batch / batch which holds the item
        Schema::create('wms_batch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch_label_no',50)->index(); // system generated batch no
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('wms_location');
            $table->string('trace_no',50); // For external traceability number
            $table->boolean('is_locked')->default(false);
            $table->integer('last_movement_id'); // the batch movement history ID recorded for this batch, if batch tracking is on, then it is the batch movement history
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the PO Transaction Header
        Schema::create('wms_poheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('wms_contact');
            $table->string('contact_name',150);
            $table->string('reference_no',20)->nullable(); //Reference Numbers
            $table->DateTime('reference_date')->nullable();
            $table->DateTime('po_date');
            $table->DateTime('po_due_date')->nullable();
            $table->text('remarks');
            $table->string('order_status',20)->default('OPEN')->index(); //OPEN,HOLD, POSTED, CANCELLED
            $table->string('record_source',20); //IMPORT , MANUAL
            $table->string('trace_no',50); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the PO Transaction Detail
        Schema::create('wms_podetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poheader_id')->unsigned();
            $table->foreign('poheader_id')->references('id')->on('wms_poheader');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('line_no',20); //Line number usually from external system sequencing
            $table->string('item_code',20); //RR number
            $table->string('item_name',200); //Reference Numbers
            $table->decimal('unit_cost',10,3)->default(0);
            $table->string('po_uom',20);
            $table->decimal('po_quantity',18,8)->default(0);
            $table->string('order_uom',20);
            $table->decimal('order_quantity',18,8)->default(0);
            $table->decimal('received_quantity',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Receiving Transaction Header
        Schema::create('wms_receiptheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('wms_contact');
            $table->integer('poheader_id')->unsigned(); // This is referencing poheader
            $table->string('contact_name',150);
            $table->string('receipt_no',20)->index(); //RR number
            $table->string('reference_no',20)->index(); //Reference Numbers
            $table->DateTime('receipt_date')->index();
            $table->string('document_no',20)->nullable(); //Document number
            $table->DateTime('document_date')->nullable();
            $table->string('order_no',20)->nullable(); //Order number
            $table->DateTime('order_date')->nullable();
            $table->string('shipment_no',20)->nullable(); //Shipment or Delivery _no
            $table->DateTime('shipment_date')->nullable();
            $table->string('receipt_type',20)->index(); // Types or Receipts SHIPMENT/ADJUSTMENT/RETURNS
            $table->string('receiving_area_code',20); // default will be the warehouse code which is also the default area code
            $table->text('remarks');
            $table->string('status',20)->default('OPEN')->index(); //OPEN,HOLD, POSTED, CANCELLED
            $table->string('record_source',20); //IMPORT , MANUAL
            $table->string('trace_no',50); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Receiving Transaction Detail
        Schema::create('wms_receiptdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiptheader_id')->unsigned();
            $table->foreign('receiptheader_id')->references('id')->on('wms_receiptheader');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('line_no',20)->nullable()->index(); //Line number usually from external system sequencing
            $table->string('item_code',20); //Item
            $table->string('item_name',200); //Item name
            $table->decimal('receipt_cost',10,3)->default(0);
            $table->string('receipt_uom1',20);
            $table->decimal('receipt_quantity1',18,8)->default(0);
            $table->string('receipt_uom2',20);
            $table->decimal('receipt_quantity2',18,8)->default(0);
            $table->string('inventory_uom',20);
            $table->decimal('inventory_quantity',18,8)->default(0);
            $table->decimal('batched_quantity',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Shipment _notice Transaction Header
        Schema::create('wms_shipmentnoticeheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('wms_contact');
            $table->string('contact_name',150);
            $table->string('notice_no',20); // This is primary key Shipment notice no
            $table->string('source_warehouse_no',20);// Source warehouse no
            $table->string('destination_warehouse_no',20); // Destination warehouse _no
            $table->string('document_no',20)->nullable(); //Document number
            $table->DateTime('document_date')->nullable();
            $table->string('reference_order_no',20)->nullable(); //reference Order number
            $table->DateTime('reference_order_date')->nullable(); //reference Order Date
            $table->string('shipment_no',20)->nullable(); //Shipment or Delivery _no
            $table->DateTime('shipment_date')->nullable();
            $table->string('notice_type',20)->index(); // Types of shipment notice DELIVERY, INTERPLANT
            $table->text('remarks')->nullable();
            $table->string('status',20)->default('OPEN')->index(); //OPEN, DELIVERED, UNDELIVERED
            $table->string('record_source',20)->nullable(); //IMPORT , MANUAL
            $table->string('trace_no',50)->nullable(); //For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Shipment _notice Transaction Detail
        Schema::create('wms_shipmentnoticedetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipmentnoticeheader_id')->unsigned();
            $table->foreign('shipmentnoticeheader_id')->references('id')->on('wms_shipmentnoticeheader');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('line_no',20); //Line number usually from external system sequencing
            $table->string('item_code',20); //Item
            $table->string('item_name',200); //Item name
            $table->string('lot_no',20)->nullable();
            $table->DateTime('expiry_date')->nullable();
            $table->string('batch_label_no',20);
            $table->decimal('item_cost',10,3)->default(0);
            $table->string('item_uom',20);
            $table->decimal('item_quantity',18,8)->default(0);
            $table->decimal('inventory_quantity_expected',18,8)->default(0);
            $table->decimal('inventory_quantity_received',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the issuanceRequest Transaction Header
        Schema::create('wms_issuancerequestheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('wms_contact');
            $table->integer('poheader_id')->unsigned(); // This is referencing poheader
            $table->string('contact_name',150);
            $table->string('request_no',20)->index(); //issuanceRequest number
            $table->DateTime('request_date');
            $table->string('document_no',20)->nullable(); //Document number
            $table->DateTime('document_date')->nullable();
            $table->string('reference_order_no',20)->nullable(); //reference Order number
            $table->DateTime('reference_order_date')->nullable(); //reference Order Date
            $table->string('shipment_no',20)->nullable(); //Shipment or Delivery _no
            $table->DateTime('shipment_date')->nullable();
            $table->string('issuance_type',20)->index(); // Types or Receipts SHIPMENT/ADJUSTMENT/RETURNS
            $table->text('remarks')->nullable();
            $table->string('status',20)->default('OPEN')->index(); //OPEN,HOLD, POSTED, CANCELLED
            $table->string('record_source',20); //IMPORT , MANUAL
            $table->string('trace_no',50); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // the issuanceRequest Transaction Detail
        // allocated quantity will be computed based on the batch transaction detail
        Schema::create('wms_issuancerequestdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issuancerequestheader_id')->unsigned();
            $table->foreign('issuancerequestheader_id')->references('id')->on('wms_issuancerequestheader');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('line_no',20); //Line number usually from external system sequencing
            $table->string('item_code',20);
            $table->string('item_name',200);
            $table->decimal('unit_cost',10,3)->default(0);
            $table->string('request_uom',20);
            $table->decimal('request_quantity',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Issuance can have multiple loadplan and can be configured that loadplan quantity per issuance detail must not exceed the request quantity
        //the issuance Load Plan Transaction Header
        Schema::create('wms_issuanceloadplanheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->DateTime('loadplan_date');
            $table->string('truck_type',20);
            $table->Decimal('truck_volume',18,3);
            $table->Decimal('truck_weight',18,3);
            $table->Decimal('loadplan_volume',18,3);
            $table->Decimal('loadplan_weight',18,3);
            $table->text('remarks')->nullable();
            $table->string('status',20)->default('OPEN')->index(); //OPEN,ONGOING,DELIVERED
            $table->string('record_source',20)->nullable(); //IMPORT , MANUAL
            $table->string('trace_no',50)->nullable(); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the issuance Load Plan Transaction Detail
        Schema::create('wms_issuanceloadplandetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issuanceloadplanheader_id')->unsigned();
            $table->foreign('issuanceloadplanheader_id')->references('id')->on('wms_issuanceloadplanheader');
            $table->integer('issuancerequestdetail_id')->unsigned();
            $table->foreign('issuancerequestdetail_id')->references('id')->on('wms_issuancerequestdetail');
            $table->decimal('loadplan_quantity',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the issuance Shipment Transaction Header
        Schema::create('wms_issuanceshipmentheader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->index()->default('');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('wms_contact');
            $table->string('contact_name',150);
            $table->string('shipment_no',20)->index(); //issuanceRequest number
            $table->DateTime('shipment_date');
            $table->DateTime('delivery_date');
            $table->string('document_no',20)->nullable(); //Document number
            $table->DateTime('document_date')->nullable();
            $table->string('plate_no',10)->nullable();
            $table->string('driver_name',100)->nullable();
            $table->string('truck_reference',100)->nullable(); //reference
            $table->string('shipment_mode',20); // LAND/AIR/SEA
            $table->integer('trucktype_id')->unsigned();
            $table->foreign('trucktype_id')->references('id')->on('wms_trucktype');
            $table->text('remarks')->nullable();
            $table->string('status',20)->default('OPEN')->index(); //OPEN,ONGOING,DELIVERED
            $table->string('record_source',20); //IMPORT , MANUAL
            $table->string('trace_no',50); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the issuance Shipment Transaction Detail
        // Shipment quantity must not exceed the picked quantity and the requested quantity on issuance detail
        Schema::create('wms_issuanceshipmentdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issuanceshipmentheader_id')->unsigned();
            $table->foreign('issuanceshipmentheader_id')->references('id')->on('wms_issuanceshipmentheader');
            $table->integer('issuancerequestdetail_id')->unsigned();
            $table->foreign('issuancerequestdetail_id')->references('id')->on('wms_issuancerequestdetail');
            $table->string('shipment_uom',20);
            $table->decimal('shipment_quantity',18,8)->default(0);
            $table->decimal('delivered_quantity',18,8)->default(0);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Warehouse Inventory Movement Order
        Schema::create('wms_movement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('movement_no',20)->index(); //Picklist _no / PA no / ST NO
            $table->string('movement_type',30)->index(); //Putaway,StockTransfer,Replenishment,Issuance, etc..
            $table->string('instruction',150)->nullable();
            $table->boolean('is_released')->default(false);
            $table->DateTime('release_date')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->DateTime('complete_date')->nullable();
            $table->integer('print_count' )->default(0);
            $table->integer('printed_by' )->nullable();
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //the Inventory Items which is placed inside the batches
        Schema::create('wms_batchitem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id')->unsigned();
            $table->foreign('batch_id')->references('id')->on('wms_batch');
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->integer('receiptdetail_id')->unsigned();
            $table->foreign('receiptdetail_id')->references('id')->on('wms_receiptdetail');
            $table->integer('issuancerequestdetail_id')->unsigned();
            $table->foreign('issuancerequestdetail_id')->references('id')->on('wms_issuancerequestdetail');
            $table->string('lot_no',30);
            $table->DateTime('manufacturing_date');
            $table->DateTime('expiry_date');
            $table->string('inventory_uom',20);
            $table->decimal('inventory_quantity',18,8)->default(0);
            $table->string('status',20); //GOOD, DAMAGED, ONHOLD
            $table->decimal('used_quantity',18,8)->default(0); //always set to zero after movement confirmation
            $table->string('trace_no',50); // For external traceability number
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Movement Order detail or Transction File for items allocated quantity
        Schema::create('wms_movementdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('movement_id')->unsigned();
            $table->foreign('movement_id')->references('id')->on('wms_movement');
            $table->integer('batchitem_id')->unsigned();
            $table->foreign('batchitem_id')->references('id')->on('wms_batchitem');
            $table->integer('movement_reference_no')->nullable(); //issuance no, RR NO. it is in detail because we can include multiple issuance in one picklist/ movement no.
            $table->integer('location_id')->unsigned(); //destination
            $table->foreign('location_id')->references('id')->on('wms_location');
            $table->string('movement_uom',20);
            $table->decimal('movement_quantity',18,8)->default(0);
            $table->string('movement_type',20)->default('MANUAL'); //INBOUND/OUTBOUND = MANUAL/AUTOMATIC, TRANSFERS = MANUAL
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Batch Item Movement History for items allocated quantity. Confirmed movements will be automatically transferred to history
        Schema::create('wms_batchitemmovementhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('receiptdetail_id')->unsigned();
            $table->foreign('receiptdetail_id')->references('id')->on('wms_receiptdetail');
            $table->integer('movementdetail_id')->unsigned();
            $table->foreign('movementdetail_id')->references('id')->on('wms_movementdetail');
            $table->integer('batch_item_id'); // we dont put reference because the source will be deleted but we need to capture this for traceability
            $table->string('movement_no',20); //from movement table
            $table->integer('movement_reference_id'); //either rr, issuance, etc
            $table->integer('movement_reference_no'); //reference no from rr, issuance  etc..
            $table->string('movement_type',30); //PA,ST,SR,IR etc..
            $table->string('batch_label_no',50);
            $table->string('movement_uom',20);
            $table->string('movement_lot_no',20);
            $table->string('actual_lot_no',20)->nullable();
            $table->decimal('movement_quantity',18,8);
            $table->decimal('actual_quantity',18,8)->default(0);
            $table->string('from_location_code',20); //source
            $table->string('to_location_code',20); //destination
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('line_no',20); //Line number usually from external system sequencing
            $table->string('item_code',20); //Item
            $table->string('item_name',200); //Item name
            $table->decimal('unit_cost',10,3)->default(0);
            $table->string('movement_code',20)->default('MANUAL'); //INBOUND/OUTBOUND = MANUAL/AUTOMATIC, TRANSFERS = MANUAL
            $table->DateTime('movement_date');
            $table->DateTime('manufacturing_date');
            $table->DateTime('expiry_date');
            $table->boolean('is_printed')->default(false);
            $table->boolean('is_interfaced')->default(false);
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // batch Movement History for items allocated quantity. Confirmed movements will be automatically transferred to history
        Schema::create('wms_batchmovementhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('wms_warehouse');
            $table->integer('movementdetail_id')->nullable();
            $table->string('movement_no',20);
            $table->integer('movement_reference_id');
            $table->integer('movement_reference_no');
            $table->string('movement_reference_type',30);
            $table->string('from_location_code',20); //source
            $table->string('to_location_code',20); //destination
            $table->integer('productitem_id')->unsigned();
            $table->foreign('productitem_id')->references('id')->on('wms_productitem');
            $table->string('batch_label_no',50);
            $table->string('status',20); //DAMAGED, GOOD
            $table->integer('created_by' );
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Run the WMS database Seeder
        Artisan::call('db:seed', ['--class' => WmsDatabaseSeeder::class]);
    }
}
