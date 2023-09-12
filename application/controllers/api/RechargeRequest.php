<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RechargeRequest extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = RECHARGE_REQUEST_TABLE;
        $this->alias = RECHARGE_REQUEST_ALS;
        parent::__construct();    
        
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     public function get(){
         if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        //  print("here");
         $this->db->limit(2000);
         $this->db->select("a.user_name as emp_name,a.phone as emp_phone, a.user_id as emp_id,b.user_name as user_name,b.phone as user_phone, b.user_id as user_id,c.*");
         $this->db->join(USER_TABLE." a" , 'c.emp_id = a.user_id');
         $this->db->join(USER_TABLE." b" , 'c.user_id = b.user_id');
         $data = $this->db->get($this->table . " c")->result();
        if($data){
            response(1,"success",$data);
        }else{
            response(0,"failed",[]);
        }
     }
     public function add(){
        //  print_r($_REQUEST);/
         if (!isset($_REQUEST['order_id']) || !isset($_REQUEST['emp_id'])  || !isset($_REQUEST['amount']) || !isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $req = $this->db->get_where($this->table,["order_id"=>$_REQUEST['order_id']])->result();
        if(count($req) > 0){
             response(0,"request has already been submitted",[]);
        }
        $arr = array();
        $arr["order_id"] = $_REQUEST['order_id'];
        $arr["emp_id"] = $_REQUEST['emp_id'];
        $arr["user_id"] = $_REQUEST['user_id'];
        $arr["amount"] = $_REQUEST['amount'];
        $res = $this->db->insert($this->table,$arr);
        if($res){
             $this->sendNotification($arr["user_id"],"Your recharge request submitted","request for amount ". $arr["amount"] . " has been submitted",NEW_ORDER_IMAGE,"Single",$id,"recharge_request");
            $this->sendNotification($arr["user_id"],"Received recharge request","request for amount ". $arr["amount"] . " has been submitted",NEW_ORDER_IMAGE,"Admin",$_REQUEST,"recharge_request");
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
    }
    //  public function edit(){
    //     //  print_r($_REQUEST);/
    //     if (!isset($_REQUEST['title']) || !isset($_REQUEST['id']) || !isset($_REQUEST['photo'])  || !isset($_REQUEST['description'])) {
    //         response(0, "missing params", []);
    //     }
    //     $arr = array();
    //     $id = $_REQUEST['id'];
    //     $arr["banner_title"] = $_REQUEST['title'];
    //     $arr["description"] = $_REQUEST['description'];
    //     if(!empty($_REQUEST['photo'])){
    //         $arr["banner_image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"banners");
    //     }
    //     $res = $this->db->update($this->table,$arr,[$this->alias."_id"=>$id]);
    //     if($res){
    //         response(1,"success",$this->return_all());
    //     }else{
    //         response(0,"failed",[]);
    //     }
        
    // }
     public function updateStatus($id,$status){
         $req = $this->db->get_where($this->table , ["recharge_request_id"=>$id])->first_row();
         if($req->status == "Completed"){
             response(0,"status already completed",[]);
         }
         if($status == "Completed"){
             $wallet = $this->db->get_where(WALLET_TABLE,["user_id"=>$req->user_id])->first_row();
             $walletRes = $this->db->update(WALLET_TABLE,["available_amount"=>$wallet->available_amount + $req->amount],["wallet_id"=>$wallet->wallet_id]); 
             if(!$walletRes){
                 response(0,"error while recharging wallet",[]);
             }
              $this->sendNotification($req->user_id,"Your recharge request completed","request for amount ". $req->amount . " has been completed and added to your wallet",NEW_ORDER_IMAGE,"Single",$id,"recharge_request");
            $this->sendNotification($req->user_id,"You accepted recharge request","request for amount ". $req->amount . " has been completed by admin",NEW_ORDER_IMAGE,"Admin",$_REQUEST,"recharge_request");
              $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$req->user_id,"description"=>"amount added on recharge request accepted: request no $id","amount"=>"Added","amount"=>$req->amount],"recharge_request");
         }
         $res = $this->db->update($this->table , ["status" => $status], [$this->alias . "_id"=>$id]);
         
         if($res){
            
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
    //  public function delete($id){
    //      $res = $this->db->delete($this->table , [$this->alias . "_id"=>$id]);
    //      if($res){
    //          response(1,"success",[]);
    //      }else{
    //          response(0,"failed",[]);
    //      }
    //  }
     
     
    
    
}    