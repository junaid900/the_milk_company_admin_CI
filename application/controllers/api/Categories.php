<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = CATEGORY_TABLE;
        $this->alias = CATEGORY_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        echo CATEGORY_TABLE . CATEGORY_ALS;
        exit;
     }
     public function add(){
        //  print_r($_REQUEST);/
         if (!isset($_REQUEST['name']) ) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["category_name"] = $_REQUEST['name'];
        $res = $this->db->insert($this->table,$arr);
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
    }
     public function edit(){
        //  print_r($_REQUEST);/
       if (!isset($_REQUEST['name']) ) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["category_name"] = $_REQUEST['name'];
        $id = $_REQUEST['id'];
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