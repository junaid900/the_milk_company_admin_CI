<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/*
	 * 判断客户登录客户端
	 * */
	function checkagent(){
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);  
	    $is_pc = (strpos($agent, 'windows nt')) ? true : false;  
	    $is_iphone = (strpos($agent, 'iphone')) ? true : false;  
	    $is_ipad = (strpos($agent, 'ipad')) ? true : false;  
	    $is_android = (strpos($agent, 'android')) ? true : false;  
	   
	    if($is_ipad){  
	        return 'ipad';
	    }else{
	     	if($is_iphone){  
	        	return 'iphone';
		    }else{
				if($is_android){
			    	return 'android';
			    }else{
			    	return 'pc';
			    }
		    }
	    }
	}
if ( ! function_exists('send_sms'))
{	
	function send_sms($phone,$message){	
	    $mobile = $phone;
        $message = $message;
        $api_key = "923006335290-e9063a7b-7302-46bb-b7a3-848dc2c744eb";
        $sender = "QKP";
            
         $post = "sender=" . urlencode($sender) . "&mobile=" . urlencode($mobile) . "&message=" . urlencode($message) . "";
        	$url = "https://sendpk.com/api/sms.php?api_key=$api_key";
        	$ch = curl_init();
        	$timeout = 0;
        	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        	$result = curl_exec($ch);
        
        	if (preg_match("/OK/", $result)) {
        	    return true;
        
        	} else {
        	    return false;
        	}
        	return;
	}
}

if ( ! function_exists('control_helper'))
{	
	function control_helper(){	
	    $CI =& get_instance();
    	$CI->load->database();
    	$controller_name = $CI->session->userdata('controller_name');
    	if(!empty($controller_name)){
    	    $name = $controller_name;
    	}else{
    	    $CI->session->set_userdata('controller_name','en');
    	    $name = 'en';
    	}
		return base_url().'index.php/'.$name.'/';
	}
}

function auth_session($token_id)
{
    $CI =& get_instance();
    $CI->load->database();
    $date = date('Y-m-d h:i:s');
    $current_date = strtotime($date);
    $result =  $CI->db->query('select * from brinkman_users where token_id="'.$token_id.'" AND token_expiry>="'.$current_date.'"')->num_rows();
    if($result == 0){
       $tokenData['response'] = 'token_expired';
       response(1, "authentication fail", $tokenData); 
    }else{
        return true;
    }
}

function response($status = 0, $message = "Invalid Response", $response = [])
    {
        $resp = [
            "status" => $status,
            "message" => $message,
            "response" => (!empty($response)) ? $response : [],
        ];
        echo json_encode($resp);
        exit();
    }
if ( ! function_exists('apikey'))
{
    function apikey(){
        return 'XXXXXX-XXXXXX-MHnsa1988938922039:012900929';
    }
}
if ( ! function_exists('admin_ctrl'))
{
    function admin_ctrl(){
        return 'index.php/admin';
    }
}

if ( ! function_exists('tokenkey'))
{
    function tokenkey(){
// base64 token key       WFhYWFhYX1hYWFhYWFhfVEtfMTI5OTQ3NzczNjY2Mj9fVEtOTUpDb2RlcnNUT0tFTg==
        return base64_encode('XXXXXX_XXXXXXX_TK_1299477736662?_TKNMJCodersTOKEN');
    }
}
if ( ! function_exists('isTokenValid'))
{
    function isTokenValid($token){
        $CI =& get_instance();
        $CI->load->database();
        $result = $CI->db->get_where("users_system",array("token_id"=>$token));
        if(!$result) {
            return false;
        }
        if(count($result->result()) != 1){
            return false;
        }
        return true;
    }
}

if ( ! function_exists('generateToken'))
{
    function generateToken(){
      $rand1 = rand() . rand() . rand();
      $date = date("Ymd|hsi");
      $token = md5($date.rand()."MJcod..er..SSPOTOKEN");
      return $token;
    }
}

if ( ! function_exists('generateSession'))
{
    function generateSession(){
        $rand1 = rand() . rand() . rand() .rand();
        $date = date("dYm|ihs");
        $session = md5($date.rand()."MJcod.er..SSPOSESSION");
        return $session;
    }
}
// ------------------------------------------------------------------------
/* End of file control_helper.php */
/* Location: ./system/helpers/control_helper.php */