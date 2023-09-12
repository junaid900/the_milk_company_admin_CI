<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Db_model extends CI_Model {
		
		function __construct() {
			parent::__construct();
		}		
		
		public function get_data($table = '', $pkey = '', $pkeydata = ''){
			$result = $this->db->get_where($table, array($pkey => $pkeydata))->row_array();	
			return $result;
		}	

		public function get_data_row($table = '', $pkey = '', $pkeydata = ''){		
			$result = $this->db->get_where($table, array($pkey => $pkeydata))->row();
			return $result;	
		}	

		public function get_data_array($table = '', $pkey = '', $pkeydata = ''){
			$result = $this->db->get_where($table, array($pkey => $pkeydata))->result_array();	
			return $result;	
		}	
     
		public function get_data_In_array($table = ''){
			$result = $this->db->get($table)->result_array();	
			return $result;	
		}		

		public function get_data_name($table = '', $pkey = '', $pkeydata = '' , $name=''){		
			$result = $this->db->get_where($table,array($pkey=> $pkeydata))->row()->$name;	
			return $result;	
		}		

		public function get_data_static($table = '', $pkey = '', $pkeydata = '' , $status=''){		
			$result = 	$this->db->query("SELECT * FROM $table WHERE $pkey = $pkeydata AND status = '$status'")->result_array();			
			return $result;	
		}	

		public function category_update_data($table, $id, $data){
			$this->db->where('product_categories_id' , $id);
			$this->db->update($table , $data); 
		}
		/** search results **/
		
		public function get_menu(){
		    if($this->session->userdata('current_language') == 'Chinese'){
		      return $this->db->query('select menu_id,ch_title as en_title,position_order,type from menu')->result_array();
		    }else{
		      return $this->db->query('select menu_id,en_title,position_order,type from menu')->result_array();
		    }
		}
		
	
		public function get_start_date($month){
		    $y = date('Y');
		    $first_date = date('Y-m-d',strtotime('first day of '.$month.' '.$y.''));
            return $first_date;
		}
		public function get_end_date($month){
		    $y = date('Y');
		    $last_date = date('Y-m-d',strtotime('last day of '.$month.' '.$y.''));
            return $last_date;
		}
		
		public function seach_results($title){
		    $category =array();
		    $news_category =array();
		    $lang = $this->session->userdata('current_language');
		    
		    $results = array();
		    $match = '%'.$title.'%';
            
            if($lang == 'Chinese'){
                $match = "ch_title LIKE '".$match."'";
            }else{
                $match = "en_title LIKE '".$match."'";
            }
            $keywords = $this->db->get_where('keywords',array('en_title'=>$title));
            if($keywords->num_rows() > 0){
                $keywords_id = $keywords->row()->keywords_id;
                $search_data = $this->db->get_where('search_keywords',array('keyword_id'=>$keywords_id))->result_array();
            	$category_detail_array = array();
            	$news_category_detail_array = array();
            	$type_array = array();
            	foreach($search_data as $d){
            	    if($d['type'] == 'category'){
            	         array_push($category_detail_array, $d['detail_page_id']);
            	    }else if($d['type'] == 'news'){
            	         array_push($news_category_detail_array, $d['detail_page_id']);
            	    }
            	   
            	}
            	
            	
            	$cat_imp = "'" . implode( "','", $category_detail_array ) . "'";
            	$news_imp = "'" . implode( "','", $news_category_detail_array ) . "'";
                
                if($lang == 'Chinese'){
                 $category = $this->db->query('select * from category_detail where status="Active" AND category_detail_id IN('.$cat_imp.')')->result_array();
                }else{
                 $category = $this->db->query('select * from category_detail where status="Active" AND category_detail_id IN('.$cat_imp.')')->result_array();
                }
                
                if($lang == 'Chinese'){
                 $news_category = $this->db->query('select * from news_category_detail where status="Active" AND news_category_detail_id IN('.$news_imp.')')->result_array();
                }else{
                 $news_category = $this->db->query('select * from news_category_detail where status="Active" AND news_category_detail_id IN('.$news_imp.')')->result_array();
                }
            }
           /* $sub_tree_category_id  = $this->db->get_where('category_detail',array('category_detail_id'=>$search_data->detail_page_id))->row()->sub_tree_category_id;
                $link = '';
                if(!empty($sub_tree_category_id)){
                    $link            = $this->db->get_where('sub_tree_category',array('sub_tree_category_id'=>$sub_tree_category_id))->row()->title;
                }
                $results['cat_link']  = $link;
                $results['sub_tree_category_id'] = $sub_tree_category_id; */
        
            /*
            if($lang == 'Chinese'){
             $news = $this->db->query('select news_id,title as link,ch_title as title from news where status="Active" AND '.$match.' ')->result_array();
            }else{
             $news = $this->db->query('select news_id,title as link,en_title as title from news where status="Active" AND '.$match.' ')->result_array();
            }
            if($lang == 'Chinese'){
                $campus_life = $this->db->query('select campus_life_id,title as link,ch_title as title from campus_life where status="Active" AND '.$match.' ')->result_array();
            }else{
                $campus_life = $this->db->query('select campus_life_id,title as link,en_title as title from campus_life where status="Active" AND '.$match.' ')->result_array();
            }
            if($lang == 'Chinese'){
                $department = $this->db->query('select department_detail_id,title as link,ch_title as title from department_detail where  '.$match.' ')->result_array();
            }else{
                $department = $this->db->query('select department_detail_id,title as link,en_title as title from department_detail where '.$match.' ')->result_array();
            } */
            $results['category']        = $category;
            $results['news']            = $news_category;
            $results['campus_life'] = array();
            $results['department']  = array(); 
            
            return $results;
		}
		/** search results **/
		
        /*****  UNIQUE VISITS ****/
        public function unique_visit(){
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $unique_visit = $this->db->get_where('unique_visit',array('user_ip'=>$ip_address));
            if($unique_visit->num_rows() >0){
                $updateData['count'] = $unique_visit->row()->count + 1;
                $this->db->where('unique_visit_id',$unique_visit->row()->unique_visit_id);
                $result = $this->db->update('unique_visit',$updateData);
            }else{
                $saveData['user_ip'] = $ip_address;
                $saveData['date']    = date('Y-m-d');
                $saveData['count']   = 1;
                $result = $this->db->insert('unique_visit',$saveData);
            }
            return $result;
        }
        /*****  UNIQUE VISITS ****/
      
		/* UPDATE DATA */	
		function set_update_data($table, $id, $data){
			$this->db->where('product_categories' , $id);
			$this->db->update($table , $data); 
			
		}		
	
		public function get_pending_request($table = '', $pkey = '', $pkeydata = '' , $key_desc = ''){
			$this->db->where($pkey , $pkeydata);
			$this->db->from($table);
			$this->db->order_by($key_desc, "desc");
			$query = $this->db->get(); 
			return $query->result_array();
		}
		public function get_all_user(){
			$this->db->from('user');
			$this->db->order_by('user_id', "desc");
			$query = $this->db->get(); 
			return $query->result_array();
		}
		/* UPDATE DATA */ 	
		public function get_storage_pricing(){
			$result = $this->db->get_where('system_settings', array('type' =>'storage_rent_charges'))->row()->description;
			return $result;	
		}
		
		public function get_system_currency(){
			$result = $this->db->get_where('system_settings', array('type' =>'system_currency'))->row()->description;
			return $result;	
		}
		
		/* UPDATE DATA */	
		function update_data($table, $id, $data){
			$this->db->where($table . '_id' , $id);
			$result = $this->db->update($table , $data); 
			return $result;
		}		
		/* UPDATE DATA */ 	
		function string_replace_body($name,$email,$string){
			$string = str_replace('{user_name}', $name, $string);
			$string = str_replace('{user_email}',$email, $string);
			return $string;
			exit;
		}
		function string_replace_storage($payment_gateway,$user_id,$name,$email,$request_storage_id,$storage_ids,$string){
			$string = str_replace('{user_name}', $name, $string);
			$string = str_replace('{user_email}',$email, $string);
			$string = str_replace('{storage}',$storage_ids, $string);
			$string = str_replace('{payment_link}',base_url().'payment/index/'.$payment_gateway.'/'.$request_storage_id.'/'.$user_id, $string);
			return $string;
			exit;
		}
		/* UPDATE DATA */	
		function update_email_data($table, $type, $data){
			$this->db->where('type' , $type);
			$result = $this->db->update($table , $data); 
			return $result;
		}		
		/* UPDATE DATA */ 	
		
		/* DELETE DATA BY ID */		
		function delete_data($table, $id){		
			$this->db->where($table.'_id', $id);	
			$result = $this->db->delete($table);
			return $result;
		}	
		
		/* INSERT DATA */	
		function add_data($table, $data){		
			$result = $this->db->insert($table , $data); 	
			return $result;
		}		
		/* INSERT DATA */ 	
		
		/* GET DATA BY TABLE DESC */	
		function get_data_desc($table){	
			$this->db->select();		
			$this->db->from($table);	
			$this->db->order_by($table.'_id','DESC');	
			$this->db->limit(3);
			$query = $this->db->get(); 		
			return $query->result_array();	
		}	
		/* GET DATA BY TABLE DESC */		
		
		/* USER LOGIN */
		function login_varify_accounts(){
				// print_r ($_POST);exit;
			$username= $this->input->post('email');
			$password= md5($this->input->post('password'));
		    $this->db->select();
			$this->db->from('brinkman_users_system');
			$this->db->where('email',$username);
			$this->db->where('password',$password);
			$query = $this->db->get(); 
		
		/*	$ip_address = $_SERVER['REMOTE_ADDR'];
    		$Email = $this->input->post('email');
    		$res  = $this->db->query("select * from user_ips where email='".$Email."' OR ip='".$ip_address."' ORDER BY user_ips_id DESC");
			$res_all = $this->db->query("select * from user_ips where email='".$Email."' OR ip='".$ip_address."' ")->num_rows();
			$date=0;
			$time=0;
			$current_date=0;
			$current_time = 0; 
			if($res->num_rows() > 0){
			    $date = $res->row()->date;
				$timestamp = strtotime($res->row()->time) + 60*60*2;
                $time = date('h:i:s', $timestamp);
                $current_date = date('Y-m-d');
				$current_time = date('h:i:s');
			}
			echo $current_time.'---'.$time;
			if($current_time >=$time){
			    echo 'greater';
			}else{
			    echo 'not';
			}
			exit;*/
//            print_r($query->result());
//            exit();
			if($query->num_rows() == 1){
			//	echo 'successs';exit;
				
			/*	if($current_date == $date && $current_time > $time){
				    return 'blocked';
				}else{
				    if($res->num_rows() >0){
				        $this->db->query("DELETE from user_ips where email='".$Email."' OR ip='".$ip_address."'");
				    } */
				    return $query->row();
				/*	} */
			} else {
			    
    			   /* if($res_all == 3 && $current_date == $date &&  $current_time <= $time){
    				    return 'blocked';
    				}else if($res_all >= 6 && $current_date == $date &&  $current_time <= $time){
    				    $result = $this->db->query("UPDATE user_accounts SET status='Inactive' WHERE  email='".$Email."' OR user_ip='".$ip_address."'");
    				    
    				    if($result){
    				    $user_name     =  $this->db->get_where('user_accounts', array('email'=>$Email))->row()->name;
    				    $admin_email    =  $this->db->get_where('system_settings', array('type'=>'email'))->row()->description;
    				    $get_template   = $this->db->get_where('email_templates', array('type'=>'locked_account'))->row();
            			$sub = $get_template->subject;
            			$message = $get_template->body;
            			$message = str_replace("{user_name}",$user_name , $message);
            			$message = str_replace("{user_email}",$Email , $message);
            			$message = str_replace("{date_added}",$date, $message);
            			$message = str_replace("{time_added}",$time , $message);
            			$message = str_replace("{admin_email}",$admin_email , $message);
            		    $this->Email_model->do_email($message, $sub, $Email);
    				    }
    				    
    				    return 'permanent_blocked';
    				}else{
    				    $ip['ip']    =  $ip_address;
        			    $ip['email'] =  $Email;
        			    $ip['date']  =  date('Y-m-d');
        			    $ip['time']  =  date('h:i:s');
        			    $this->db->insert('user_ips',$ip);
    				    return false;
				    } */
			     return false;
			    
			    
				// echo 'fail';exit;
			}	
		}
		/* USER LOGIN */
		function varify_user_accounts(){
				// print_r ($_POST);exit;
			$username = $this->input->post('user_name');
			$password = $this->input->post('user_password');
		    $this->db->select();
			$this->db->from('brinkman_user');
			$this->db->where('email',$username);
			$this->db->where('password',$password);
			$query = $this->db->get(); 
			if($query->num_rows()== 1){
				// echo 'successs';exit;
				return $query->row();
			} else {
				return false;
				// echo 'fail';exit;
			}	
		}
		function retrieve_password($user_email){  
			$get_email_data = $this->db->get_where('brinkman_user_accounts', array('email'=>$user_email));
			
			if($get_email_data->num_rows() == 0){
				return 'Email Not Found';
			} else if($get_email_data->num_rows() == 1){
                $user_details = $get_email_data->row_array();
				$user_name = $user_details['name'];
				$user_id = $user_details['user_accounts_id'];
				$code_data = $user_id.'_'.date('Ymd h:s:i');
				$encoded_code = base64_encode($code_data);
				$recovery_link = base_url().'admin/resetpassword/'.$encoded_code;
				$sub = "Reset Password";
				// $message = "<b>Dear ".$user_name." </b><br> The link for change your password is down here. <br> <b>Please Note:<b> This link will be valid only for 1 time,<br> after that this link will be expire. <br> <a href='".$recovery_link."' target='_blank'> Reset Password </a> ";
				$get_template = $this->db->get_where('brinkman_email_templates', array('type'=>'forgot_password'))->row();
				$message = $get_template->body;
				$message = str_replace("{user_name}", $user_name , $message);
				$message = str_replace("{reset_link}", $recovery_link , $message);
				$mail_response = $this->Email_model->do_email($message, $sub, $user_email);
				$this->db->query("UPDATE brinkman_user_accounts SET reset_password_code = '".$encoded_code."' WHERE user_accounts_id = '".$user_id."'  ");
				if($mail_response == true){
					return 'Mail Sent';
				} else {
					return 'Mail Not Sent';
				}
			}
		}
		/* get saved pubs */
		function get_saved_pubs($userid,$type){
    	    $this->db->select('bp.*');
            $this->db->from('brinkman_saved_pubs sb');
            $this->db->where('sb.id', $userid);
            $this->db->where('sb.type', $type);
            $this->db->join('brinkman_pubs bp', 'bp.pubs_id = sb.pubs_id', 'left');
            $query = $this->db->get(); 
		    return $query->result_array();
		}
		/* get saved events */
		function delete_saved_row($param1,$param2,$param3){
		    $this->db->where('type', $param1);
		    $this->db->where('id', $param2);
            $result = $this->db->delete('brinkman_'.$param3);
            return $result;
		}
		
		
		function get_saved_events($userid,$type){
    	    $this->db->select('ev.*');
            $this->db->from('brinkman_saved_events sv');
            $this->db->where('sv.id', $userid);
            $this->db->where('sv.type', $type);
            $this->db->join('brinkman_events ev', 'ev.events_id = sv.events_id', 'left');
            $query = $this->db->get(); 
		    return $query->result_array();
		}
		function get_saved_jobs($userid,$type){
    	    $this->db->select('sj.*');
            $this->db->from('brinkman_saved_jobs sj');
            $this->db->where('sj.id', $userid);
            $this->db->where('sj.type', $type);
            $this->db->join('brinkman_job jb', 'jb.job_id = sj.job_id', 'left');
            $query = $this->db->get(); 
		    return $query->result_array();
		}
		
		/* UPDATE ADMIN PROFILE */
		function update_admin_profile(){
			$save_data['first_name'] = $this->input->post('first_name');
			$save_data['password'] = $this->input->post('password');
			$save_data['mobile'] = $this->input->post('mobile');
		

			if(!empty($_FILES['user_image']['name'])){
				$file_name = 'users_'.time().$this->session->userdata('users_id').'.jpg';
				$path_to_file = 'uploads/users/'.$file_name;				
				move_uploaded_file($_FILES['user_image']['tmp_name'], $path_to_file);	
				$save_data['user_image'] = $file_name;		
			}			
				
			$this->db->where('users_system_id' , $this->session->userdata('users_id'));	
			$this->db->update('brinkman_users_system' , $save_data); 	
			$this->session->set_userdata('name',$save_data['first_name']);	
		}		
		/* UPDATE ADMIN PROFILE */		
				
																				
		/* UPDATE ADMIN SETTING */	
		function update_system_settings(){		
			$save_data['description'] = $this->input->post('system_name');	
			$this->db->where('type' , 'system_name');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('home-page-seo-title');	
			$this->db->where('type' , 'home-page-seo-title');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('home-page-seo-description');	
			$this->db->where('type' , 'home-page-seo-description');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('storage_rent_charges');	
			$this->db->where('type' , 'storage_rent_charges');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('storage_deposit_charges');	
			$this->db->where('type' , 'storage_deposit_charges');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('system_currency');
			$this->db->where('type' , 'system_currency');		
			$this->db->update('brinkman_system_settings' , $save_data);

			$save_data['description'] = $this->input->post('email');
			$this->db->where('type' , 'email');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('phone');
			$this->db->where('type' , 'phone');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('city');
			$this->db->where('type' , 'city');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('state');
			$this->db->where('type' , 'state');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('address');
			$this->db->where('type' , 'address');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			
			
			$save_data['description'] = $this->input->post('privacy_en_description');
			$this->db->where('type' , 'privacy_en_description');		
			$this->db->update('brinkman_system_settings' , $save_data); 		
			
			$save_data['description'] = $this->input->post('privacy_ch_description');
			$this->db->where('type' , 'privacy_ch_description');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('terms_en_description');
			$this->db->where('type' , 'terms_en_description');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('terms_ch_description');
			$this->db->where('type' , 'terms_ch_description');		
			$this->db->update('brinkman_system_settings' , $save_data); 
			
			$save_data['description'] = $this->input->post('linkdin');
			$this->db->where('type' , 'linkdin');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('smtp_username');
			$this->db->where('type' , 'smtp_username');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('wechat');	
			$this->db->where('type' , 'wechat');		
			$this->db->update('brinkman_system_settings' , $save_data); 		
			
			$save_data['description'] = $this->input->post('youtube');
			$this->db->where('type' , 'youtube');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			
		    $save_data['description'] = $this->input->post('tiktok');
			$this->db->where('type' , 'tiktok');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('instagram');
			$this->db->where('type' , 'instagram');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('twitter');
			$this->db->where('type' , 'twitter');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			$save_data['description'] = $this->input->post('youku');
			$this->db->where('type' , 'youku');		
			$this->db->update('brinkman_system_settings' , $save_data); 	
			
			if(!empty($_FILES['system_image']['name'])){	
				$file_name = time().'_system_image.jpg';			
				$path_to_file = 'uploads/admin/'.$file_name;	
				move_uploaded_file($_FILES['system_image']['tmp_name'], $path_to_file);		
				$save_data['description'] = $file_name;			
				$this->db->where('type' , 'system_image');	
				$this->db->update('brinkman_system_settings' , $save_data); 		
			}	
		}
        public function join2Tables($table1,$table2,$where = 1,$order = ""){
            $this->db->select("a.status as tb_status, a.*,b.*");
            $this->db->from($table1." a");
            $this->db->join($table2." b",'a.'.$table2.'_id = b.'.$table2.'_id');
            if($where != 1) {
                $this->db->where($where);
            }
            if(!empty($order)){
                $this->db->order_by($order);
            }
            $result = $this->db->get();
            return $result;
        }
		/* UPDATE ADMIN SETTING */
	}