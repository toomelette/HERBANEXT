<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemInterface;
use App\Core\Interfaces\ItemBatchInterface;
use App\Core\Interfaces\ItemLogInterface;
use App\Core\Interfaces\ItemRawMatInterface;
use App\Core\Interfaces\ItemPackMatInterface;
use App\Core\BaseClasses\BaseService;
use Conversion;

class ItemService extends BaseService{


    protected $item_repo;
    protected $item_batch_repo;
    protected $item_log_repo;
    protected $item_raw_mat_repo;
    protected $item_pack_mat_repo;



    public function __construct(ItemInterface $item_repo, ItemBatchInterface $item_batch_repo, ItemLogInterface $item_log_repo, ItemRawMatInterface $item_raw_mat_repo, ItemPackMatInterface $item_pack_mat_repo){

        $this->item_repo = $item_repo;
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
        $item_log = $this->item_log_repo->storeCheckIn($request, $item);

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





    public function logs($request){

        $logs = $this->item_log_repo->fetch($request);

        $request->flash();
        return view('dashboard.item.logs')->with('logs', $logs);

    }





    public function fetchBatchByItem($slug, $request){

        $item = $this->item_repo->findbySlug($slug);
        $batches = $this->item_batch_repo->fetchByItem($item->item_id, $request);

        $request->flash();
        return view('dashboard.item.batch_by_item')->with(['batches' => $batches, 'slug' => $item->slug]);

    }





    public function fetchLogsByItem($slug, $request){

        $item = $this->item_repo->findbySlug($slug);
        $logs = $this->item_log_repo->fetchByItem($item->item_id, $request);

        $request->flash();
        return view('dashboard.item.logs_by_item')->with(['logs' => $logs, 'slug' => $item->slug]);

    }






}