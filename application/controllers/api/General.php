<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends MJ_Controller
{   
    
      public function __construct()
    {
        // $this->table = PRORUCT_TABLE;
        // $this->alias = PRODUCT_ALS;
        parent::__construct();    
        
    }

    /*****  INDEX *********/
    public function checkSession($session_id){
        $user = $this->check_session($session_id);
        if($user){
            response(1, "success", $user);
        }
         response(4, "session expired", []);
    }
     public function signin(){
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
        if($userData->role_id == "1" || $userData->role_id == "2"){
            response(0, "you have no access to login this application", []);
        }
        
        // $date = date("Y-m-d h:i:s", strtotime($date . ' +2 day'));
        $this->db->update($this->table, ["session_id" => $sessionId], [$this->alias."_id" => $userData->user_id]);
        $userData->session_id = $sessionId;
        response(1, "successfully loggedIn", $userData);
        
     }
      public function signup()
    {
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        $wallet = WALLET_TABLE;
        // print_r($_REQUEST);
        if (!isset($_REQUEST['email']) || !isset($_REQUEST['password']) || !isset($_REQUEST["first_name"]) || !isset($_REQUEST["last_name"]) || !isset($_REQUEST['phone'])) {
            response(0, "missing params", []);
        }
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['phone'];
        $checkUser = $this->db->get_where($this->table, ["phone" => $phone]);
        
        if ($checkUser) {
            if (count($checkUser->result()) > 0) {
                if($checkUser->first_row()->is_activate == 0){
                    $actCode = rand(10000,99999);
                    $user = $this->updateCode($actCode,$phone);
                    $this->sendOTP($phone,$actCode);
                    response(2, "this phone is already in use. please verify your account", $user);
                }
                response(0, "this phone is already in use", $user);
            }
        }
       
        $first_name = $_REQUEST['first_name'];
        $phone = $_REQUEST['phone'];
        $last_name = $_REQUEST['last_name'];
        $password = md5($_REQUEST["password"]);
        $phone = $_REQUEST['phone'];
        $ref = $this->generateRef();
        

        $userArray = ["referal"=>$ref,"email" => $email, "password" => $password, "first_name" => $first_name, "last_name" => $last_name,'phone'=>$phone];
         if(isset($_REQUEST['referal'])){
            if(!empty($_REQUEST['referal'])){
                $referUserResult = $this->db->get_where($this->table, ["referal"=>$_REQUEST['referal']])->result();
                if(count($referUserResult) > 0){
                    $referUser = $referUserResult[0];
                    $userArray['refered_by'] = $referUser->user_id;
                    $userArray['refered_code'] = $_REQUEST['referal'];
                }else{
                    response(0, "invalid referral code if you didn't have one submit with empty field",[]);
                }
            }
        }
        $sessionId = generateSession();
        $userArray["session_id"] = $sessionId;
        $userArray["role_id"] = 3;
        $userArray["role"] = 'user';
        $userArray['user_name'] = $first_name . " " . $last_name;
        $activationCode = rand(10000,99999);
        $userArray["activation_code"] = $activationCode;
        $this->sendOTP($phone,$activationCode);

        $user = $this->db->insert($this->table, $userArray);
        if($user){
            $id = $this->db->insert_id();
            $wal = $this->db->insert($wallet,['user_id'=>$id]);
            // if(isset($userArray['refered_by'])){
            
            // if(isset($userArray["refered_by"])){
            //     if(!empty($userArray['refered_by'])){
            //         $walletId = $this->db->insert_id();
            //         $wallet_detail = $this->db->get_where(WALLET_TABLE , [WALLET_ALS."_id"=>$walletId])->first_row();
            //         $this->db->update(WALLET_TABLE,["available_amount"=>$wallet_detail->available_amount+$this->app_setting['referal_amount']],[WALLET_ALS."_id"=>$walletId]);
            //          $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$id,"description"=>"amount added on using referal","amount"=>"Added","amount"=>$this->app_setting['referal_amount']]);
            //     }                
            // }
        }
        if (!$user) {
            response(0, "unable to get response", []);
        }
       // $userId = $this->db->insert_id();
        $user = $this->db->get_where($this->table, [$this->alias."_id" => $id])->first_row();
        
        response(1, "successfully signned up", $user);
    }
    public function forget_password($phone){
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
         $activationCode = rand(10000,99999);
        $users =  $this->db->get_where($this->table, ["phone" => $phone])->result();
        if(count($users) < 1){
            response(0, "invalid phone number", []);

        }
        send_sms($phone,"$activationCode is your The Milk Company reset password code");
        response(1, "successfully sent code", ["code"=>$activationCode]);
        
    }
    public function new_password(){
         $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        if (!isset($_REQUEST['phone']) || !isset($_REQUEST['password'])) {
            response(0, "missing params", []);
        }
        $checkUser = $this->db->get_where($this->table, ["phone" => $_REQUEST['phone']]);
       // echo $this->db->last_query();
        if ($checkUser) {
            if (count($checkUser->result()) < 1) {
                response(0, "invalid request", []);
            }
        }
        $password = md5($_REQUEST['password']);
        $user = $checkUser->first_row();
        
        $res = $this->db->update(USER_TABLE,["password"=>$password],[USER_ALS."_id"=>$user->user_id]);
        if($res){
             response(1, "successfully reset password", []);
        }else{
             response(0, "cannot update password try again", []);
        }
        
    }
    
    public function sendOTP($phone,$code){
         send_sms($phone,"$code is your The Milk Company verification code");
    }
    public function verify(){
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        if (!isset($_REQUEST['phone']) || !isset($_REQUEST['code'])) {
            response(0, "missing params", []);
        }
        $phone = $_REQUEST['phone'];
        $code = $_REQUEST['code'];
        $checkUser = $this->db->get_where($this->table, ["phone" => $phone]);
        
        if ($checkUser) {
            if (count($checkUser->result()) < 1) {
                response(0, "invalid request", []);
            }
        }
        $user = $checkUser->first_row();
        if($user->activation_code != $code){
            response(0, "invalid code", []);
        }
        
        $this->db->update($this->table, ["is_activate" => 1], ["phone" => $phone]);
        response(1, "successfully verified", []);
    }
    public function resend($phone){
        $code = rand(10000,99999);
        response(1, "successfully sent", $this->updateCode($code,$phone));
    }
    public function updateCode($code,$phone)
    {
        $this->table = USER_TABLE;
        $this->alias = USER_ALS;
        $this->db->update($this->table, ["activation_code" => $code], ["phone" => $phone]);
        return $this->db->get_where($this->table, ["phone" => $phone])->first_row();
    }
    public function getWallet(){
        $this->table = WALLET_TABLE;
        $this->alias = WALLET_ALS;
        // TRANSACTION_HISTORY_TABLE
        // TRANSACTION_HISTORY_ALS
        if (!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $result = $this->db->get_where($this->table , ["user_id"=>$_REQUEST['user_id']])->first_row();
        $this->db->limit(1000);
        $result->transations = $this->db->get_where(TRANSACTION_HISTORY_TABLE,["user_id"=>$_REQUEST['user_id']])->result();
        
        $result->no_of_orders = $this->db->query("select count(".ORDER_ALS."_id) as num from ".ORDER_TABLE." where user_id = ".$_REQUEST['user_id']. " and order_status = 'Completed'")->first_row()->num;
        
         $result->no_of_transactions = $this->db->query("select count(".TRANSACTION_HISTORY_ALS."_id) as num from ".TRANSACTION_HISTORY_TABLE." where user_id = ".$_REQUEST['user_id']. "")->first_row()->num;
        
        
    
        response(1,"success",$result);
        
    }
    
    public function uploadBase64Image(){
        if (!isset($_REQUEST['img'])) {
            response(0, "missing params", []);
        }
        $img = $_REQUEST['img'];
        $data = base64_decode($img);
        $file = "uploads/system/" . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        
        if($success){
            response(1,"Success",["url"=>$file]);
        }else{
            response(0,"Failed to upload",[]);
        }
    }
    public function get_dashboard(){
        // echo "<pre>";
        // $ccdate = "'".date('Y-m-d') . " 23:59:59'";
        $today = date('Y-m-d') . " 23:59:00";
        $yesterday = date('Y-m-d', strtotime($today .' -1 day')) . " 23:59:00";
        $data = [];
        
        $no_of_users_response = $this->db->query("select count(user_id) as no_of_users from ".USER_TABLE)->first_row()->no_of_users;
        // echo "select count(user_id) as no_of_users from ".USER_TABLE." where created_at > '$yesterday' AND created_at <= '$today' ";
        $today_no_of_users_response = $this->db->query("select count(user_id) as no_of_users from ".USER_TABLE." where created_at > '$yesterday' AND created_at <= '$today' ")->first_row()->no_of_users;
        
        $no_of_order_response = $this->db->query("select count(order_id) as no_of_orders from ".ORDER_TABLE." Where order_status = 'Completed'")->first_row()->no_of_orders;
        $today_no_of_order_response = $this->db->query("select count(order_id) as no_of_orders from ".ORDER_TABLE." where order_date > '$yesterday' AND order_date <= '$today' And order_status = 'Completed'")->first_row()->no_of_orders;
      
        // $no_of_order_response = $this->db->query("select count(order_id) as no_of_orders ".ORDER_TABLE)->first_row()->no_of_order;
        // $today_no_of_order_response = $this->db->query("select count(order_id) as no_of_orders ".ORDER_TABLE." where order_date > '$yesterday' AND order_date <= '$today' ")->first_row()->no_of_order;
        
        $month_ago = date('Y-m-d', strtotime($today .' -30 day')) . " 00:00:01";
        // echo "select count(grand_total) as amount_of_orders from ".ORDER_TABLE." where order_date > '$month_ago' AND order_date <= '$today' ";
        $total_amount_of_order_response = $this->db->query("select sum(grand_total) as amount_of_orders from ".ORDER_TABLE." where order_date > '$month_ago' AND order_date <= '$today' And order_status = 'Completed'")->first_row()->amount_of_orders;
        $today_amount_of_order_response = $this->db->query("select sum(grand_total) as amount_of_orders from ".ORDER_TABLE." where order_date > '$yesterday' AND order_date <= '$today' And order_status = 'Completed'")->first_row()->amount_of_orders;
       
        $two_month_ago = date('Y-m-d', strtotime($today .' -60 day')) . " 00:00:01";
        
        $graph_no_per_product_reponse = $this->db->query("select count(op.product_id) as no_of_products,sum(op.quantity) as qty , op.product_id , p.product_name, o.order_date from ".ORDER_PRODUCT_TABLE." op left join ".ORDER_TABLE." o on o.order_id = op.order_id left join ".PRODUCT_TABLE." p on p.product_id = op.product_id where order_date > '$two_month_ago' AND order_date <= '$today' And o.order_status = 'Completed' group by op.product_id")->result();
        $graph_no_per_category_reponse = $this->db->query("select count(op.product_id) as no_of_products,sum(op.quantity) as qty , p.product_id , c.category_name, o.order_date from ".ORDER_PRODUCT_TABLE." op left join ".ORDER_TABLE." o on o.order_id = op.order_id left join ".PRODUCT_TABLE." p on p.product_id = op.product_id left join ".CATEGORY_TABLE." c on c.category_id = p.category_id  where order_date > '$two_month_ago' AND order_date <= '$today' And  o.order_status = 'Completed' group by p.category_id")->result();
        
        $six_month_ago = date('Y-m-d', strtotime($today .' -180 day')) . " 00:00:01";
        $total_order_sales_of_six_months = $this->db->query("select * from ".ORDER_TABLE." where order_date > '$six_month_ago' AND order_date <= '$today' And order_status = 'Completed'")->result();

        $data['no_of_users_response'] = $no_of_users_response;
        $data['today_no_of_users_response'] = $today_no_of_users_response;
        
        $data['no_of_order_response'] = $no_of_order_response;
        $data['today_no_of_order_response'] = $today_no_of_order_response;
        
        
        $data['total_amount_of_order_response'] = $total_amount_of_order_response;
        $data['today_amount_of_order_response'] = $today_amount_of_order_response;
        
        $data['graph_no_per_product_reponse'] = $graph_no_per_product_reponse;
        $data['graph_no_per_category_reponse'] = $graph_no_per_category_reponse;
        
        $data['total_order_sales_of_six_months'] = $total_order_sales_of_six_months;
        
        response(1,"success",$data);
    }
    
     
     
    
    
}    