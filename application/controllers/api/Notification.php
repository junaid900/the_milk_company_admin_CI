<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends  MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = NOTIFICATION_TABLE;
        $this->alias = NOTIFICATION_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        echo PRODUCT_TABLE . PRODUCT_ALS;
        exit;
     }
     public function get(){
        if(!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $user_id = $_REQUEST['user_id'];
        $data = $this->db->query("select * from ".$this->table." where (receiver_id = $user_id OR type = 'All') AND type != 'Admin'")->result();
        response(1, "success", $data);
     }
     public function get_admin($type = 'admin',$id = 0){
         
        // $user_id = $_REQUEST['user_id'];
       if($this->orderBy){
            // $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        // $q = "select *, concat("") as desctiption from ".$this->table." where type = 'Admin' order by ".$this->alias . "_id desc";
        if($type == 'store'){
            $data = $this->db->query("select * from ".$this->table." where type = 'Store' and receiver_id = $id order by ".$this->alias . "_id desc")->result();
        }else if($type == 'driver'){
            $data = $this->db->query("select * from ".$this->table." where type = 'Driver' and receiver_id = $id order by ".$this->alias . "_id desc")->result();
        }else{
            $data = $this->db->query("select * from ".$this->table." where type = 'Admin' order by ".$this->alias . "_id desc")->result();
        }
    
        response(1, "success", $data);
     }
     
     
    
    
}    