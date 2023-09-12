<?php
// include ('Fire_Controller.php');
class MJ_Controller extends MJ_Fire_Controller{
    public $language = 'en';
    public $offset = '0';
    public $limit = '1000';
    public $table = '';
    public $alias = '';
    public $orderBy = NULL;
    public $app_setting = [];
    // public $fireController = new Fire_Controller();
    public function __construct(){
        parent::__construct();
        // echo PHP_VERSION;        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, *');     
        $this->output->set_header('Content-Type : application/json; charset=UTF-8');
        
        $postdata = file_get_contents("php://input");
         if (isset($postdata)) {
            if (!empty($postdata)) {
                $post_data = json_decode($postdata, true);
                $_REQUEST = $post_data;
            }
        }
        
        if($_REQUEST == null){
            $_REQUEST = [];
        }
        if(count($_POST) > 0){
            foreach($_POST as $k => $v){
                $_REQUEST[$k] = $v;
            }
        }

        if(count($_GET) > 0){
            foreach($_GET as $k => $v){
                $_REQUEST[$k] = $v;
            }
        }
      
        if (isset($_POST["lang"])) {
            $this->language = $_POST["lang"];
        }
        if (isset($_GET["lang"])) {
            $this->language = $_GET["lang"];
        }
        if (isset($_REQUEST["lang"])) {
            $this->language = $_REQUEST["lang"];
        }
        
        if (isset($_REQUEST["limit"])) {
            $this->limit = $_REQUEST["limit"];
        }
        if (isset($_REQUEST["offset"])) {
            $this->offset = $_REQUEST["offset"];
        }
        if (isset($_REQUEST["order_by"])) {
            $this->orderBy = $_REQUEST["order_by"];
        }
        date_default_timezone_set('Asia/Karachi');

        $settingResponse = $this->db->get(APP_SETTING_TABLE)->result();
        foreach($settingResponse as $setting){
            $this->app_setting[$setting->item_key] = $setting->item_value;    
        }
        if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        // print_r($this->app_setting);
    }
    public function sendNotification($receiver_id,$title,$message,$image,$type = 'Single',$data = [],$click="none"){

        $this->db->insert(NOTIFICATION_TABLE,[
            "receiver_id"=>$receiver_id,
            "notification_title"=>$title,
            "description"=>$message,
            "image"=>$image,
            "type"=>$type,
            "data"=> json_encode($data),
            "click"=>$click,
            "created_at" => date('Y-m-d h:i:s a')
            ]);
            // echo $this->db->last_query();
            // exit;
        if($type == "Admin"){
            $ref = $this->database
            ->getReference("notification/admin");
            $values = $ref->getValue();
            // print_r($values);
            if(!empty($values)){
                $count = $values['count'];
                $ref->set([
                    'count' => $count+1,
                ]);
            }else{
                
                $ref->set([
                    'count' => 1,
                ]);
            }
        }else if($type == 'Store' || $type == 'Driver'){
            $ref = $this->database
            ->getReference("notification/admin_user/$type-$receiver_id");
            $values = $ref->getValue();
            if(!empty($values)){
                $count = $values['count'];
                $ref->set([
                    'count' => $count+1,
                ]);
            }else{
                $ref->set([
                    'count' => 1,
                ]);
            }
        }else{
             $ref = $this->database
            ->getReference("notification/$receiver_id");
            $values = $ref->getValue();
            // print_r($values);
            if(!empty($values)){
                $count = $values['count'];
                $ref->set([
                    'count' => $count+1,
                ]);
            }else{
                $ref->set([
                    'count' => 1,
                ]);
            }
            // 
           
        }
       
        
    }
    public function get(){
        $this->db->limit($this->limit,$this->offset);
        if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        // $this->db->join("categ");
         $data = $this->db->get($this->table)->result();
         return response(1,"Success",$data);
    }
    // return_all
    public function get_with_status(){
       $this->db->limit($this->limit,$this->offset);
        // $this->db->join("categ");
        if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
         $data = $this->db->get_where($this->table,["status"=>"Active"])->result();
         return response(1,"Success",$data);
    }
    public function return_with_id($id){
        return $this->db->get_where($this->table , [$this->alias."_id" => $id])->result();
    }
    public function return_all(){
        $this->db->limit(2000);
        if($this->orderBy){
            $this->db->order_by($this->alias."_id",$this->orderBy);
        }
        return $this->db->get($this->table)->result();
    }
    public function getOne($tbl, $key,$val){ 
        return $this->db->get_where($tbl,[$key=>$val])->first_row();
    }
    
    public function getUserWallet($user_id){
        return $this->db->get_where(WALLET_TABLE , ["user_id" => $user_id])->first_row();
    }
    public function check_session($session_id){
        $userResponse = $this->db->get_where(USER_TABLE, ["session_id"=>$session_id]);
        if(!$userResponse){
            return false;
        }
        if(count($userResponse->result()) < 1){
            return false;
        }
        return $userResponse->first_row();
        
    }
    public function uploadDirBase64Image($img,$dir){
       
        // $img = $_REQUEST['img'];
        $data = base64_decode($img);
        $file = "uploads/$dir/" . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        if($success)
        return $file;
        else
        return NULL;
    }
    public function checkRef($ref){
        $res = $this->db->get_where(USER_TABLE,['referal'=>$ref])->result();
        return count($res) < 1;
    }
    public function generateRef(){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $times = 0;
        
        while(true){
            if($times > 100){
                $ref = rand() . date('dmhis');
                if($this->checkRef($ref)){
                     break;
                }else{
                    continue;
                }
            }
            $ref = substr(str_shuffle($permitted_chars), 0, 4);
            if($this->checkRef($ref)){
                break;
            }
            
            $times++;
        }
        return $ref;
    }
    public function updateWallet($userId, $amount, $type,$message = ''){
        $wallet = $this->db->get_where(WALLET_TABLE,["user_id"=>$userId])->first_row();
        $walletAmount = $wallet->available_amount;
        if($type == ADD){
            $walletAmount +=$amount;
        }else{
            $walletAmount -=$amount;
        }
        $res = $this->db->update(WALLET_TABLE,['available_amount'=>$walletAmount],["wallet_id"=>$wallet->wallet_id]);
        if($res){
            if($type == ADD){
                 $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$userId,"description"=>"amount added to wallet $message","amount"=>"Added","amount"=>$amount],"order");
                  $this->sendNotification($userId,"Wallet Update","$amount RS added to your wallet $message",NEW_ORDER_IMAGE,"Single",$_REQUEST,"order");
            }else{
                $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$userId,"description"=>"amount deducted from wallet $message","amount"=>"Remove","amount"=>$amount],"order");
                  $this->sendNotification($userId,"Wallet Update","$amount RS deducted from your wallet $message",NEW_ORDER_IMAGE,"Single",$_REQUEST,"order");
            }
        }else{
            
        }
    }
    
    
    
    
    
    
}