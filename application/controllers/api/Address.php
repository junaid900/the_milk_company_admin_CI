<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Address extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = USER_ADDRESS_TABLE;
        $this->alias = USER_ADDRESS_ALS;
        parent::__construct();    
    }
    
    public function get(){
        if (!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $user_id = $_REQUEST['user_id'];
        $userAddress = $this->db->get_where($this->table,["user_id"=>$user_id])->result();
        response(1,"Success",$userAddress);
    }
    public function add(){
         if (!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        if (!isset($_REQUEST['lat'])) {
            response(0, "missing params", []);
        }
        if (!isset($_REQUEST['lng'])) {
            response(0, "missing params", []);
        }
        $data = array();
        $data["user_id"] = $_REQUEST['user_id'];
        $data["lat"] = $_REQUEST['lat'];
        $data["lng"] = $_REQUEST['lng'];
        
        if(isset($_REQUEST['address']))
            $data["address"] = $_REQUEST['address'];
        
        if(isset($_REQUEST['name']))
            $data["name"] = $_REQUEST['name'];
        
        $userAddress = $this->db->insert($this->table,$data);
        // print($this->db->last_query());
        if($userAddress)
            response(1,"Success",$userAddress);
        else
            response(0,"Cannot insert address",$userAddress);
    }
     public function edit(){
         if (!isset($_REQUEST['id'])) {
            response(0, "missing params", []);
        }
        if (!isset($_REQUEST['name'])) {
            response(0, "missing params", []);
        }
        if (!isset($_REQUEST['address'])) {
            response(0, "missing params", []);
        }
        $data = array();
        // $data["user_address_id"] = $_REQUEST['id'];
        $id = $_REQUEST['id'];
        $data["name"] = $_REQUEST['name'];
        $data["address"] = $_REQUEST['address'];
        
        
        $userAddress = $this->db->update($this->table,$data,["user_address_id"=>$id]);
        // print($this->db->last_query());
        if($userAddress)
            response(1,"Success",$userAddress);
        else
            response(0,"Cannot insert address",$userAddress);
    }
    public function delete(){ 
        if (!isset($_REQUEST['address_id'])) {
            response(0, "missing params", []);
        }
        $userAddress = $this->db->delete($this->table,[$this->alias."_id" => $_REQUEST['address_id']]);
        response(1,"Success",$userAddress);
    }
    
}