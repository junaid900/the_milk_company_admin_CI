<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductTiming extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = PRODUCT_TIMING_TABLE;
        $this->alias = PRODUCT_TIMING_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     public function add(){
        if (!isset($_REQUEST['product_id']) || !isset($_REQUEST['time'])) {
            response(0, "missing params", []);
        }
        $arr["time"] = $_REQUEST['time'];
        $arr["product_id"] = $_REQUEST['product_id'];
         $res = $this->db->insert($this->table,$arr);
        if($res){
            response(1, "success", $res);
        }else{
            response(0, "failed", $res);
        }
        
     }
     public function get_by_product(){
        if (!isset($_REQUEST['product_id'])) {
            response(0, "missing params", []);
        }
        $prodId = $_REQUEST['product_id'];
        $res = $this->db->get_where($this->table,["product_id"=>$prodId])->result();
        if($res){
            response(1, "success", $res);
        }else{
            response(0, "failed", $res);
        }
        
     }
     public function delete($id,$status){
         $res = $this->db->update($this->table , ["status" => $status], [$this->alias . "_id"=>$id]);
         if($res){
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
     
     
    
    
}    