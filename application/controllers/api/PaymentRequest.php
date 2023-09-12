<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentRequest extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = PAYMENT_REQUEST_TABLE;
        $this->alias = PAYMENT_REQUEST_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
    public function get_with_user(){
        // $this->orderBy();
        $this->db->limit($this->limit,$this->offset);
        $this->orderBy = 'desc';
        if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        // $this->db->join("categ");
        $this->db->select($this->table . ".* , user_name, email,phone");
        $this->db->join(USER_TABLE,USER_ALS . "_id" , $this->table . "user_id");
        $data = $this->db->get($this->table)->result();
        return response(1,"Success",$data);
    }
    public function update_payment_status(){
        if (!isset($_REQUEST['status']) || !isset($_REQUEST['user_id']) || !isset($_REQUEST['id'])) {
            response(0, "missing params", []);
        }
        $status = $_REQUEST['status'];
        $user_id = $_REQUEST['user_id'];
        $id = $_REQUEST['id'];
        // $this->orderBy = "desc";
        if($status == "Accepted"){
            if (!isset($_REQUEST['amount'])) {
                response(0, "missing params", []);
            }
            $amount = $_REQUEST['amount'];
            // $this->db->order_by()/;
            if($this->orderBy){
                $this->db->order_by(WALLET_ALS."_id",$this->orderBy);
            }
            $wallet = $this->getOne(WALLET_TABLE,"user_id",$user_id);
            $response = $this->db->update(WALLET_TABLE, ["available_amount"=>$wallet->available_amount + $amount],["wallet_id"=>$wallet->wallet_id]);
            if($response){
                $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$user_id,"description"=>"amount added by admin Ref-$id","amount"=>"Add","amount"=>$amount]);
                $this->sendNotification($user_id,PAYMENT_REQUEST_ACCEPTED_TITLE,PAYMENT_REQUEST_ACCEPTED,PAYMENT_REQUEST_IMAGE,"Single",$_REQUEST);

                $res = $this->db->update($this->table,["admin_status"=>$status,"status"=>"Inactive"],[$this->alias."_id"=>$id]);
                if($res) $this->get_with_user(); else response(0, "unable to update information", []);
            }
        }else{
             $res = $this->db->update($this->table,["admin_status"=>$status,"status"=>"Inactive"],[$this->alias."_id"=>$id]);
             if($res) $this->get_with_user(); else response(0, "unable to update information", []);
        }
    }
     
     
    
    
}    