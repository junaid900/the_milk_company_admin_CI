<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = PRODUCT_TABLE;
        $this->alias = PRODUCT_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        echo PRODUCT_TABLE . PRODUCT_ALS;
        exit;
     }
   
    public function add(){
         if (!isset($_REQUEST['product_name']) || !isset($_REQUEST['product_description']) || 
         !isset($_REQUEST['category'])|| !isset($_REQUEST['times']) || 
         !isset($_REQUEST['price'])|| !isset($_REQUEST['photo'])) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["product_name"] = $_REQUEST['product_name'];
        $arr["product_description"] = $_REQUEST['product_description'];
        $arr["category_id"] = $_REQUEST['category'];
        $arr["price"] = $_REQUEST['price'];
        $arr["product_image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"products");
        $times = json_decode($_REQUEST['times']);
        $res = $this->db->insert($this->table,$arr);
        if($res){
            $id = $this->db->insert_id();
            foreach($times as $time){
                $this->db->insert(PRODUCT_TIMING_TABLE,["time"=>$time->time,"product_id"=>$id]);
            }
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
        
        
    }
     public function edit(){
         
         if (!isset($_REQUEST['product_id']) || !isset($_REQUEST['product_name']) || !isset($_REQUEST['product_description']) || 
         !isset($_REQUEST['category']) || 
         !isset($_REQUEST['price'])|| !isset($_REQUEST['photo'])) {
            response(0, "missing params", []);
        }
        $id = $_REQUEST['product_id'];
        $arr = array();
        $arr["product_name"] = $_REQUEST['product_name'];
        $arr["product_description"] = $_REQUEST['product_description'];
        $arr["category_id"] = $_REQUEST['category'];
        $arr["price"] = $_REQUEST['price'];
        if(!empty($_REQUEST['photo'])){
            $arr["product_image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"products");
        }
        $times = json_decode($_REQUEST['times']);
        $res = $this->db->update($this->table,$arr,[$this->alias."_id"=>$id]);
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
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