<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MJ_Controller
{   
    
      public function __construct()
    {
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     public function update(){
          if(!isset($_REQUEST['user_id'])){
                response(0,"Missing params",[]);
            }
            $arr = array();
            $user_id = $_REQUEST['user_id'];
            if(isset($_REQUEST['first_name'])){
                if(!empty($_REQUEST['first_name']))
                $arr["first_name"] = $_REQUEST['first_name'];
            }
     
            if(isset($_REQUEST['last_name'])){
                if(!empty($_REQUEST['last_name']))
                $arr["last_name"] = $_REQUEST['last_name'];
            }
            if(isset($_REQUEST['dob'])){
                if(!empty($_REQUEST['dob']))
                $arr["dob"] = $_REQUEST['dob'];
            }
            if(isset($_REQUEST['email'])){
                if(!empty($_REQUEST['email']))
                $arr["email"] = $_REQUEST['email'];
            }
            // print_r($arr);
             $res = $this->db->update($this->table,$arr,["user_id"=>$user_id]);
            //  echo $this->db->last_query();
            if($res){
                $user_response = $this->db->get_where($this->table,["user_id"=>$user_id])->first_row();
                 response(1,"Success",$user_response);
            }else{
                response(0,"Failed to upload",[]);
            }
            
     }
     public function getUser($id){
         $user = $this->db->get_where(USER_TABLE,[USER_ALS."_id"=>$id])->first_row();
         response(1,"success",$user);
     }
     public function upload_image(){
        
       
        if(!isset($_REQUEST['img']) || !isset($_REQUEST['user_id'])){
            response(0,"Missing params",[]);
        }
        
        $img = $_REQUEST['img'];
        $user_id = $_REQUEST['user_id'];
        $data = base64_decode($img);
        $file = "uploads/user/" . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        
        if($success){
            $res = $this->db->update($this->table,["profile_picture"=>$file],["user_id"=>$user_id]);
            if($res){
               $user_response = $this->db->get_where($this->table,["user_id"=>$user_id])->first_row();
                response(1,"Success",$user_response);
            }
            response(0,"Failed",[]);
        }else{
            response(0,"Failed to upload",[]);
        }
        // $file_name = time() . '_image.jpg';
        // $path_to_file = 'uploads/products_watermark/' . $file_name;
        // move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
     
        
     }
     
     public function add(){
        if (!isset($_REQUEST['email']) || !isset($_REQUEST['password']) || !isset($_REQUEST["first_name"]) || !isset($_REQUEST["last_name"]) || !isset($_REQUEST['phone'])) {
            response(0, "missing params", []);
        }
        $profile_picture = null;
        if(!empty($_REQUEST['photo'])){
            $profile_picture = $this->uploadDirBase64Image($_REQUEST['photo'],"user");
        }
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['phone'];
        // $user_name = 
        $checkUser = $this->db->get_where($this->table, ["phone" => $phone]);
        
        if ($checkUser) {
            if (count($checkUser->result()) > 0) {
                if($checkUser->first_row()->is_activate == 0){
                    response(2, "this phone is already in use. please verify your account", $user);
                }
                response(0, "this phone is already in use", $user);
            }
        }
        $first_name = $_REQUEST['first_name'];
        $phone = $_REQUEST['phone'];
        $last_name = $_REQUEST['last_name'];
        $user_name = $first_name . " " . $last_name;
        $password = md5($_REQUEST["password"]);
        // $phone = $_REQUEST['phone'];
        $role = $_REQUEST['role'];
        $role_name = $_REQUEST['role_name'];
        $ref = $this->generateRef();
        $store_id = $_REQUEST['store_id'] == "0"?NULL:$_REQUEST['store_id'];
        // if()
        
        $userArray = ["referal"=>$ref,"store_id"=>$store_id,"is_activate"=>1,"user_name"=>$user_name,"role_id"=>$role,"role"=>$role_name,"email" => $email, "password" => $password, "first_name" => $first_name, "last_name" => $last_name,'phone'=>$phone,"profile_picture"=>$profile_picture];
        $user = $this->db->insert($this->table, $userArray);
        if($user){
            $id = $this->db->insert_id();
            // if($role == "3"){
            $wal = $this->db->insert(WALLET_TABLE,['user_id'=>$id]);
            // }
            
            response(1,"success", $this->return_all());
        }else{
            response(0,"failed",[]);
        }
        
        
     }
     public function searchUser(){
        if(!isset($_REQUEST['query'])){
            response(0,"Missing params",[]);
        }
        $query = $_REQUEST['query'];
        $data = $this->db->query("select * from ".$this->table." where user_name LIKE '%$query%' OR email LIKE '%$query%' OR phone LIKE '%$query%'")->result();
        response(1,"Success",$data);
     }
     public function inactive($id,$status){
         $res = $this->db->update($this->table , ["is_activate" => $status], [$this->alias . "_id"=>$id]);
         if($res){
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
     public function block($id,$status){
        // echo $status;
         $res = $this->db->update($this->table , ["is_blocked" => $status], [$this->alias . "_id"=>$id]);
         if($res){
             response(1,"success",[]);
         }else{
             response(0,"failed",[]);
         }
     }
     public function admin_login(){
        //  $input = $_REQUEST;
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        // print_r($_POST);
        
         if(!isset($_REQUEST['phone']) || !isset($_REQUEST['password'])) {
            response(0, "missing params", []);
        }
        
        $phone = $_REQUEST['phone'];
        $password = md5($_REQUEST["password"]);
        
        // $tokenId = generateToken();
        $sessionId = generateSession();
        
        $user = $this->db->get_where($this->table, ["phone" => $phone, "password" => $password]);
        if (!$user) {
            response(0, "unable to get response", []);
        }
        $data = $user->result();
        if (count($data) != 1) {
            response(0, "invalid credentials", []);
        }
        $userData = $user->first_row();
        if($userData->is_activate != 1){
            response(0, "please signup again and verify account", []);
        }
        if($userData->role_id == "3"){
            response(0, "you have no access to login", []);
        }
        
        // $date = date("Y-m-d h:i:s", strtotime($date . ' +2 day'));
        $this->db->update($this->table, ["session_id" => $sessionId], [$this->alias."_id" => $userData->user_id]);
        $userData->session_id = $sessionId;
        response(1, "successfully loggedIn", $userData);
        
     }
     
     
    public function checkRef($ref){
        $res = $this->db->get_where($this->table,['referal'=>$ref])->result();
        return count($res) < 1;
    }
    public function generateRef(){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $times = 0;
        
        while(true){
            if($times > 10){
                $ref = rand() . date('dmhis');
                if($this->checkRef($ref)){
                     break;
                }else{
                    continue;
                }
            }
            $ref = substr(str_shuffle($permitted_chars), 0, 10);
            if($this->checkRef($ref)){
                break;
            }
            
            $times++;
        }
        return $ref;
    }
    
}    