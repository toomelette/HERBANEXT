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
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    public function displayDeliveryStatus(){

        if (!$this->deliveryItem->isEmpty()) {

            $count_total = 0;
            $count_delivered = 0;
            $count_returned = 0;
            $count_pending = 0;

            foreach($this->deliveryItem as $di) {

                $count_total = $count_total + 1;

                if (optional($di->purchaseOrderItem)->delivery_status == 4) {
                    $count_delivered = $count_delivered + 1;     
                }elseif(optional($di->purchaseOrderItem)->delivery_status == 3){
                    $count_returned = $count_returned + 1;    
                }else{
                    $count_pending = $count_pending + 1;
                }

            }

            if ($count_total == $count_delivered) {
                return '<span class="badge bg-green">Completed</span>';
            }else{
                return '<span class="badge bg-orange">'. $count_returned .' Returned, '. $count_pending .' Pending</span>';
            }
            
        }

        return '<span class="badge bg-orange">Pending ..</span>';

    }



    /** RELATIONSHIPS **/
    public function deliveryItem() {
        return $this->hasMany('App\Models\DeliveryItem','delivery_id','delivery_id');
    }


    
}
