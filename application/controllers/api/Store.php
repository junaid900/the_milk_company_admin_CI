<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends MJ_Controller
{   
    
    public function __construct()
    {
        $this->table = STORE_TABLE;
        $this->alias = STORE_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo CATEGORY_TABLE . CATEGORY_ALS;
        exit;
     }
     public function add(){
         if (!isset($_REQUEST['name']) || !isset($_REQUEST['address']) || !isset($_REQUEST['lat']) || !isset($_REQUEST['lng']) ) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["store_name"] = $_REQUEST['name'];
        $arr["store_address"] = $_REQUEST['address'];
        $arr["lat"] = $_REQUEST['lat'];
        $arr["lng"] = $_REQUEST['lng'];
        $res = $this->db->insert($this->table,$arr);
        if($res){
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
    }
    public function edit(){
        //  print_r($_REQUEST);/
       if (!isset($_REQUEST['name']) || !isset($_REQUEST['address']) || !isset($_REQUEST['lat']) || !isset($_REQUEST['lng']) || !isset($_REQUEST['id']) ) {
            response(0, "missing params", []);
        }
        $arr = array();
        $arr["store_name"] = $_REQUEST['name'];
        $arr["store_address"] = $_REQUEST['address']; 
        $arr["lat"] = $_REQUEST['lat'];
        $arr["lng"] = $_REQUEST['lng'];
        // $arr["category_name"] = $_REQUEST['name'];
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
            response(1,"success",$this->return_all());
        }else{
            response(0,"failed",[]);
        }
     }
     public function get_drivers($id){
         if(empty($id)) response(0,"invalid store",[]);
         $data = $this->db->get_where(USER_TABLE,["store_id"=>$id,"role_id"=>4])->result();
         if(!empty($data)){
            response(1,"success",$data);
         }else{
             response(1,"no driver found",[]);
         }
     }
     
     
    
    
}