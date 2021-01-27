<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemInterface;
use App\Core\Interfaces\ItemCategoryInterface;
use App\Core\Interfaces\ItemBatchInterface;
use App\Core\Interfaces\ItemLogInterface;
use App\Core\Interfaces\ItemRawMatInterface;
use App\Core\Interfaces\ItemPackMatInterface;
use App\Core\BaseClasses\BaseService;
use Conversion;

class ItemService extends BaseService{


    protected $item_repo;
    protected $item_cat_repo;
    protected $item_batch_repo;
    protected $item_log_repo;
    protected $item_raw_mat_repo;
    protected $item_pack_mat_repo;



    public function __construct(ItemInterface $item_repo, 
                                ItemCategoryInterface $item_cat_repo, 
                                ItemBatchInterface $item_batch_repo, 
                                ItemLogInterface $item_log_repo, 
                                ItemRawMatInterface $item_raw_mat_repo, 
                                ItemPackMatInterface $item_pack_mat_repo){

        $this->item_repo = $item_repo;
        $this->item_cat_repo = $item_cat_repo;
        $this->item_batch_repo = $item_batch_repo;
        $this->item_log_repo = $item_log_repo;
        $this->item_raw_mat_repo = $item_raw_mat_repo;
        $this->item_pack_mat_repo = $item_pack_mat_repo;
        parent::__construct();

    }





    public function fetch($request){

        $items = $this->item_repo->fetch($request);

        $request->flash();
        return view('dashboard.item.index')->with('items', $items);

    }






    public function store($request){

        $item = $this->item_repo->store($request);

        if(!empty($request->row_raw)){
            foreach ($request->row_raw as $row_raw) {
                $item_raw_mat_orig = $this->item_repo->findByItemId($row_raw['item']);
                $this->item_raw_mat_repo->store($row_raw, $item, $item_raw_mat_orig);
            }
        }

        if(!empty($request->row_pack)){
            foreach ($request->row_pack as $row_pack) {
                $item_pack_mat_orig = $this->item_repo->findByItemId($row_pack['item']);
                $this->item_pack_mat_repo->store($row_pack, $item, $item_pack_mat_orig);
            }
        }
        
        $this->event->fire('item.store');
        return redirect()->back();

    }






    public function edit($slug){

        $item = $this->item_repo->findbySlug($slug);
        return view('dashboard.item.edit')->with('item', $item);

    }






    public function update($request, $slug){

        $item = $this->item_repo->update($request, $slug);

        if(!empty($request->row_raw)){
            foreach ($request->row_raw as $row_raw) {
                $item_raw_mat_orig = $this->item_repo->findByItemId($row_raw['item']);
                $this->item_raw_mat_repo->store($row_raw, $item, $item_raw_mat_orig);
            }
        }

        if(!empty($request->row_pack)){
            foreach ($request->row_pack as $row_pack) {
                $item_pack_mat_orig = $this->item_repo->findByItemId($row_pack['item']);
                $this->item_pack_mat_repo->store($row_pack, $item, $item_pack_mat_orig);
            }
        }

        $this->event->fire('item.update', $item);
        return redirect()->route('dashboard.item.index');

    }






    public function destroy($slug){

        $item = $this->item_repo->destroy($slug);

        $this->event->fire('item.destroy', $item);
        return redirect()->back();

    }






    public function checkIn($slug){

        $item = $this->item_repo->findbySlug($slug);
        return view('dashboard.item.check_in')->with('item', $item);

    }






    public function checkInPost($request, $slug){

        $amount = 0;

        $item = $this->item_repo->findbySlug($slug);

        if ($item->unit != 'PCS') {
            $amount = Conversion::convert($this->__dataType->string_to_num($request->amount), $request->unit)->to($item->unit)->format(3,'.','');
        }else{
            $amount = $this->__dataType->string_to_num($request->amount);
        }

        // Storing Batch
        $item_batch = $this->item_batch_repo->store($request, $item);

        // Storing Logs
        $item_log = $this->item_log_repo->storeCheckIn($request, $item, $item_batch);

        // Updating Current Balance
        $this->item_repo->updateCheckIn($amount, $item);

        $this->event->fire('item.check_in', $item);

        return redirect()->back();

    }






    public function checkInExistingBatch($slug){

        $item = $this->item_repo->findbySlug($slug);
        $item_batches = $this->item_batch_repo->getByItemId($item->item_id);

        return view('dashboard.item.check_in_existing_batch')->with([
            'item' => $item,
            'item_batches' => $item_batches,
        ]);

    }






    public function checkInExistingBatchPost($request, $slug){

        $amount = 0;

        $item = $this->item_repo->findbySlug($slug);

        if ($item->unit != 'PCS') {
            $amount = Conversion::convert($this->__dataType->string_to_num($request->amount), $request->unit)->to($item->unit)->format(3,'.','');
        }else{
            $amount = $this->__dataType->string_to_num($request->amount);
        }

        // Updating Batch
        $item_batch = $this->item_batch_repo->updateCheckIn($request->batch_code, $amount);

        // Storing Logs
        $item_log = $this->item_log_repo->storeCheckIn($request, $item, $item_batch);

        // Updating Current Balance
        $this->item_repo->updateCheckIn($amount, $item);

        $this->event->fire('item.check_in', $item);

        return redirect()->back();

    }







    public function checkOut($slug){

        $item = $this->item_repo->findbySlug($slug);
        return view('dashboard.item.check_out')->with('item', $item);

    }






    public function checkOutPost($request, $slug){

        $amount = 0;
        $request_amount = $this->__dataType->string_to_num($request->amount);
        $item = $this->item_repo->findbySlug($slug);
        $item_batches = $item->itemBatch()
                             ->where('amount', '>' , 0)
                             ->whereDate('expiry_date', '>=' , $this->carbon->now()->format('Y-m-d'))
                             ->orderBy('updated_at')
                             ->get();

        if ($item->unit != 'PCS') {
            $amount = Conversion::convert($request_amount, $request->unit)->to($item->unit)->format(3,'.','');
        }else{
            $amount = $request_amount;
        }
        
        if ($item->current_balance > $amount) {
            
            // Storing Logs
            $item_log = $this->item_log_repo->storeCheckOut($request, $item);

            // Updating Current Balance
            $this->item_repo->updateCheckOut($amount, $item); 

            // Updating Batches
            foreach ($item_batches as $key => $item_batch) {
                
                $request_amount;
                $batch_amount = $item_batch->amount;
                $request_amount_converted = $request_amount;

                if ($item->unit != 'PCS') {
                    $batch_amount = Conversion::convert($item_batch->amount, $item_batch->unit)->to($request->unit)->format(3,'.','');                  
                    $request_amount_converted = Conversion::convert($request_amount, $request->unit)->to($item_batch->unit)->format(3,'.','');
                }

                if ($request_amount >= 0) {
                    if ($request_amount_converted >= $batch_amount) {
                        $this->item_batch_repo->updateCheckOut($item_batch->batch_id, $batch_amount);
                    }else{
                        $this->item_batch_repo->updateCheckOut($item_batch->batch_id, $request_amount_converted);
                    }  
                }  

                $request_amount -= $batch_amount;

            }

            $this->event->fire('item.check_out', $item);

        }else{
            $this->session->flash('ITEM_INSUFFICIENT_BALANCE', 'You dont have enough balance to checkout !');
        }

        return redirect()->back();

    }






    public function checkOutByBatch($slug){

        $item = $this->item_repo->findbySlug($slug);
        $item_batches = $this->item_batch_repo->getByItemId($item->item_id);

        return view('dashboard.item.check_out_by_batch')->with([
            'item' => $item,
            'item_batches' => $item_batches,
        ]);

    }






    public function checkOutByBatchPost($request, $slug){

        $amount = 0;
        $request_amount = $this->__dataType->string_to_num($request->amount);
        $item = $this->item_repo->findbySlug($slug);

        if ($item->unit != 'PCS') {
            $amount = Conversion::convert($request_amount, $request->unit)->to($item->unit)->format(3,'.','');
        }else{
            $amount = $request_amount;
        }
        
        if ($item->current_balance > $amount) {

            // Updating Batch
            $item_batch = $this->item_batch_repo->updateCheckOutByBatchCode($request->batch_code, $amount);
            
            // Storing Logs
            $item_log = $this->item_log_repo->storeCheckOut($request, $item, $item_batch);

            // Updating Current Balance
            $this->item_repo->updateCheckOut($amount, $item); 

            $this->event->fire('item.check_out', $item);

        }else{
            $this->session->flash('ITEM_INSUFFICIENT_BALANCE', 'You dont have enough balance to checkout !');
        }

        return redirect()->back();

    }





    public function logs($request){

        $logs = $this->item_log_repo->fetch($request);

        $request->flash();
        return view('dashboard.item.logs')->with('logs', $logs);

    }





    public function logsUpdateRemarks($id, $request){
        
        $log = $this->item_log_repo->updateRemarks($id, $request);
        $this->event->fire('item.update_logs_remarks', $log);
        return redirect()->back();

    }





    public function fetchBatchByItem($slug, $request){

        $item = $this->item_repo->findbySlug($slug);
        $batches = $this->item_batch_repo->fetchByItem($item->item_id, $request);

        $request->flash();
        return view('dashboard.item.batch_by_item')->with(['batches' => $batches, 'slug' => $item->slug]);

    }





    public function batchAddRemarks($batch_id, $request){

        $batch = $this->item_batch_repo->updateRemarks($batch_id, $request->remarks);
        $this->event->fire('item.add_batch_remarks', $batch);
        return redirect()->back();

    }





    public function fetchLogsByItem($slug, $request){

        $item = $this->item_repo->findbySlug($slug);
        $logs = $this->item_log_repo->fetchByItem($item->item_id, $request);

        $request->flash();
        return view('dashboard.item.logs_by_item')->with(['logs' => $logs, 'slug' => $item->slug]);

    }



    public function reportsOutput($request){ 

            if($request->s == 1){

                $items = $this->item_repo->inventoryAll($request);

                if($request->type == 1){

                    return view('printables.item.current_inventory_count')->with([
                        'items' => $items,
                        'item_cat_name' => ''
                    ]);
                
                }elseif($request->type == 2){

                    return view('printables.item.current_inventory_cost')->with([
                        'items' => $items,
                        'item_cat_name' => ''
                    ]);

                }else{
                    abort(404);
                }

            }elseif($request->s == 2){

                $items = $this->item_repo->inventoryByCategory($request);
                $item_cat = $this->item_cat_repo->findByItemCatId($request->ic);

                if($request->type == 1){

                    return view('printables.item.current_inventory_count')->with([
                        'items' => $items,
                        'item_cat_name' => $item_cat->name
                    ]);
                
                }elseif($request->type == 2){

                    return view('printables.item.current_inventory_cost')->with([
                        'items' => $items,
                        'item_cat_name' => $item_cat->name
                    ]);

                }else{
                    abort(404);
                }

            }else{
                abort(404);
            }

    }






}