<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banners extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = BANNER_TABLE;
        $this->alias = BANNER_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     public function add(){
        //  print_r($_REQUEST);/
         if (!isset($_REQUEST['title']) || !isset($_REQUEST['photo'])  || !isset($_REQUEST['description'])) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["banner_title"] = $_REQUEST['title'];
        $arr["description"] = $_REQUEST['description'];
        $arr["banner_image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"banners");
        $res = $this->db->insert($this->table,$arr);
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
    }
     public function edit(){
        //  print_r($_REQUEST);/
        if (!isset($_REQUEST['title']) || !isset($_REQUEST['id']) || !isset($_REQUEST['photo'])  || !isset($_REQUEST['description'])) {
            response(0, "missing params", []);
        }
        $arr = array();
        $id = $_REQUEST['id'];
        $arr["banner_title"] = $_REQUEST['title'];
        $arr["description"] = $_REQUEST['description'];
        if(!empty($_REQUEST['photo'])){
            $arr["banner_image"] = $this->uploadDirBase64Image($_REQUEST['photo'],"banners");
        }
        $res = $this->db->update($this->table,$arr,[$this->alias."_id"=>$id]);
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