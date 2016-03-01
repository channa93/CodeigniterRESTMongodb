<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class User extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model','product');
		$this->load->model('Base_model','base');
		$this->load->model('User_model','user');
	}

	public function get_users_get(){
		$data['msg'] = "My first API response call from:  user/get_users_get()";
		$data['status'] = "success";

		$user = $this->user->get_users();
		$data['user'] = $user;
		$this->response($data);
	}

	public function add_user_post(){
		$data['msg'] = "My first API response call from:  user/add_user_post()";
		//$data['status'] = "success";
		$param = $this->post();
		//$param['picture'] = $_FILES['picture']['tmp_name'];
		$param['picture'] = UPLOAD_PATH_IMAGE.$_FILES['picture']['name'];
		$data['user'] = $this->user->add_user($param);

		if($data['user']['status'] == "success"){
			$data['message'] = $data['user']['message'];
			$data['status'] = $data['user']['status'];
			unset($data['user']['status']);
			unset($data['user']['message']);
			
		}


		$this->response($data);
	}

	
}