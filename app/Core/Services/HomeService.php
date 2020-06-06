<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\TaskInterface;
use App\Core\Interfaces\DeliveryInterface;
use App\Core\Interfaces\UserInterface;
use App\Core\Interfaces\ItemLogInterface;
use App\Core\BaseClasses\BaseService;



class HomeService extends BaseService{



    protected $po_repo;
    protected $task_repo;
    protected $delivery_repo;
    protected $user_repo;
    protected $item_log_repo;



    public function __construct(PurchaseOrderInterface $po_repo,
    							TaskInterface $task_repo,
    							DeliveryInterface $delivery_repo,
    							UserInterface $user_repo,
                                ItemLogInterface $item_log_repo){

        $this->po_repo = $po_repo;
        $this->task_repo = $task_repo;
        $this->delivery_repo = $delivery_repo;
        $this->user_repo = $user_repo;
        $this->item_log_repo = $item_log_repo;
        parent::__construct();

    }





    public function view(){

        return view('dashboard.home.index')->with([

        	'count_new_po' => $this->po_repo->countNew(),
        	'count_new_tasks' => $this->task_repo->countNew(),
        	'count_new_deliveries' => $this->delivery_repo->countNew(),
        	'count_online_users' => $this->user_repo->countByIsOnline(1),
            'get_current_month_item_logs' => $this->item_log_repo->checkedOutFinishGoodsCurrentMonth(),

        ]);

    }








}