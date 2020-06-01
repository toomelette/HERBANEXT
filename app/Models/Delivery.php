<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Delivery extends Model{



    use Sortable;
    protected $table = 'deliveries';
    protected $dates = ['date', 'created_at', 'updated_at'];
    public $sortable = ['delivery_code', 'description', 'date', 'is_delivered', 'updated_at'];
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'delivery_id' => '',
        'delivery_code' => '',
        'description' => '',
        'date' => null,
        'is_delivered' => false,
        'is_organic' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    public function displayDeliveryStatus(){

        $count_total_po_item = 0;
        $count_delivered_po_item = 0;
        $count_returned_po_item = 0;
        $count_pending_po_item = 0;

        $count_total_jo = 0;
        $count_delivered_jo = 0;
        $count_returned_jo = 0;
        $count_pending_jo = 0;


        if (!$this->deliveryItem->isEmpty()) {

            foreach($this->deliveryItem as $di) {

                $count_total_po_item = $count_total_po_item + 1;

                if (optional($di->purchaseOrderItem)->delivery_status == 4) {
                    $count_delivered_po_item = $count_delivered_po_item + 1;     
                }elseif(optional($di->purchaseOrderItem)->delivery_status == 3){
                    $count_returned_po_item = $count_returned_po_item + 1;    
                }else{
                    $count_pending_po_item = $count_pending_po_item + 1;
                }

            }
            
        }


        if (!$this->deliveryJO->isEmpty()) {

            foreach($this->deliveryJO as $djo) {

                $count_total_jo = $count_total_jo + 1;

                if (optional($djo->jobOrder)->delivery_status == 4) {
                    $count_delivered_jo = $count_delivered_jo + 1;     
                }elseif(optional($djo->jobOrder)->delivery_status == 3){
                    $count_returned_jo = $count_returned_jo + 1;    
                }else{
                    $count_pending_jo = $count_pending_jo + 1;
                }

            }
            
        }


        if ($count_total_po_item == $count_delivered_po_item && $count_total_jo == $count_delivered_jo) {

            return '<span class="badge bg-green">Completed</span>';

        }else{

            return '<span class="badge bg-orange">
                        '. $count_returned_po_item .' PO Item Returned, '. $count_pending_po_item .' PO Item Pending
                    </span><br>
                    <span class="badge bg-orange">
                        '. $count_returned_jo .' JO Returned, '. $count_pending_jo .' JO Pending
                    </span><br>';
                    
        }


        return '<span class="badge bg-orange">Pending ..</span>';


    }



    /** RELATIONSHIPS **/
    public function deliveryItem() {
        return $this->hasMany('App\Models\DeliveryItem','delivery_id','delivery_id');
    }



    /** RELATIONSHIPS **/
    public function deliveryJO() {
        return $this->hasMany('App\Models\DeliveryJO','delivery_id','delivery_id');
    }


    
}
