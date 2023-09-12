<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MJ_Controller
{   
    public $cdate;
    
      public function __construct()
    {
        $this->table = ORDER_TABLE;
        $this->alias = ORDER_ALS;
        // echo $this->cdate
        parent::__construct();    
        $this->cdate = "'".date('Y-m-d') . " 23:59:59'";
    }

    /*****  INDEX *********/
    
     public function index(){
        // echo PRORUCT_TABLE . PRODUCT_ALS;
        // exit;
     }
     public function admin_filter(){
         $condition = "";
         $where = " Where ";
         $condition = " (order_referance = 0 OR o.order_date < ".$this->cdate.")";
         if(!empty($_REQUEST['status'])){
             if($_REQUEST['status'] != "All")
             $condition .= " And o.order_status = '".$_REQUEST['status'] . "'";
         }
         if(!empty($_REQUEST['order_id'])){
             if(!empty($condition)) $condition .= " And"; 
             $condition .= " o.order_id = ".$_REQUEST['order_id'];
         }
        
         if(!empty($_REQUEST['store'])){
             if(!empty($condition)) $condition .= " And";
             $condition .= " o.store_id = ".$_REQUEST['store'];
         }
        if(!empty($_REQUEST['start_date'])){
             if(!empty($condition)) $condition .= " And";
             $condition .= " o.order_created_at >= '".$_REQUEST['start_date']." 00:00:01"."'";
         }  
         if(!empty($_REQUEST['end_date'])){
             if(!empty($condition)) $condition .= " And";
             $condition .= " o.order_created_at < '".$_REQUEST['end_date']." 23:59:59"."'";
         }
        //  echo $condition;
        //  exit;
         if(empty($condition)){
             $where = "";
         }
        $orders = $this->db->query("select o.*,u.user_name,u.email,u.phone,u.user_id,ad.*,(select count(order_id) from ".$this->table." oa where oa.order_referance = o.order_id ) as ref_count from ".$this->table." o left join ".USER_TABLE." u on u.user_id = o.user_id  left join ".USER_ADDRESS_TABLE." ad on ad.user_address_id = o.address_id $where $condition order by o.order_date DESC LIMIT 1000")->result();
        // $ids = [];
        
        // $in = implode(",",$ids);
        
        if(!empty($orders)){
            $orderArray = [];
            foreach($orders as $order){
                $products = $this->db->query("select * from ".ORDER_PRODUCT_TABLE." op left join ".PRODUCT_TABLE." p  on p.product_id = op.product_id where op.".$this->alias."_id = ".$order->order_id)->result();
                $order->products = json_encode($products);
                $orderArray[] = $order;
            }
            response(1, "success", $orderArray);
        }
        
        response(1, "no order found", []);
        
        
     }
     
     public function getOrderData($type,$where = '',$order = 'DESC'){
         if($type == "admin"){
             $orders = $this->db->query("select o.*,u.user_name,u.email,u.phone,u.user_id,ad.*,(select count(order_id) from ".$this->table." oa where oa.order_referance = o.order_id ) as ref_count from ".$this->table." o left join ".USER_TABLE." u on u.user_id = o.user_id  left join ".USER_ADDRESS_TABLE." ad on ad.user_address_id = o.address_id $where order by o.order_date $order,o.order_id $order LIMIT 1000")->result();
         }else if($type == "store"){
              $orders = $this->db->query("select o.*,u.user_name,u.email,u.phone,u.user_id,ad.*,(select count(order_id) from ".$this->table." oa where oa.order_referance = o.order_id ) as ref_count from ".$this->table." o left join ".USER_TABLE." u on u.user_id = o.user_id  left join ".USER_ADDRESS_TABLE." ad on ad.user_address_id = o.address_id $where order by o.order_date $order ,o.order_id $order LIMIT 1000")->result();
         }
         $orderArray = [];
         if(!empty($orders)){
            foreach($orders as $order){
                $products = $this->db->query("select * from ".ORDER_PRODUCT_TABLE." op left join ".PRODUCT_TABLE." p  on p.product_id = op.product_id where op.".$this->alias."_id = ".$order->order_id)->result();
                $order->products = json_encode($products);
                $orderArray[] = $order;
            }
        }
        return $orderArray;
     }
     
      public function admin_get(){ 
        $orderArray = $this->getOrderData('admin',"where order_referance = 0 OR o.order_date < ".$this->cdate."  ");
        if(!empty($orderArray)){
            response(1, "success", $orderArray);
        }
        
        response(1, "no order found", []);
        
        
     }
     public function emp_get($store,$user){
         if(empty($store)) response(0, "Invalid store", []);
           $orderArray =  $this->getOrderData("store","where o.store_id = $store and  order_referance = 0 OR o.order_date < ".$this->cdate." ");
        // $ids = [];
        
        // $in = implode(",",$ids);
        
        if(!empty($orderArray)){
            response(1, "success", $orderArray);
        }
        
        response(0, "no order found", []);
        
        
     }
     public function driver_get($bid){ 
         $data = $this->emp_return_all($bid,'driver');
         if(!empty($data)){
             return response(1, "success", $data); 
         }else{
             return response(1, "still no order", []);
         }
     }
     
      public function emp_return_all($bid,$type = 'emp'){
          if($bid == 0){
              return [];
          }
          $where = '';
          if($type == 'driver'){
              $where = " o.driver_id = $bid And  (order_referance = 0 OR o.order_date < ".$this->cdate.")"; 
          }else{
               $where = " o.store_id = $bid And  (order_referance = 0 OR o.order_date < ".$this->cdate.")";
          }
           $orderArray =  $this->getOrderData("store","where $where ");
        if(!empty($orderArray)){
            return $orderArray;
        }
        return [];
     }
     public function admin_return_all(){
          
        $orderArray = $this->getOrderData('admin',"where order_referance = 0 OR o.order_date < ".$this->cdate."  ");
        if(!empty($orderArray)){
           return $orderArray;
        }
        return [];
     }
     public function orderPaid($id,$status,$store_id = ''){
         $res = $this->db->update($this->table , ["paid" => $status], [$this->alias . "_id"=>$id]);
         if($res){
             $data = [];
             if(empty($store_id)){
                 $data = $this->admin_return_all();
             }else{
                  $data = $this->emp_return_all($store_id);
             }
             response(1,"success",$data);
         }else{
             response(0,"failed",[]);
         }
     }
     public function update_order_status($id,$status,$store_id = ''){
         $order_res = $this->db->get_where($this->table ,[$this->alias . "_id"=>$id])->first_row();
         $res = $this->db->update($this->table , ["order_status" => $status], [$this->alias . "_id"=>$id]);
         if($status == "Completed"){
              $this->db->update($this->table , ["paid" => "Yes"], [$this->alias . "_id"=>$id]);
             $this->checkReferalOnFirstOrder($order_res->user_id);
              $this->sendNotification($order_res->user_id,"Order Completed","O-".$order_res->order_id." has been completed",NEW_ORDER_IMAGE,"Single",$_REQUEST,"order");
         }
         if($status == "Cancel"){
             if($order_res->paid == 'Yes'){
                $this->updateWallet($order_res->user_id,$order_res->actual_total,ADD,"on O-".$order_res->order_id." cancelation");
             }else{
                 $this->sendNotification($order_res->user_id,"Order Canceled","O-".$order_res->order_id." has been canceled",NEW_ORDER_IMAGE,"Single",$_REQUEST,"order");
             }
         }
         
        // echo $this->db->last_query();
        //
         if($res){
             $data = [];
             if(empty($store_id)){
                 $data = $this->admin_return_all();
             }else{
                  $data = $this->emp_return_all($store_id);
             }
             response(1,"success",$data);
         }else{
             response(0,"failed",[]);
         }
     }
      public function get(){
        if(!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $user_id = $_REQUEST['user_id'];
        $orders = $this->db->query("select *,(select count(order_id) from ".$this->table." oa where oa.order_referance = o.order_id ) as ref_count from ".$this->table." o left join ".USER_ADDRESS_TABLE." ad on ad.user_address_id = o.address_id where o.user_id = ".$user_id." And order_referance = 0 OR o.order_date < ".$this->cdate." order by o.order_date DESC LIMIT 1000")->result();
        // $ids = [];
        
        // $in = implode(",",$ids);
        
        if($orders){
            $orderArray = [];
            foreach($orders as $order){
                $products = $this->db->query("select * from ".ORDER_PRODUCT_TABLE." op left join ".PRODUCT_TABLE." p  on p.product_id = op.product_id where op.".$this->alias."_id = ".$order->order_id)->result();
                $order->products = json_encode($products);
                $orderArray[] = $order;
            }
            response(1, "success", $orderArray);
            
        }
        
        response(1, "no order found", []);
        
        
     }
     public function get_with_user(){
        if(!isset($_REQUEST['user_id'])) {
            response(0, "missing params", []);
        }
        $user_id = $_REQUEST['user_id'];
        $orders = $this->db->query("select * from ".$this->table." o left join ".USER_TABLE." u on o.user_id = u.user_id left join ".USER_ADDRESS_TABLE." ad on ad.user_address_id = o.address_id where  order_referance = 0 OR o.order_date < ".$this->cdate." order by o.order_date DESC LIMIT 1000")->result();
        // $ids = [];
        
        // $in = implode(",",$ids);
        
        if(!empty($orders)){
            $orderArray = [];
            foreach($orders as $order){
                $products = $this->db->query("select * from ".ORDER_PRODUCT_TABLE." op left join ".PRODUCT_TABLE." p  on p.product_id = op.product_id where op.".$this->alias."_id = ".$order->order_id)->result();
                $order->products = $products;
                $orderArray[] = $order;
            }
             response(1, "success", $orderArray);
            
        }
        
        response(0, "no order found", []);
        
        
     }
     public function checkReferalOnFirstOrder($user_id){
        //  echo $user_id;
         $userRes = $this->db->get_where(USER_TABLE, [USER_ALS . "_id" => $user_id]);
         if(!$userRes){
             return false;
         }
         $users = $userRes->result();
        //  print_r($users);
         if(count($users) < 1){
             return false;
         }
         $user = $users[0];
         if(empty($user->refered_by)){
             return false;
         }
         $otherUserRes = $this->db->get_where(USER_TABLE, [USER_ALS . "_id" => $user->refered_by]);
         if(!$otherUserRes){
             return false;
         }
         $otherUsers = $otherUserRes->result();
         if(count($otherUsers) < 1){
             return false;
         }
         $otherUser = $otherUsers[0];
        
         
        $checkRef = $this->db->query("select count(order_id) as count from ".$this->table." where user_id=$user_id and order_status != 'Cancel' And  (order_referance = 0 OR o.order_date < ".$this->cdate.")")->row_array();
        // print_r($checkRef);
        if(isset($checkRef['count'])){
            if(!empty($checkRef['count'])){
                if($checkRef["count"] < 2){
                    $userWallet = $this->db->get_where(WALLET_TABLE,["user_id"=>$user_id])->first_row();
                    $otherUserWallet = $this->db->get_where(WALLET_TABLE,["user_id"=>$otherUser->user_id])->first_row();
                    $user_amount = $this->app_setting['referal_amount'];
                    $other_user_amount = $this->app_setting['referal_amount_user'];
                    
                    $this->db->update(WALLET_TABLE, ["available_amount"=>$userWallet->available_amount + $user_amount],[WALLET_ALS."_id"=>$userWallet->wallet_id]);
                    $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$user->user_id,"description"=>"amount added on order referal","amount"=>"Added","amount"=>$user_amount],"order");
                    
                    //  Other User
                      $this->db->update(WALLET_TABLE, ["available_amount"=>$otherUserWallet->available_amount + $other_user_amount],[WALLET_ALS."_id"=>$otherUserWallet->wallet_id]);
                      $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$otherUser->user_id,"description"=>"amount added on order referal by user ".$user->user_name ,"amount"=>"Added","amount"=>$user_amount],"order");
                      
                    
                    
                    $this->sendNotification($user_id,"Congratulations you referal succeeded","You received $user_amount PKR amount in your wallet by referal",NEW_ORDER_IMAGE,"Single",$_REQUEST,"referal");
                    
                      $this->sendNotification($otherUser->user_id,"Congratulations!","You received $other_user_amount PKR amount because ".$user->user_name." has used your referal",NEW_ORDER_IMAGE,"Single",$_REQUEST,"referal");
                }
            }
        }
        
     }
  
     public function submit(){
        //  response(0, "under maintenance", []);
        if(!isset($_REQUEST['user_id']) || !isset($_REQUEST['address_id']) ||  !isset($_REQUEST['products']) || !isset($_REQUEST["total"])) {
            response(0, "missing paramsw", []);
        }
        // print_r($_REQUEST);
        // print_r($_REQUEST['products']);
        
        $products = json_decode($_REQUEST['products'],true);
        $data = array();
        $data['address_id'] = $_REQUEST['address_id'];
        $data['user_id'] = $_REQUEST['user_id'];
        $data['grand_total'] = $_REQUEST['total'];
        $data['sub_total'] = $_REQUEST['total'];
        $data['payment_method'] = $_REQUEST['payment_method'];
        $data["order_created_at"] = date('Y-m-d h:i:s a');
        
        $wallet = $this->getUserWallet($data['user_id']);
        // print_r($wallet);
        if($data['payment_method'] == "wallet"){
            if($wallet->available_amount < $data['grand_total']){
                 response(0, "dont have enough money in wallet", []);
            }else{
                $this->db->update(WALLET_TABLE,["available_amount"=>$wallet->available_amount - $data['grand_total']]);   
            }
        }
         $datesArr = [];
         $totalArr = [];
    
        foreach($products as $product){
                $s = $product['s_date'];
                $e = $product['e_date'];
                if($s && $e){
                    $dateArr = $this->createDateRangeArray($s,$e);
                    foreach($dateArr as $date){
                        $datesArr[$date][] = $product;
                        $totalArr[$date] = isset($totalArr[$date])?$totalArr[$date]+($product['product_price'] * $product['quantity']):($product['product_price'] * $product['quantity']); 
                    }
                }else{
                    $datesArr[date('Y-m-d')." 00:00:00.000"][] = $product;
                    $totalArr[date('Y-m-d')." 00:00:00.000"] = isset($totalArr[$date])?$totalArr[$date]+($product['product_price'] * $product['quantity']):($product['product_price'] * $product['quantity']);
                }
            }
            // sort($datesArr);
            $keys = array_keys($datesArr);
            function sortFunction( $a, $b ) {
                // print_r($a);
                return strtotime($a) - strtotime($b);
            }
            usort($keys, "sortFunction");
            // echo "here1";
            // print_r($keys);
            // exit();
        $ids = [];
        $firstId = 0;
        $i = 0;
        foreach($keys as $k){
            $data["order_date"] = $k;
            $data["order_referance"] = $firstId;
            if($data['payment_method'] == "wallet"){
                $data["paid"] = "Yes"; 
            }
            $products = $datesArr[$k];
            $data["actual_total"] = isset($totalArr[$k])?$totalArr[$k]:0;
            $res = $this->db->insert($this->table,$data);
            if($res){
                $oId = $this->db->insert_id();
                foreach($products as $product){
                    $productArr = [
                        "order_id"=>$oId,
                        "product_id"=>$product['product_id'],
                        "quantity"=>$product['quantity'],
                        "price"=>$product['product_price'],
                        "product_timing_id"=>$product['time'],
                        "type"=>$product['type'],
                        "start_date"=>$product['s_date'],
                        "end_date"=>$product['e_date'],
                        ];
                        $this->db->insert(ORDER_PRODUCT_TABLE,$productArr);
                    }
                    $ids[] = $oId;
                    if($i == 0){
                        $firstId = $oId;
                    }
                    $i++;
            }
        }    
       
        
         
        if($firstId){
            // foreach($products as $product){
            //     $productArr = [
            //         "order_id"=>$id,
            //         "product_id"=>$product['product_id'],
            //         "quantity"=>$product['quantity'],
            //         "price"=>$product['product_price'],
            //         "product_timing_id"=>$product['time'],
            //         "type"=>$product['type'],
            //         "start_date"=>$product['s_date'],
            //         "end_date"=>$product['e_date'],
            //         ];
            //         $this->db->insert(ORDER_PRODUCT_TABLE,$productArr);
            // }
            if($data['payment_method'] == "wallet")
            $this->db->insert(TRANSACTION_HISTORY_TABLE,["user_id"=>$data['user_id'],"description"=>"amount deducted on order place: order no $firstId","amount"=>"Remove","amount"=>$data['grand_total']],"order");
            $this->sendNotification($data['user_id'],NEW_ORDER_TITLE,NEW_ORDER_MESSAGE,NEW_ORDER_IMAGE,"Single",$_REQUEST,"order");
            $this->sendNotification($data['user_id'],ADMIN_NEW_ORDER_TITLE,ADMIN_NEW_ORDER_MESSAGE,NEW_ORDER_IMAGE,"Admin",$_REQUEST,"order");
            
            
            response(1, "order placed successfully", []);
        }
        response(0, "cannot place order", []);
        
     }
     function createDateRangeArray($strDateFrom,$strDateTo) 
    {
        $aryRange = [];
    
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        // echo "here";
        // print_r($aryRange);
        return $aryRange;
    }
    public function update_driver($id,$driver_id,$store_id,$type = 'admin'){
         $res = $this->db->update($this->table , ["driver_id" => $driver_id], [$this->alias . "_id"=>$id]);
         
         if($res){
             $data = [];
              $this->sendNotification($driver_id,"New Order Assignment","A new order has been assigned o-$id",NEW_ORDER_IMAGE,"Driver",$_REQUEST,"order");
             if($type == 'admin'){
                 $data = $this->admin_return_all();
             }else{
                  $data = $this->emp_return_all($store_id);
             }
             response(1,"success",$data);
         }else{
             response(0,"failed",[]);
         }
     }
     public function update_store($id,$store_id){
         $order = $this->db->get_where($this->table,[$this->alias."_id"=>$id])->first_row();
         $res = $this->db->update($this->table , ["store_id" => $store_id], [$this->alias . "_id"=>$id]);
         if($res){
            //  $this->db->where("");
             $this->db->update($this->table,["store_id"=>$store_id],["order_referance"=>$order->order_id]);
             if($order->store_id != $store_id)
                 $this->sendNotification($store_id,"New Order Assignment","A new order has been assigned o-$id",NEW_ORDER_IMAGE,"Store",$_REQUEST,"order");
             response(1,"success",$this->admin_return_all());
         }else{
             response(0,"failed",[]);
         }
     }
     public function get_ref($type,$store=''){
        if(!isset($_REQUEST['ref_id']) || !isset($_REQUEST['order_id']) || !isset($_REQUEST['is_parent'])) {
            response(0, "missing params", []);
        }
        $ref = $_REQUEST['ref_id'];
        $isParent = $_REQUEST['is_parent'];
        $order_id = $_REQUEST['order_id'];
         $id = $isParent ? $order_id : $ref;
        if($type == "admin"){
           
            $orderArray = $this->getOrderData("admin","where o.order_id = $id OR o.order_referance = $id","ASC");
        }else if($type == "store"){ 
            // $store = $_REQUEST['store_id'];
            if(empty($store)){
                response(1,"invalid store",[]);
            }
            $orderArray = $this->getOrderData("admin","where (o.order_id = $id OR o.order_referance = $id) and o.store_id = $store","ASC");
        }else if($type == "user"){
            if(empty($store)){
                response(1,"invalid user",[]);
            }
            $orderArray = $this->getOrderData("admin","where (o.order_id = $id OR o.order_referance = $id) and o.user_id = $store","ASC");
        }
        if(!empty($orderArray)){
            response(1,"success",$orderArray);
        }else{
            response(1,"no data found",[]);
        }
        
        
        
     }
     
    
    
}    