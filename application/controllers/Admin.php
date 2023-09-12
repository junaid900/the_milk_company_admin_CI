<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $userData = ["directory" => "madmin"];
        $this->session->set_userdata($userData);
        
    }

    /***** ADMIN INDEX *********/
    public function index()
    {
        if ($this->session->userdata('login') == 1) {
            redirect(base_url().admin_ctrl(). '/dashboard', 'refresh');
        }
        $this->load->view('madmin/login');
    }
    /***** ADMIN INDEX *********/
    /* VERIFY ACCOUNT */
    public function login()
    {
        // Validate the user can login
        $result = $this->Db_model->login_varify_accounts();
       
        /*	if($result =='blocked'){
                $this->session->set_flashdata('msg_error', 'Due to many unsuccessful times, your account is now locked. Please try again 2hours later.');
                redirect(base_url().'admin', 'refresh');
                l
            }else if($result =='permanent_blocked'){

                $this->session->set_flashdata('msg_error', 'Please contact the administrator to unlock your account. Please check your email for contact information');
                redirect(base_url().'admin', 'refresh');
            }*/

        // Now we verify the result
        if ($result) {
            if ($result->status == 'Inactive') {
//                echo "here";
//                exit();
                $this->session->set_flashdata('msg_error', 'your account is Inactive!');
                redirect(base_url() .admin_ctrl(), 'refresh');
            }
            /* $check_login_status = $this->db->get_where('user_login',array('user_accounts_id'=>$result->user_accounts_id));
             if($check_login_status->num_rows()>0){
                 //$_SERVER['REMOTE_ADDR'] == $check_login_status->row()->user_ip &&
                 if($check_login_status->row()->status == 'Active'){
                    $this->session->set_flashdata('msg_error', 'your account is already login from other device!');
                    redirect(base_url().'admin', 'refresh');
                 }else{
                     $s_update['status']  = 'Inactive';
                     $this->db->where('user_accounts_id',$result->user_accounts_id);
                     $this->db->update('user_login',$s_update);
                 }
             }
             $loginData['user_accounts_id'] = $result->user_accounts_id;
             $loginData['user_ip']          = $_SERVER['REMOTE_ADDR'];
             $loginData['date_added']       = date('Y-m-d h:i:s');
             $loginData['status']           = 'Active';
             $this->db->insert('user_login', $loginData);*/
            $this->session->set_userdata('user_name', $result->first_name);
            $this->session->set_userdata('users_id', $result->users_system_id);
            $this->session->set_userdata('users_email', $result->email);
            $this->session->set_userdata('user_roles_id', $result->users_roles_id);
            $this->session->set_userdata('directory', 'madmin');
            $this->session->set_userdata('login', 1);
            $this->session->set_flashdata('msg_success', 'Login Successfully.');
            redirect(base_url() .admin_ctrl(). '/manage_events', 'refresh');
        } else {
//            echo "reror";
//            exit();
            // If user did validate,
            $this->session->set_flashdata('msg_error', 'Email or password not correct!');
            redirect(base_url() .admin_ctrl(), 'refresh');
        }
    }


    public function forgot_password()
    {
        $this->load->view('admin/forgot_password');
    }

    public function CheckEmail($param1 = '', $param2 = '')
    {
        $email = $this->input->post('email');
        $db_val = $this->db->get_where('brinkman_user_accounts', array('email' => $email))->num_rows();
        if ($db_val > 0) {
            echo 'email already exist';
        } else {
            echo 'notexist';
        }
        exit;
    }

    public function retrieve_password($param1 = '', $param2 = '')
    {
        $user_email = $this->input->post('retrive_email');
        $response = $this->Db_model->retrieve_password($user_email);
        if ($response == 'Mail Sent') {
            $this->session->set_flashdata('msg_success', ' Password Reset Link Sent To Your Email Successfully');
        } else if ($response == 'Mail Not Sent') {
            $this->session->set_flashdata('msg_error', ' Error In Sending Mail. Try Again.');
        } else if ($response == 'Email Not Found') {
            $this->session->set_flashdata('msg_error', ' Email Not Found, Please Check Your Email');
        }
        $this->load->view('admin/login');
    }
    /***** VISITOR *********/
    public function manage_visitor($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
	
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_visitor')->result_array();
		$data['page_title'] 	= 'Visitor';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'manage_visitor';
		$data['actor']          = 'manage_visitor';
        $data['main_page_name'] = 'manage_visitor';
        $data["htmlPage"]       = "manage_visitor";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	public function view_vistor($param1='',$param2='',$param3=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
        if($param1=='delete'){
            $result = $this->Db_model->delete_saved_row('visitor',$param2,$param3);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/view_vistor/'.$param2.'/'.$param3, 'refresh');
        }
       
		if($param1 == 'update'){
		    $data['name']             = $this->input->post('name');
            $data['wechat']           = $this->input->post('wechat');
		    $data['phone']            = $this->input->post('phone');
		    $data['city']          = $this->input->post('city');
		    $data['address']          = $this->input->post('address');
            $this->db->where('visitor_id',$param2);
            $result = $this->db->update('brinkman_visitor',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_visitor', 'refresh');
		}
	
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_visitor',array('visitor_id'=>$param1))->row_array();
		if($param2=='saved_pubs'){
		    $data['saved_pubs']   = $this->Db_model->get_saved_pubs($param1,'Visitor');
		}
		if($param2=='saved_events'){
		    $data['saved_events'] = $this->Db_model->get_saved_events($param1,'Visitor');
		}
		$data['param1']         = $param1;
		$data['param2']         = $param2;
	    $data['page_title'] 	= 'Visitor';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'view_vistor';
		$data['actor']          = 'view_vistor';
        $data['main_page_name'] = 'manage_visitor';
        $data["htmlPage"]       = "view_vistor";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** VISITOR *********/
    /***** BATENDER *********/
    public function manage_bartender($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
	
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_bartender')->result_array();
		$data['page_title'] 	= 'Bartender';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'manage_bartender';
		$data['actor']          = 'manage_bartender';
        $data['main_page_name'] = 'manage_bartender';
        $data["htmlPage"]       = "manage_bartender";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	public function view_bartender($param1='',$param2='',$param3=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
        if($param1=='delete'){
            $result = $this->Db_model->delete_saved_row('Bartender',$param2,$param3);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/view_bartender/'.$param2.'/'.$param3, 'refresh');
        }
       
		if($param1 == 'update'){
         
            $data['first_name']       = $this->input->post('first_name');
		    $data['last_name']        = $this->input->post('last_name');
		    $data['other_name']       = $this->input->post('other_name');
		    $data['wechat']           = $this->input->post('wechat');
		    $data['company']          = $this->input->post('company');
		    $data['contact_number']   = $this->input->post('contact_number');
		    $data['date_of_birth']    = $this->input->post('date_of_birth');
		    $data['gender']           = $this->input->post('gender');
		    $data['city']             = $this->input->post('city');
		    
	        $school_array= array();
	        foreach($_POST['school_education'] as $key=>$fields){
	                $school_array[]=$_POST['school_education'][$key];
	        }	   
	        
    		$data['school_education'] = json_encode($school_array);
    	
    		$year_array= array();
	        foreach($_POST['year_education'] as $key=>$fields){
	                $year_array[]=$_POST['year_education'][$key];
	        }	
		    $data['year_education']   = json_encode($year_array);
		    
		    $bar_array= array();
	        foreach($_POST['bar_work'] as $key=>$fields){
	                $bar_array[]=$_POST['bar_work'][$key];
	        }	
		    $data['bar_work_1']       = json_encode($bar_array);
		    $position_array= array();
	        foreach($_POST['position_work'] as $key=>$fields){
	                $position_array[]=$_POST['position_work'][$key];
	        }
		    $data['position_work_1']  = json_encode($position_array);
		    
		    $data['en_introduction']  = $this->input->post('en_introduction');
		    $data['ch_introduction']  = $this->input->post('ch_introduction');
		    
            $this->db->where('bartender_id',$param2);
            $result = $this->db->update('brinkman_bartender',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
            redirect(base_url() . admin_ctrl() . '/manage_bartender/', 'refresh');
		}
	
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_bartender',array('bartender_id'=>$param1))->row_array();
		if($param2=='saved_pubs'){
		    $data['saved_pubs']   = $this->Db_model->get_saved_pubs($param1,'Bartender');
		}
		if($param2=='saved_events'){
		    $data['saved_events'] = $this->Db_model->get_saved_events($param1,'Bartender');
		}
		if($param2=='saved_jobs'){
		    $data['saved_jobs'] = $this->Db_model->get_saved_jobs($param1,'Bartender');
		}
		$data['param1']         = $param1;
		$data['param2']         = $param2;
	    $data['page_title'] 	= 'Bartender';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'view_bartender';
		$data['actor']          = 'view_bartender';
        $data['main_page_name'] = 'manage_bartender';
        $data["htmlPage"]       = "view_bartender";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
   /***** BATENDER *********/
    
   /***** BARADMIN *********/
    public function manage_baradmin($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
	
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_baradmin')->result_array();
		$data['page_title'] 	= 'Baradmin';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'manage_baradmin';
		$data['actor']          = 'manage_baradmin';
        $data['main_page_name'] = 'manage_baradmin';
        $data["htmlPage"]       = "manage_baradmin";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	public function view_baradmin($param1='',$param2='',$param3=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
        if($param1=='delete'){
            $result = $this->Db_model->delete_saved_row('barAdmin',$param2,$param3);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/view_baradmin/'.$param2.'/'.$param3, 'refresh');
        }
       
		if($param1 == 'update'){
         
            $data['first_name']       = $this->input->post('first_name');
		    $data['last_name']        = $this->input->post('last_name');
		    $data['other_name']       = $this->input->post('other_name');
		    $data['wechat']           = $this->input->post('wechat');
		    $data['company']          = $this->input->post('company');
		    $data['contact_number']   = $this->input->post('contact_number');
		    $data['date_of_birth']    = $this->input->post('date_of_birth');
		    $data['gender']           = $this->input->post('gender');
		    $data['city']             = $this->input->post('city');
		    
	        $data['en_introduction']  = $this->input->post('en_introduction');
		    $data['ch_introduction']  = $this->input->post('ch_introduction');
		    
            $this->db->where('baradmin_id',$param2);
            $result = $this->db->update('brinkman_baradmin',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
            redirect(base_url() . admin_ctrl() . '/manage_baradmin/', 'refresh');
		}
	
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_baradmin',array('baradmin_id'=>$param1))->row_array();
		if($param2=='saved_pubs'){
		    $data['saved_pubs']   = $this->Db_model->get_saved_pubs($param1,'barAdmin');
		}
		if($param2=='saved_events'){
		    $data['saved_events'] = $this->Db_model->get_saved_events($param1,'barAdmin');
		}
		if($param2=='saved_jobs'){
		    $data['saved_jobs'] = $this->Db_model->get_saved_jobs($param1,'barAdmin');
		}
		$data['param1']         = $param1;
		$data['param2']         = $param2;
	    $data['page_title'] 	= 'BarAdmin';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'view_baradmin';
		$data['actor']          = 'view_baradmin';
        $data['main_page_name'] = 'manage_baradmin';
        $data["htmlPage"]       = "view_baradmin";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
   /***** BATENDER *********/
    
    
   /***** WHOLESALER *********/
    public function manage_wholesaler($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
	
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_wholesaler')->result_array();
		$data['page_title'] 	= 'Wholesaler';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'manage_wholesaler';
		$data['actor']          = 'manage_wholesaler';
        $data['main_page_name'] = 'manage_wholesaler';
        $data["htmlPage"]       = "manage_wholesaler";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	public function view_wholesaler($param1='',$param2='',$param3=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
        if($param1=='delete'){
            $result = $this->Db_model->delete_saved_row('Wholesaler',$param2,$param3);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/view_wholesaler/'.$param2.'/'.$param3, 'refresh');
        }
       
		if($param1 == 'update'){
            $data['wechat']             = $this->input->post('wechat');
		    $data['phone']             = $this->input->post('phone');
		    $data['company']          = $this->input->post('company');
		    $data['grade']          = $this->input->post('grade');
            $this->db->where('wholesaler_id',$param2);
            $result = $this->db->update('brinkman_wholesaler',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_wholesaler/', 'refresh');
		}
	
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_wholesaler',array('wholesaler_id'=>$param1))->row_array();
		if($param2=='saved_pubs'){
		    $data['saved_pubs']   = $this->Db_model->get_saved_pubs($param1,'Wholesaler');
		}
		if($param2=='saved_events'){
		    $data['saved_events'] = $this->Db_model->get_saved_events($param1,'Wholesaler');
		}
		$data['param1']         = $param1;
		$data['param2']         = $param2;
	    $data['page_title'] 	= 'Wholesaler';
		$data['page_sub_title'] = 'Users';
		$data['page_name'] 		= 'view_wholesaler';
		$data['actor']          = 'view_wholesaler';
        $data['main_page_name'] = 'manage_wholesaler';
        $data["htmlPage"]       = "view_wholesaler";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** WHOLESALER *********/
  
    /***** BRANDS *********/
	public function manage_brands($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_products_brands SET position_order=" . $i . " WHERE products_brands_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('products_brands_id', $brands_id);
            $result = $this->db->update('brinkman_products_brands', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('products_brands_id', $param2);
            $result = $this->db->delete('brinkman_products_brands');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_brands', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_products_brands')->result_array();
		$data['page_title'] 	= 'Brands';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'manage_brands';
		$data['actor']          = 'manage_brands';
        $data['main_page_name'] = 'manage_brands';
        $data["htmlPage"]       = "manage_brands";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_brand($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['en_details']          = $this->input->post('en_details');
		    $data['ch_details']          = $this->input->post('ch_details');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/brands/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $result = $this->db->insert('brinkman_products_brands',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_brands', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	   	$data['page_title'] 	= 'Brands';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'add_brand';
		$data['actor']          = 'add_brand';
        $data['main_page_name'] = 'manage_brands';
        $data["htmlPage"]       = "add_brand";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_brand($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['en_details']          = $this->input->post('en_details');
		    $data['ch_details']          = $this->input->post('ch_details');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/brands/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $this->db->where('products_brands_id',$param2);
            $result = $this->db->update('brinkman_products_brands',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_brands', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_products_brands',array('products_brands_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Brands';
		$data['page_sub_title'] = 'Brands';
		$data['page_name'] 		= 'edit_brand';
		$data['actor']          = 'edit_brand';
        $data['main_page_name'] = 'manage_brands';
        $data["htmlPage"]       = "edit_brand";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** BRANDS *********/
	
	

	/***** PUBS CATEGORY *********/
	public function manage_pubs_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_pubs_category SET position_order=" . $i . " WHERE pubs_category_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('pubs_category_id', $brands_id);
            $result = $this->db->update('brinkman_pubs_category', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('pubs_category_id', $param2);
            $result = $this->db->delete('brinkman_pubs_category');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs_category', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_pubs_category')->result_array();
		$data['page_title'] 	= 'Bars Category';
		$data['page_sub_title'] = 'Bars';
		$data['page_name'] 		= 'manage_pubs_category';
		$data['actor']          = 'manage_pubs_category';
        $data['main_page_name'] = 'manage_pubs_category';
        $data["htmlPage"]       = "manage_pubs_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_pubs_category($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $result = $this->db->insert('brinkman_pubs_category',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs_category', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	   	$data['page_title'] 	= 'Bars Category';
		$data['page_sub_title'] = 'Category';
		$data['page_name'] 		= 'add_pubs_category';
		$data['actor']          = 'add_pubs_category';
        $data['main_page_name'] = 'manage_pubs_category';
        $data["htmlPage"]       = "add_pubs_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_pubs_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $this->db->where('pubs_category_id',$param2);
            $result = $this->db->update('brinkman_pubs_category',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs_category', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_pubs_category',array('pubs_category_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Bars Category';
		$data['page_sub_title'] = 'Bars Category';
		$data['page_name'] 		= 'edit_pubs_category';
		$data['actor']          = 'edit_pubs_category';
        $data['main_page_name'] = 'manage_pubs_category';
        $data["htmlPage"]       = "edit_pubs_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	/***** PUBS CATEGORY *********/
	/***** PUBS *********/
	public function manage_pubs($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_pubs SET position_order=" . $i . " WHERE pubs_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('pubs_id', $brands_id);
            $result = $this->db->update('brinkman_pubs', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('pubs_id', $param2);
            $result = $this->db->delete('brinkman_pubs');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
        }
        if($param1=='excel_import'){
            $this->load->library('excel');
          if(isset($_FILES["file"]["name"]))
          {
           $path = $_FILES["file"]["tmp_name"];
      
           $object = PHPExcel_IOFactory::load($path);
           foreach($object->getWorksheetIterator() as $worksheet)
           {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
             $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
             $city = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $province = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
             $district = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
             $address = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
             $openhours = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
             $p_number = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
             $address = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
           // `en_name`, `ch_name`, `city`, `province`, `district`, `address`, `number`, `website_link`, `image`, `created_at`, `status`
             $data[] = array(
              'en_name'  => $name,
              'ch_name'   => $name,
              'city'    => $city,
              'province'  => $province,
              'district'   => $district,
              'address'   => $address,
              'number'   => $p_number,
              'status'   => 'Active'
             );
            }
           }
           $result = $this->db->insert_batch('brinkman_pubs',$data);
           if($result){
		       $this->session->set_flashdata('msg_success', ' Excel Imported Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		   redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
           exit;
         } 
    
        }
        if($param1=='excel_export'){
            
                
            // create file name
            $fileName = 'data-'.time().'.xlsx';  
            // load excel library
            $this->load->library('excel');
            $listInfo = $this->db->get('brinkman_pubs')->result();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
           
            
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'BarID');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'BarName');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'City');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Province');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'District');  
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Address');  
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'OpenHours');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Number');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Event');
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Job');
            // set Row
            $rowCount = 2;
            foreach ($listInfo as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->pubs_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->en_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->city);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->province);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->district);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->address);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->number);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Events');
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Job');
                
                $rowCount++;
            }
            $filename = "pubs". date("Y-m-d-H-i-s").".csv";
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
            $objWriter->save('php://output'); 
 
           // redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
            exit;
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_pubs')->result_array();
		$data['page_title'] 	= 'Bars';
		$data['page_sub_title'] = 'Bars';
		$data['page_name'] 		= 'manage_pubs';
		$data['actor']          = 'manage_pubs';
        $data['main_page_name'] = 'manage_pubs';
        $data["htmlPage"]       = "manage_pubs";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_pub($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['city']                = $this->input->post('city');
		    $data['province']            = $this->input->post('province');
		    $data['district']            = $this->input->post('district');
		    $data['address']             = $this->input->post('address');
		    $data['number']              = $this->input->post('number');
		    $data['website_link']        = $this->input->post('website_link');
		    $data['pubs_category_id']    = $this->input->post('pubs_category_id');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/pubs/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $result = $this->db->insert('brinkman_pubs',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['category'] 	    = $this->db->get_where('brinkman_pubs_category',array('status'=>'Active'))->result_array();
	   	$data['page_title'] 	= 'Bars';
		$data['page_sub_title'] = 'Bars';
		$data['page_name'] 		= 'add_pub';
		$data['actor']          = 'add_pub';
        $data['main_page_name'] = 'manage_pubs';
        $data["htmlPage"]       = "add_pub";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_pub($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['city']                = $this->input->post('city');
		    $data['province']            = $this->input->post('province');
		    $data['district']            = $this->input->post('district');
		    $data['address']             = $this->input->post('address');
		    $data['number']              = $this->input->post('number');
		    $data['pubs_category_id']    = $this->input->post('pubs_category_id');
		    $data['website_link']        = $this->input->post('website_link');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/pubs/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $this->db->where('pubs_id',$param2);
            $result = $this->db->update('brinkman_pubs',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_pubs',array('pubs_id'=>$param1))->row_array();
		$data['category'] 	    = $this->db->get_where('brinkman_pubs_category',array('status'=>'Active'))->result_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Bars';
		$data['page_sub_title'] = 'Bars';
		$data['page_name'] 		= 'edit_pub';
		$data['actor']          = 'edit_pub';
        $data['main_page_name'] = 'manage_pubs';
        $data["htmlPage"]       = "edit_pub";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
  
     
	/***** Pubs *********/
	
	/***** JOB CATEGORY *********/
	public function manage_job_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_job_category SET position_order=" . $i . " WHERE job_category_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('job_category_id', $brands_id);
            $result = $this->db->update('brinkman_job_category', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('job_category_id', $param2);
            $result = $this->db->delete('brinkman_job_category');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job_category', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_job_category')->result_array();
		$data['page_title'] 	= 'Job Category';
		$data['page_sub_title'] = 'job';
		$data['page_name'] 		= 'manage_job_category';
		$data['actor']          = 'manage_job_category';
        $data['main_page_name'] = 'manage_job_category';
        $data["htmlPage"]       = "manage_job_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_job_category($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $result = $this->db->insert('brinkman_job_category',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job_category', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	   	$data['page_title'] 	= 'Job Category';
		$data['page_sub_title'] = 'Category';
		$data['page_name'] 		= 'add_job_category';
		$data['actor']          = 'add_job_category';
        $data['main_page_name'] = 'manage_job_category';
        $data["htmlPage"]       = "add_job_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_job_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $this->db->where('job_category_id',$param2);
            $result = $this->db->update('brinkman_job_category',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job_category', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_job_category',array('job_category_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Job Category';
		$data['page_sub_title'] = 'Job Category';
		$data['page_name'] 		= 'edit_job_category';
		$data['actor']          = 'edit_job_category';
        $data['main_page_name'] = 'manage_job_category';
        $data["htmlPage"]       = "edit_job_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	/***** JOB CATEGORY *********/
	/***** JOB *********/
	public function manage_job($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_job SET position_order=" . $i . " WHERE job_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('job_id', $brands_id);
            $result = $this->db->update('brinkman_job', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('job_id', $param2);
            $result = $this->db->delete('brinkman_job');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job', 'refresh');
        }
        if($param1=='excel_import'){
            $this->load->library('excel');
          if(isset($_FILES["file"]["name"]))
          {
           $path = $_FILES["file"]["tmp_name"];
      
           $object = PHPExcel_IOFactory::load($path);
           foreach($object->getWorksheetIterator() as $worksheet)
           {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
            
                
                
            // $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
            // $city = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $position = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
             $experience = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $job_type = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
             $pubs_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
             $location = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
             $deadline = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
             $detail = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            /* $saveData['en_name'] =  
             $this->db->insert('brinkman_pubs',$saveData);
             $this->db->insert_id();*/
             
             $pubs_id = $this->db->get_where('brinkman_pubs',array('en_name'=>$pubs_name))->row()->pubs_id; 
             if(!empty($pubs_id)){
                 $pubs_id = $pubs_id;
             }else{
                 $pubs_id = 0;
             }
             $data[] = array(
              'position'  => $position,
              'experience'   => $experience,
              'job_type'    => $job_type,
              'pubs_id'  => $pubs_id,
              'location'   => $location,
              'deadline'   => $deadline,
              'detail'   => $detail,
              'status'   => 'Active'
             );
            }
           }
           $result = $this->db->insert_batch('brinkman_job',$data);
           if($result){
		       $this->session->set_flashdata('msg_success', ' Excel Imported Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		   redirect(base_url() . admin_ctrl() . '/manage_job', 'refresh');
           exit;
         } 
    
        }
        if($param1=='excel_export'){
            
                
            // create file name
            $fileName = 'data-'.time().'.xlsx';  
            // load excel library
            $this->load->library('excel');
            $listInfo = $this->db->get('brinkman_job')->result();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
           
            
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'JOBID');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Experience');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'JobType');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bar');  
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Location');  
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Deadline');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Detail');
            // set Row
            $rowCount = 2;
            foreach ($listInfo as $row) {
                $pub_name = $this->db->get_where('brinkman_pubs',array('pubs_id'=>$row->pubs_id))->row()->en_name; 
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->job_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->position);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->experience);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->job_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $pub_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->location);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->deadline);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->detail);
                
                $rowCount++;
            }
            $filename = "jobs". date("Y-m-d-H-i-s").".csv";
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
            $objWriter->save('php://output'); 
 
           // redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
            exit;
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_job')->result_array();
		$data['page_title'] 	= 'Job';
		$data['page_sub_title'] = 'Job';
		$data['page_name'] 		= 'manage_job';
		$data['actor']          = 'manage_job';
        $data['main_page_name'] = 'manage_job';
        $data["htmlPage"]       = "manage_job";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_job($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['position']            = $this->input->post('position');
		    $data['experience']          = $this->input->post('experience');
		    $data['job_type']            = $this->input->post('job_type');
		    $data['pubs_id']             = $this->input->post('pubs_id');
		    $data['location']            = $this->input->post('location');
		    $data['deadline']            = $this->input->post('deadline');
		    $data['salary_low']          = $this->input->post('salary_low');
		    $data['salary_high']         = $this->input->post('salary_high');
		    
		    $data['detail']              = $this->input->post('detail');
		    $data['job_category_id']     = $this->input->post('job_category_id');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/jobs/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $result = $this->db->insert('brinkman_job',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job', 'refresh');
		}
		$data['pub']            = $this->db->get_where('brinkman_pubs',array('status'=>'Active'))->result_array();
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['category'] 	    = $this->db->get_where('brinkman_job_category',array('status'=>'Active'))->result_array();
	   	$data['page_title'] 	= 'Job';
		$data['page_sub_title'] = 'Job';
		$data['page_name'] 		= 'add_job';
		$data['actor']          = 'add_job';
        $data['main_page_name'] = 'manage_job';
        $data["htmlPage"]       = "add_job";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_job($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
            $data['position']            = $this->input->post('position');
		    $data['experience']          = $this->input->post('experience');
		    $data['job_type']            = $this->input->post('job_type');
		    $data['pubs_id']             = $this->input->post('pubs_id');
		    $data['location']            = $this->input->post('location');
		    $data['deadline']            = $this->input->post('deadline');
		    $data['salary_low']          = $this->input->post('salary_low');
		    $data['salary_high']         = $this->input->post('salary_high');
		 
		    $data['detail']              = $this->input->post('detail');
		    $data['job_category_id']     = $this->input->post('job_category_id');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/jobs/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
            $this->db->where('job_id',$param2);
            $result = $this->db->update('brinkman_job',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_job', 'refresh');
		}
		$data['pub']            = $this->db->get_where('brinkman_pubs',array('status'=>'Active'))->result_array();
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_job',array('job_id'=>$param1))->row_array();
		$data['category'] 	    = $this->db->get_where('brinkman_job_category',array('status'=>'Active'))->result_array();
        $data['param1']         = $param1;
	    $data['page_title'] 	= 'Job';
		$data['page_sub_title'] = 'Job';
		$data['page_name'] 		= 'edit_job';
		$data['actor']          = 'edit_job';
        $data['main_page_name'] = 'manage_job';
        $data["htmlPage"]       = "edit_job";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** job *********/
	
   /***** EVENT CATEGORY *********/
	public function manage_events_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_events_category SET position_order=" . $i . " WHERE events_category_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('events_category_id', $brands_id);
            $result = $this->db->update('brinkman_events_category', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('events_category_id', $param2);
            $result = $this->db->delete('brinkman_events_category');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events_category', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_events_category')->result_array();
		$data['page_title'] 	= 'Events Category';
		$data['page_sub_title'] = 'Events';
		$data['page_name'] 		= 'manage_events_category';
		$data['actor']          = 'manage_events_category';
        $data['main_page_name'] = 'manage_events_category';
        $data["htmlPage"]       = "manage_events_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_events_category($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $result = $this->db->insert('brinkman_events_category',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events_category', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	   	$data['page_title'] 	= 'Events Category';
		$data['page_sub_title'] = 'Category';
		$data['page_name'] 		= 'add_events_category';
		$data['actor']          = 'add_events_category';
        $data['main_page_name'] = 'manage_events_category';
        $data["htmlPage"]       = "add_events_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_events_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $this->db->where('events_category_id',$param2);
            $result = $this->db->update('brinkman_events_category',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events_category', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_events_category',array('events_category_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Events Category';
		$data['page_sub_title'] = 'Events Category';
		$data['page_name'] 		= 'edit_events_category';
		$data['actor']          = 'edit_events_category';
        $data['main_page_name'] = 'manage_events_category';
        $data["htmlPage"]       = "edit_events_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** EVENT CATEGORY *********/
	
	/***** EVENTS *********/
	public function manage_events($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_events SET position_order=" . $i . " WHERE events_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('events_id', $brands_id);
            $result = $this->db->update('brinkman_events', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('events_id', $param2);
            $result = $this->db->delete('brinkman_events');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_events')->result_array();
		$data['page_title'] 	= 'Events';
		$data['page_sub_title'] = 'Events';
		$data['page_name'] 		= 'manage_events';
		$data['actor']          = 'manage_events';
        $data['main_page_name'] = 'manage_events';
        $data["htmlPage"]       = "manage_events";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_events($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    
		    $data['events_category_id']   = $this->input->post('events_category_id');
		    $data['pubs_id']              = $this->input->post('pubs_id');
		    $data['en_title']             = $this->input->post('en_name');
		    $data['ch_title']             = $this->input->post('ch_name');
		    $data['ch_details']           = $this->input->post('ch_details');
		    $data['en_details']           = $this->input->post('en_details');
		    $data['start_date']           = $this->input->post('start_date');
		    $data['end_date']             = $this->input->post('end_date');
		    $data['start_time']           = $this->input->post('start_time');
		    $data['end_time']             = $this->input->post('end_time');
		    $data['days']               = json_encode($this->input->post('days'));
		    $data['city']                = $this->input->post('city');
		    $data['district']            = $this->input->post('district');
		    
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/events/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
		    $result = $this->db->insert('brinkman_events',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['category'] 	    = $this->db->get_where('brinkman_events_category',array('status'=>'Active'))->result_array();
		$data['pubs'] 	        = $this->db->get_where('brinkman_pubs',array('status'=>'Active'))->result_array();
	   	$data['page_title'] 	= 'Events ';
		$data['page_sub_title'] = 'Events';
		$data['page_name'] 		= 'add_events';
		$data['actor']          = 'add_events';
        $data['main_page_name'] = 'manage_events';
        $data["htmlPage"]       = "add_events";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_events($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
		    $data['events_category_id']   = $this->input->post('events_category_id');
		    $data['pubs_id']              = $this->input->post('pubs_id');
            $data['en_title']             = $this->input->post('en_name');
		    $data['ch_title']             = $this->input->post('ch_name');
		    $data['ch_details']          = $this->input->post('ch_details');
		    $data['en_details']          = $this->input->post('en_details');
            $data['start_date']           = $this->input->post('start_date');
		    $data['end_date']             = $this->input->post('end_date');
		    $data['start_time']           = $this->input->post('start_time');
		    $data['end_time']             = $this->input->post('end_time');
		    $data['city']                = $this->input->post('city');
		    $data['district']            = $this->input->post('district');
		    $data['days']               = json_encode($this->input->post('days'));
		    
		    $data['status']              = $this->input->post('status');
		      if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/events/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['image'] = $path_to_file;
            }
		    $this->db->where('events_id',$param2);
            $result = $this->db->update('brinkman_events',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_events', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_events',array('events_id'=>$param1))->row_array();
		$data['category'] 	    = $this->db->get_where('brinkman_events_category',array('status'=>'Active'))->result_array();
		$data['pubs'] 	        = $this->db->get_where('brinkman_pubs',array('status'=>'Active'))->result_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Events';
		$data['page_sub_title'] = 'Events';
		$data['page_name'] 		= 'edit_events';
		$data['actor']          = 'edit_events';
        $data['main_page_name'] = 'manage_events';
        $data["htmlPage"]       = "edit_events";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** EVENT *********/
	
	
	 /***** DOCUMENTS *********/
	public function manage_documents($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_products_brands SET position_order=" . $i . " WHERE products_documents_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('products_documents_id', $brands_id);
            $result = $this->db->update('brinkman_products_documents', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('products_documents_id', $param2);
            $result = $this->db->delete('brinkman_products_documents');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_documents', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_products_documents')->result_array();
		$data['page_title'] 	= 'Documents';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'manage_documents';
		$data['actor']          = 'manage_documents';
        $data['main_page_name'] = 'manage_documents';
        $data["htmlPage"]       = "manage_documents";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_document($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		   // print_r($_POST);
		    
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['permission']          = json_encode($_POST['permission']);
		    $data['products_id']         = $this->input->post('products_id');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/documents/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['attachment'] = $path_to_file;
            }
            $result = $this->db->insert('brinkman_products_documents',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_documents', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['products'] 	    = $this->db->get_where('brinkman_products',array('status'=>'Active'))->result_array();
	   	$data['page_title'] 	= 'Documents';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'add_document';
		$data['actor']          = 'add_document';
        $data['main_page_name'] = 'manage_documents';
        $data["htmlPage"]       = "add_document";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_document($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['permission']          = json_encode($_POST['permission']);
		    $data['products_id']         = $this->input->post('products_id');
		    $data['status']              = $this->input->post('status');
		    if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_mimage.jpg';
                $path_to_file = 'uploads/documents/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $data['attachment'] = $path_to_file;
            }
            $this->db->where('products_documents_id',$param2);
            $result = $this->db->update('brinkman_products_documents',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_documents', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
       	$data['products'] 	    = $this->db->get_where('brinkman_products',array('status'=>'Active'))->result_array();
		$data['edit_data']      = $this->db->get_where('brinkman_products_documents',array('products_documents_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Documents';
		$data['page_sub_title'] = 'Documents';
		$data['page_name'] 		= 'edit_document';
		$data['actor']          = 'edit_document';
        $data['main_page_name'] = 'manage_documents';
        $data["htmlPage"]       = "edit_document";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** DOCUMENTS *********/
	/***** CATEGORY *********/
	public function manage_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_products_category SET position_order=" . $i . " WHERE products_category_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('products_category_id', $brands_id);
            $result = $this->db->update('brinkman_products_category', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('products_category_id', $param2);
            $result = $this->db->delete('brinkman_products_category');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_category', 'refresh');
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_products_category')->result_array();
		$data['page_title'] 	= 'Category';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'manage_category';
		$data['actor']          = 'manage_category';
        $data['main_page_name'] = 'manage_category';
        $data["htmlPage"]       = "manage_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_category($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $result = $this->db->insert('brinkman_products_category',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_category', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	   	$data['page_title'] 	= 'Category';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'add_category';
		$data['actor']          = 'add_category';
        $data['main_page_name'] = 'manage_category';
        $data["htmlPage"]       = "add_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_category($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['status']              = $this->input->post('status');
		    $this->db->where('products_category_id',$param2);
            $result = $this->db->update('brinkman_products_category',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_category', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_products_category',array('products_category_id'=>$param1))->row_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Category';
		$data['page_sub_title'] = 'Category';
		$data['page_name'] 		= 'edit_category';
		$data['actor']          = 'edit_category';
        $data['main_page_name'] = 'manage_category';
        $data["htmlPage"]       = "edit_category";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** CATEGORY *********/
    /***** PRODUCTS *********/
    public function upload_products_image(){
	    if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		$img = $_POST['img'];
		$data = base64_decode($img);
		$image_name = 'products_'.time().'.png';
        $upload_image = file_put_contents('uploads/products/'.$image_name, $data);
        if($upload_image){
            $save_image = 'uploads/products/'.$image_name;
            
            $save['image'] = $save_image;
            /*if($_POST['id'] ==0){
                $this->db->insert('client_images',$save);
            }else{
                $this->db->where('client_images_id',$_POST['id']);
                $this->db->update('client_images',$save);
            }*/
            
            
            echo $save_image;
        }else{
            echo 'error';
        }
        exit;
	}
	public function manage_products($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
		if ($param1 == 'sort') {
            $position = $_POST['position'];
            $i = count($position);
            foreach ($position as $k => $v) {
                $sql = "Update brinkman_products SET position_order=" . $i . " WHERE products_id=" . $v . " ORDER BY position_order desc";
                $this->db->query($sql);
                $i--;
            }
            echo "success";
            exit();
        }
        if ($param1 == 'update_status') {
            $brands_id = $this->input->post('id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('products_id', $brands_id);
            $result = $this->db->update('brinkman_products', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
        if($param1=='delete'){
            $this->db->where('products_id', $param2);
            $result = $this->db->delete('brinkman_products');
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_products', 'refresh');
        }
        if($param1=='excel_import'){
            $this->load->library('excel');
          if(isset($_FILES["file"]["name"]))
          {
           $path = $_FILES["file"]["tmp_name"];
      
           $object = PHPExcel_IOFactory::load($path);
           foreach($object->getWorksheetIterator() as $worksheet)
           {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
                
             $products_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
             $en_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $ch_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
             $brand_en_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
             $brand_ch_name = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
             $category_en_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
             $category_ch_name = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
             $ABV = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
             $volume = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
             $ch_origin = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
             $en_origin = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
             $ch_details = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
             $en_details = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
             $retail_price = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
             $trade_price = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
             $wholesaler_price = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
             $special_price = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
             $brands_id = $this->db->get_where('brinkman_products_brands',array('en_name'=>$brand_en_name))->row()->products_brands_id; 
             if(!empty($brands_id)){
                 $brands_id = $brands_id;
             }else{
                 $brands_id = 0;
             }
             
             $category_id = $this->db->get_where('brinkman_products_category',array('en_name'=>$category_en_name))->row()->products_category_id; 
             if(!empty($category_id)){
                 $category_id = $category_id;
             }else{
                 $category_id = 0;
             }
             $data[] = array(
                'en_name'  => $en_name,
                'ch_name'   => $ch_name,
                'products_brands_id'    => $brands_id,
                'products_category_id'  => $category_id,
                'ABV'   => $ABV,
                'volume'   => $volume,
                'ch_origin'   => $ch_origin,
                'en_origin'   => $en_origin,
                'ch_details'   => $ch_details,
                'en_details'   => $en_details,
                'retail_price'   => $retail_price,
                'trade_price'   => $trade_price,
                'wholesaler_price'   => $wholesaler_price,
                'special_price'   => $special_price,
                'status'   => 'Active'
             );
            }
           }
           $result = $this->db->insert_batch('brinkman_products',$data);
           if($result){
		       $this->session->set_flashdata('msg_success', ' Excel Imported Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		   redirect(base_url() . admin_ctrl() . '/manage_job', 'refresh');
           exit;
         } 
    
        }
        if($param1=='excel_export'){
            
                
            // create file name
            $fileName = 'data-'.time().'.xlsx';  
            // load excel library
            $this->load->library('excel');
            $listInfo = $this->db->get('brinkman_products')->result();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
           
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ProductID');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'NameCN');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NameEN');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'BrandCN');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'BrandEN');  
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CategoryCN');  
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'CategoryEN');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'ABV');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Volume');
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'OriginCN');
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'OriginEN');
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'DetailCN');
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'DetailEN');
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'RetailPrice');
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'TradePrice');
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'WholesalerPrice');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'SpecialPrice');
            // set Row
            $rowCount = 2;
            foreach ($listInfo as $row) {
                $brands = $this->db->get_where('brinkman_products_brands',array('products_brands_id'=>$row->products_brands_id))->row(); 
                $category = $this->db->get_where('brinkman_products_category',array('products_category_id'=>$row->products_category_id))->row(); 
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->products_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->en_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->ch_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $brands->en_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $brands->ch_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $category->en_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $category->ch_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->ABV);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->volume);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->ch_origin);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->en_origin);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->ch_details);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->en_details);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->retail_price);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->trade_price);
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->wholesaler_price);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->special_price);
     
                $rowCount++;
            }
            $filename = "products_". date("Y-m-d-H-i-s").".csv";
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
            $objWriter->save('php://output'); 
 
           // redirect(base_url() . admin_ctrl() . '/manage_pubs', 'refresh');
            exit;
        }
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
	    $data['table_data']     = $this->db->get('brinkman_products')->result_array();
		$data['page_title'] 	= 'Products';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'manage_products';
		$data['actor']          = 'manage_products';
        $data['main_page_name'] = 'manage_products';
        $data["htmlPage"]       = "manage_products";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function add_product($param1=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		} 
		if($param1 == 'save'){
		    $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['en_details']          = $this->input->post('en_details');
		    $data['ch_details']          = $this->input->post('ch_details');
		    $data['products_brands_id']  = $this->input->post('products_brands_id');
		    $data['en_origin']           = $this->input->post('en_origin');
		    $data['ch_origin']           = $this->input->post('ch_origin');
		    $data['products_category_id']= $this->input->post('products_category_id');
		    $data['ABV']                 = $this->input->post('ABV');
		    $data['volume']              = $this->input->post('volume');
		    /*$data['retail_price']        = $this->input->post('retail_price');
		    $data['trade_price']         = $this->input->post('trade_price');
		    $data['wholesaler_price']    = $this->input->post('wholesaler_price');
		    $data['special_price']       = $this->input->post('special_price');*/
		    $data['status']              = $this->input->post('status');
		    $data['image']               = json_encode($this->input->post('image_array'));
		    $data['tier_price']          = json_encode($this->input->post('tier_prices'));
		    
		    
		    if (!empty($_FILES['document']['name'])) {
                $file_name = time() .$_FILES['document']['name'];
                $path_to_file = 'uploads/products/' . $file_name;
                move_uploaded_file($_FILES['document']['tmp_name'], $path_to_file);
                $data['document'] = $path_to_file;
            }
            $result = $this->db->insert('brinkman_products',$data);
            if($result){
		       $this->session->set_flashdata('msg_success', ' Data Added Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_products', 'refresh');
		}
		$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['brands'] 	    = $this->db->get_where('brinkman_products_brands',array('status'=>'Active'))->result_array();
		$data['category'] 	    = $this->db->get_where('brinkman_products_category',array('status'=>'Active'))->result_array();
	   	$data['page_title'] 	= 'Products';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'add_product';
		$data['actor']          = 'add_product';
        $data['main_page_name'] = 'manage_products';
        $data["htmlPage"]       = "add_product";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	
	public function edit_product($param1='',$param2=''){
		if($this->session->userdata('login') != 1){
			redirect(base_url() . strtolower($this->session->userdata('directory')), 'refresh');
		}
       
		if($param1 == 'update'){
            $data['en_name']             = $this->input->post('en_name');
		    $data['ch_name']             = $this->input->post('ch_name');
		    $data['en_details']          = $this->input->post('en_details');
		    $data['ch_details']          = $this->input->post('ch_details');
		    $data['products_brands_id']  = $this->input->post('products_brands_id');
		    $data['en_origin']           = $this->input->post('en_origin');
		    $data['ch_origin']           = $this->input->post('ch_origin');
		    $data['products_category_id']= $this->input->post('products_category_id');
		    $data['ABV']                 = $this->input->post('ABV');
		    $data['volume']              = $this->input->post('volume');
		    /*$data['retail_price']        = $this->input->post('retail_price');
		    $data['trade_price']         = $this->input->post('trade_price');
		    $data['wholesaler_price']    = $this->input->post('wholesaler_price');
		    $data['special_price']       = $this->input->post('special_price');*/
		    $data['status']              = $this->input->post('status');
		    $data['image']               = json_encode($this->input->post('image_array'));
		    $data['tier_price']          = json_encode($this->input->post('tier_prices'));
		    
		    
		    if (!empty($_FILES['document']['name'])) {
                $file_name = time() .$_FILES['document']['name'];
                $path_to_file = 'uploads/products/' . $file_name;
                move_uploaded_file($_FILES['document']['tmp_name'], $path_to_file);
                $data['document'] = $path_to_file;
            }
            $this->db->where('products_id',$param2);
            $result = $this->db->update('brinkman_products',$data);
            $last_id = $this->db->insert_id();
           
		    if($result){
		       $this->session->set_flashdata('msg_success', ' Data Updated Successfully');
            }else{
		       $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
		    redirect(base_url() . admin_ctrl() . '/manage_products', 'refresh');
		}
       	$data['system_data'] 	= $this->db->get('brinkman_system_settings')->result();
		$data['edit_data']      = $this->db->get_where('brinkman_products',array('products_id'=>$param1))->row_array();
		$data['brands'] 	    = $this->db->get_where('brinkman_products_brands',array('status'=>'Active'))->result_array();
		$data['category'] 	    = $this->db->get_where('brinkman_products_category',array('status'=>'Active'))->result_array();
		$data['param1']         = $param1;
	    $data['page_title'] 	= 'Products';
		$data['page_sub_title'] = 'Products';
		$data['page_name'] 		= 'edit_product';
		$data['actor']          = 'edit_product';
        $data['main_page_name'] = 'manage_products';
        $data["htmlPage"]       = "edit_product";
		$this->load->view(strtolower($this->session->userdata('directory')) .'/index', $data);
	}
	/***** PRODUCTS *********/
    /***** Language *********/
    public function change_language()
    {
        $lang = $this->input->post('lang');

        if ($lang == 'english') {
            $this->session->set_userdata('current_language', 'english');
            $this->session->set_userdata('language_country', 'english');
            $this->session->set_userdata('controller_name', 'en');
            
        } else {
            $this->session->set_userdata('current_language', 'Chinese');
            $this->session->set_userdata('language_country', 'Chinese');
            $this->session->set_userdata('controller_name', 'ch');
        }

        exit;

    }

    public function language($param1 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        $data['profile_data'] = $this->db->get_where('brinkman_users_system', array('users_system_id' => '1'))->row();
        $data['page_title'] = get_phrase('manage_language');
        $data['page_sub_title'] = 'Manage Language';
        $data['page_name'] = 'manage_language';
        $data['actor'] = 'manage_language';
        $data['main_page_name'] = 'manage_language';
        $data["htmlPage"] = "manage_language";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

    public function edit_language($param1 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        if ($param1 == 'edit') {
            $phrase_id = $this->input->post('phrase_id');
            $lang = $this->input->post('lang');
            $data[$lang] = $this->input->post('phrase_value');
            //$this->db->where('Spainish',$this->input->post('phrase_value'));
            $this->db->where('phrase_id', $phrase_id);
            $result = $this->db->update('brinkman_language', $data);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }

        $data['profile_data'] = $this->db->get_where('brinkman_users_system', array('users_system_id' => '1'))->row();
        $data['param1'] = $param1;
        $data['page_title'] = get_phrase('edit_language');
        $data['page_sub_title'] = 'Edit Language';
        $data['page_name'] = 'edit_language';
        $data['actor'] = 'edit_language';
        $data['main_page_name'] = 'edit_language';
        $data["htmlPage"] = "edit_language";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }
    /***** Language *********/

    /***** DASBOARD *********/
    public function dashboard()
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }

        $data['actor'] = 'dashboard';
        $data['main_page_name'] = 'dashboard';
        $data["htmlPage"] = "dashboard";
        $data['page_title'] = 'dashboard';
        $data['page_sub_title'] = 'dashboard';
        $data['page_name'] = 'dashboard';
        $this->load->view(strtolower($this->session->userdata('directory')) . '/dashboard', $data);
    }
    /***** DASBOARD *********/
    
    /**** customer list *****/
    public function customer_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        if ($param1 == "get_ajax") {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            if ($columnName == "name") {
                $columnName = "first_name";
            }
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value

            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = " and (first_name like '%" . $searchValue . "%' or last_name like '%" . $searchValue . "%' or 
                    email like '%" . $searchValue . "%' or sp_points like '%" . $searchValue . "%' or 
                    mobile like'%" . $searchValue . "%' ) ";
            }
            $totalRecords = $this->db->count_all("users_system");
            $res = $this->db->query("select count(users_system_id) as c from brinkman_users_system where users_system_id != '-1' $searchQuery")->first_row();
            // echo $this->db->last_query();
            $totalRecordwithFilter = $res->c;
            $query = "select * from brinkman_users_system WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
            // echo $query;
            $users = $this->db->query($query)->result();
            $tabledata = [];
            foreach ($users as $user) {
                $data = [];
                $data["users_system_id"] = $user->users_system_id;
                $data["name"] = $user->first_name . " " . $user->last_name;
                $data["sp_points"] = $user->sp_points;
                $data["email"] = $user->email;
                $data["mobile"] = $user->mobile;
                $status = '<div class="toggle-btn1 ';
                if ($user->status == 'Active') {
                    $status .= 'active"';
                }
                $status .= ">";
                $status .= '<input type="checkbox"   class="cb-value" value="' . $user->users_system_id . '"';
                if ($user->status == 'Active') {
                    $status .= ' checked';
                }
                $status .= "/>";
                $status .= '<span class="round-btn"></span></div>';

                $data["status"] = $status;
                $action = "<a href='" . base_url() . "admin/edit_user/" . $user->users_system_id . "'>
                                            <i class='fa fa-pencil'></i>
                                        </a>";
                // $user['users_system_id']
                // $count;

                // $action .= "<a href='javascript:;' onclick=confirm_modal_action('". base_url().strtolower($this->session->userdata('directory')) . "/manage_users/delete/". $user->users_system_id ."')><i class='fa fa-trash-o'></i></a>";
                // $action .= "<a href='javascript:;' onclick=confirm_modal_action('". base_url().strtolower($this->session->userdata('directory')) . "/manage_users/delete/". $user->users_system_id ."')><i class='fa fa-trash-o'></i></a>";
                // $action .= "<a href='javascript:;' onclick=confirm_modal_action('". base_url().strtolower($this->session->userdata('directory')) . "/manage_users/delete/". $user->users_system_id ."')><i class='fa fa-trash-o'></i></a>";
                $d["user"] = ["users_system_id" => $user->users_system_id];
                $d["count"] = $user->users_system_id;
                $data["action"] = $this->load->view(strtolower($this->session->userdata('directory')) . '/manage_user_actions', $d, true);
                $tabledata[] = $data;
            }
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $tabledata
            );

            echo json_encode($response);
            exit();
        }
        if ($param1 == 'get_logs') {
            $id = $_REQUEST['id'];
            $this->db->order_by("points_log_id", "DESC");
            $res = $this->db->get_where("points_log", ["user_id" => $id]);
            $data = [];
            if ($res) {
                $data["result"] = $res->result();
                $data["status"] = 1;

            } else {
                //   $data["result"] = $res->result();
                $data["status"] = 1;
            }
            echo json_encode($data);

            exit;
        }
        if ($param1 == 'delete') {
            $this->db->where('users_system_id', $param2);
            $this->db->delete('users_system');
            $this->session->set_flashdata('msg_success', ' Data Deleted Successfully');
            redirect(base_url() . admin_ctrl() . '/customer_list', 'refresh');
        }
        if ($param1 == 'update_status') {
            $user_id = $this->input->post('user_id');
            $updateData['status'] = $this->input->post('status');
            $this->db->where('users_system_id', $user_id);
            $result = $this->db->update('brinkman_users_system', $updateData);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit;
        }
       
        // $this->db->limit($limit, $start);
        // $this->db->limit(300);  
        // $data['customer_list'] = $this->db->get_where('users_system')->result_array();
        $data['page_title'] = 'Manage Users';
        $data['page_sub_title'] = 'manage_users';
        $data['page_name'] = 'manage_users';
        $data['actor'] = 'manage_users';
        $data['main_page_name'] = 'manage_users';
        $data["htmlPage"] = "manage_users";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

    public function add_user($param1 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        if ($param1 == 'add') {
            if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_image.jpg';
                $path_to_file = 'uploads/users/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $saveData['user_image'] = $file_name;
            }
            $saveData['first_name'] = $this->input->post('name');
            $saveData['email'] = $this->input->post('email');
            $saveData['mobile'] = $this->input->post('mobile');
            $saveData['password'] = $this->input->post('password');
            $saveData['city'] = $this->input->post('city');
            $saveData['address'] = $this->input->post('address');
            $sp_points = $this->input->post('sp_points');
            if (!empty($sp_points)) {
                $saveData['sp_points'] = $sp_points;
            }
            $saveData['users_roles_id'] = $this->input->post('roles');
            $saveData['status'] = 'Active';
            $result = $this->db->insert('brinkman_users_system', $saveData);
            if (!empty($saveData['sp_points'])) {
                $id = $this->db->insert_id();
                $saveData2 = ["user_id" => $id, "type" => "Increment", "description" => "Added from admin panel", "points" => $saveData['sp_points'], "current_points" => $saveData['sp_points']];
                $result2 = $this->db->insert('brinkman_points_log', $saveData2);
            }
            if ($result) {
                $this->session->set_flashdata('msg_success', ' User Added Successfully');
            }
            redirect(base_url() . admin_ctrl() . '/customer_list', 'refresh');
        }

        $data['page_title'] = 'Add User';
        $data['page_sub_title'] = 'add_user';
        $data['page_name'] = 'add_user';
        $data['actor'] = 'add_user';
        $data['main_page_name'] = 'add_user';
        $data["htmlPage"] = "add_user";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

    public function edit_user($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        if ($param1 == 'edit') {
            if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_image.jpg';
                $path_to_file = 'uploads/users/' . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $path_to_file);
                $saveData['user_image'] = $file_name;
            }
            $muser = $this->db->get_where('brinkman_users_system', array('users_system_id' => $param2))->first_row();
            $saveData['first_name'] = $this->input->post('name');
            $saveData['email'] = $this->input->post('email');
            $saveData['mobile'] = $this->input->post('mobile');
//            $saveData['password'] = $this->input->post('password');
            $saveData['city'] = $this->input->post('city');
            $saveData['address'] = $this->input->post('address');
            $saveData['users_roles_id'] = $this->input->post('roles');
            $saveData['status'] = 'Active';
            $sp_type = $this->input->post("sp_points_type");
            $sp_points = $this->input->post('sp_points');
            if (!empty($sp_points)) {
                if ($sp_type == "increase") {
                    $saveData['sp_points'] = $sp_points + $muser->sp_points;
                } else if ($sp_type == "decrease") {
                    $saveData['sp_points'] = $muser->sp_points - $sp_points;
                }
            }

            $this->db->where('users_system_id', $param2);
            $result = $this->db->update('brinkman_users_system', $saveData);
            if (!empty($sp_points)) {
                $id = $param2;
                $type = $sp_type == "increase" ? "Increment" : "Decrement";
                $points = $sp_points;
                $saveData2 = ["user_id" => $id, "type" => $type, "description" => "Added from admin panel", "points" => $points, "current_points" => $saveData['sp_points']];
                $result2 = $this->db->insert('brinkman_points_log', $saveData2);

            }
            if ($result) {
                $this->session->set_flashdata('msg_success', ' User Added Successfully');
            }
            redirect(base_url() . admin_ctrl() . '/customer_list', 'refresh');
        }
        $data['page_data'] = $this->db->get_where('brinkman_users_system', array('users_system_id' => $param1))->row();
        $data['page_title'] = 'Edit User';
        $data['page_sub_title'] = 'edit_user';
        $data['page_name'] = 'edit_user';
        $data['actor'] = 'edit_user';
        $data['main_page_name'] = 'edit_user';
        $data["htmlPage"] = "edit_user";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }
    /***** customer list ****/
    
    /***** MY PROFILE *********/
    public function myprofile($param1 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        // exit;
        /*	if($this->session->userdata('login') != 1){
                redirect(base_url().strtolower($this->session->userdata('directory')), 'refresh');
            } */

        if ($param1 == 'update') {
            $response = $this->Db_model->update_admin_profile();

            $this->session->set_flashdata('msg_success', ' Updated Successfully');
            redirect(base_url() . admin_ctrl() . '/myprofile', 'refresh');
        }

        $data['profile_data'] = $this->db->get_where('brinkman_users_system', array('users_system_id' => $this->session->userdata('users_id')))->row();
        $data['actor'] = 'profile';
        $data['main_page_name'] = 'profile';
        $data['page_title'] = 'Update Your Profile';
        $data['page_sub_title'] = 'profile';
        $data['page_name'] = 'myprofile';
        $data["htmlPage"] = "myprofile";

        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }
    /***** MY PROFILE *********/

    /***** SYSTEM SETTINGS *********/
    public function system_settings($param1 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }

        if ($param1 == 'update') {
            $response = $this->Db_model->update_system_settings();
            $this->session->set_flashdata('msg_success', ' Updated Successfully');
            redirect(base_url() . admin_ctrl() . '/system_settings', 'refresh');
        }

        $data['system_data'] = $this->db->get('brinkman_system_settings')->result();
        $data['actor'] = 'system_settings';
        $data['main_page_name'] = 'system_settings';
        $data['page_title'] = 'Update Your System Settings';
        $data['page_sub_title'] = 'system_settings';
        $data['page_name'] = 'system_settings';
        $data["htmlPage"] = "system_settings";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

    /***** SYSTEM SETTINGS *********/


    public function resetpassword($verification_code = '')
    {
        $decoded_code = base64_decode($verification_code);
        $code_array = explode("_", $decoded_code);
        $user_id = $code_array[0];
        $data['user_id'] = $user_id;
        $this->load->view('admin/reset_password', $data);
    }

    public function reset_password($verification_code = '', $user_id = '')
    {
        if ($verification_code == 'update_password') {
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            if ($new_password != $confirm_password) {
                $this->session->set_flashdata('msg_error', ' Your password did not match, try again.');
                redirect(base_url() . 'admin', 'refresh');
            } else if ($new_password == $confirm_password) {
                $this->db->query("UPDATE brinkman_user_accounts SET password = '" . $new_password . "', reset_password_code = ''  WHERE user_accounts_id = '" . $user_id . "'  ");
                $this->session->set_flashdata('msg_success', ' Password Updated Successfully.');
                redirect(base_url() . 'admin', 'refresh');
            }
        }
    }

    /***** Retrieve Password Page *********/
    public function logout()
    {
        /*  $s_update['status']  = 'Inactive';
          $this->db->where('user_accounts_id',$this->session->userdata('users_id'));
          $this->db->update('user_login',$s_update);*/
        $this->session->unset_userdata('login');
        $this->session->sess_destroy();
        $this->session->set_flashdata('msg_error', 'logout Successfully!.');
        redirect(base_url() .admin_ctrl() , 'refresh');
    }

    /* VERIFY ACCOUNT */

   
    /**** manage roles *****/
    public function manage_roles($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }

        if ($param1 == 'edit') {
            $updateData['confirmation_number'] = $this->input->post('confirmation_number');
            $this->db->where('users_system_id', $param2);
            $result = $this->db->update('brinkman_users_system', $updateData);
            if ($result) {
                $this->session->set_flashdata('msg_success', 'Govt Number Assigned Successfully');
            } else {
                $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
            redirect(base_url() . strtolower($this->session->userdata('directory')) . '/customer_list', 'refresh');
        }

        if ($param1 == 'delete') {
            $result = $this->Db_model->delete_data('brinkman_user_roles', $param2);
            if ($result) {
                $this->session->set_flashdata('msg_success', 'Role Deleted Successfully');
            } else {
                $this->session->set_flashdata('msg_error', 'Oops!something went wrong');
            }
            redirect(base_url() . strtolower($this->session->userdata('directory')) . '/customer_list', 'refresh');
        }
        $data['user_roles'] = $this->db->get('brinkman_user_roles')->result_array();
        $data['page_title'] = get_phrase('manage_roles');
        $data['page_sub_title'] = get_phrase('manage_roles');
        $data['page_name'] = 'manage_roles';
        $data['actor'] = 'manage_roles';
        $data['main_page_name'] = 'manage_roles';
        $data["htmlPage"] = "manage_roles";
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

    // Manage SUGGESTED PRODUCT

    /**** manage roles *****/
    /**** manage permission ****/
    public function manage_permissions($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('login') != 1) {
            redirect(base_url() . 'admin', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data_per['account_setting'] = $this->check_value($this->input->post('account_setting'));
            $data_per['system_setting'] = $this->check_value($this->input->post('system_setting'));
            $data_per['dashboard'] = $this->check_value($this->input->post('dashboard'));
            $data_per['manage_pages'] = $this->check_value($this->input->post('manage_pages'));
            $data_per['manage_news'] = $this->check_value($this->input->post('manage_news'));
            $data_per['manage_campus_life'] = $this->check_value($this->input->post('manage_campus_life'));
            $data_per['manage_department'] = $this->check_value($this->input->post('manage_department'));
            $data_per['manage_news_letter'] = $this->check_value($this->input->post('manage_news_letter'));
            $data_per['manage_general_setting'] = $this->check_value($this->input->post('manage_general_setting'));
            $this->db->where('user_roles_id', $param2);
            $result = $this->db->update('brinkman_user_privileges', $data_per);

            if ($result == 'success') {
                $this->session->set_flashdata('msg_success', 'Permissions Updated Successfully');
            } else {
                $this->session->set_flashdata('msg_error', 'oops!Permissions not updated! try again.');
            }
            redirect(base_url() . 'admin/manage_roles/', 'refresh');
        }
        $data['param1'] = $param1;
        $data['roles'] = $this->db->get_where('brinkman_user_roles', array('user_roles_id' => $param1))->result_array();
        $data['page_title'] = get_phrase('brinkman_manage_permissions');
        $data['page_sub_title'] = '';
        $data['page_name'] = 'manage_permissions';
        $data['main_page_name'] = 'manage_permissions';
        
        $data['htmlPage'] = 'edit_roles';
        $this->load->view(strtolower($this->session->userdata('directory')) . '/index', $data);
    }

   

    function check_value($check_box_value)
    {
        if ($check_box_value == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /**** manage permission ****/
    public function replace_underscore($string)
    {
        $replaced = str_replace(' ', '_', $string);
        return $replaced;
    }

    public function check_null($param)
    {
        if ($param) {
            return $param;
        } else {
            return '0';
        }
    }

    public function getSortNumber($table)
    {
        $count = $this->db->get($table)->num_rows();
        $count = $count + 1;
        return $count;
    }

    public function redirect_me($path, $controller = "admin")
    {
        echo "<script>location.href = '" . base_url() . $controller . "/" . $path . "'; </script>";
//        redirect(strtolower($this->session->userdata('directory')) . '/' . $controller . "/".$path);
    }
    
}