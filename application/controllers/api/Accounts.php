<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = ACCOUNT_TABLE;
        $this->alias = ACCOUNT_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     
     public function saveRequest(){
         if(!isset($_REQUEST['img']) || !isset($_REQUEST['user_id']) || !isset($_REQUEST['desc'])){
            response(0,"Missing params",[]);
        }
        $arr = array();
        $arr['user_id'] = $_REQUEST['user_id'];
        $arr['slip_image'] = $_REQUEST['img'];
        $arr['description'] = $_REQUEST['desc'];
        
        $res = $this->db->insert(PAYMENT_REQUEST_TABLE,$arr);
         if($res){
            response(1,"Success",[]);
        }else{
            response(0,"Failed to upload",[]);
        }
     }
     
      public function add(){
        //  print_r($_REQUEST);/
         if (!isset($_REQUEST['name']) || !isset($_REQUEST['photo'])  || !isset($_REQUEST['description']) || !isset($_REQUEST['account_no'])) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["account_name"] = $_REQUEST['name'];
        $arr["account_no"] = $_REQUEST['account_no'];
        $arr["description"] = $_REQUEST['description'];
        $arr["image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"payment");
        $res = $this->db->insert($this->table,$arr);
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
    }
     public function edit(){
        //  print_r($_REQUEST);/
         if (!isset($_REQUEST['name'])  || !isset($_REQUEST['description']) || !isset($_REQUEST['id']) || !isset($_REQUEST['account_no'])) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["account_name"] = $_REQUEST['name'];
        $arr["account_no"] = $_REQUEST['account_no'];
        $arr["description"] = $_REQUEST['description'];
        $id = $_REQUEST['id'];
        // $arr["image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"banners");
        if(!empty($_REQUEST['photo'])){
            $arr["image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"payment");
        }
        $res = $this->db->update($this->table,$arr,[$this->alias."_id"=>$id]);
        // echo $this->db->last_query();
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
    }
     public function inactive($id,$status){
         $res = $this->db->update($this->table , ["status" => $status], [$this->alias . "_id"=>$id]);
         if($res){
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
     public function delete($id){
         $res = $this->db->delete($this->table , [$this->alias . "_id"=>$id]);
         if($res){
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
     
    
    
}    