<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Product extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model','product');
		$this->load->model('User_model','user');
		$this->load->model('Base_model','base');
		
		
	}
	function product_get()
	{
		$this->response('My first API response from: api/product/get_category_get() ');
	}

	public function index_get(){

		$data['msg'] = "My first API response call from:  product/index_get()";
		$data['status'] = "success";
		//$data['len']  = count($this->product->get_products());
		$id = $this->get('id');
		$limit = $this->get('limit');
		$offset = $this->get('offset');
		//var_dump($id);die;
		$data['data'] = $this->product->get_products($id,$limit,$offset);
		$data['len']  = count($data['data']);
		
		// require_once("PHPDebug.php");
		// $debug = new PHPDebug();
		// $debug->debug("A very simple message");
		// $this->load->view('welcome_message');

		$this->response($data);
	}

	public function add_product_post()
	{
		//$param['name'] = $this->input->post('name'); // using CI post method
		//$param['category'] = $this->post('category');  // using REST_Controller/post method
		//$param['price'] = $this->post('price');
		$param = $this->post();  // get array data for all post method


		$result = $this->product->insert_product($param);
		//var_dump($result);

		if(isset($result['status'])){ // success
			$data['msg'] = "My first API response call from:  product/add_product_post()";
			$data['status'] = "success";
			//$data['result'] = $this->product->get_products();  // get all products
			$data['data'] = $this->product->get_product($result['id']);  // get the inserted product
			$this->response($data);
		}else{
			$data['msg'] = "My first API response call from:  product/index_get()";
			$data['status'] = "fail";
			$data['data'] = [];
			$this->response($data);

		}	

	}

	public function delete_product_post()
	{
		$result['msg'] = 'API call from prodcut/delete_product_delete';
		$id = $this->post('id');  // using REST_Controller/post method
		//var_dump($id);die;
			
		$isExist = $this->base->isProductExist($id); // check if that product exist using Base_controller
		if($isExist){
			$status = $this->product->delete_product_by_id($id);
			$result['success'] = $status;			
			$result['info'] = "product is successfully deleted";			
		}else{
			$result['success'] = false;
			$result['info'] = "the product is not exist";			

		}

		$this->response($result);	
	}

	public function update_product_post(){
		$result['msg'] = 'API call from prodcut/update_product_delete';
		$param = $this->post();

		if(isset($param['id'])){
			$isExist = $this->base->isProductExist($param['id']);

			if(!$isExist){
				$result['info'] = "the product is not exist";
				$result['status'] = "fail";
				$result['data'] = [];
			}else{
				$result['info'] = "the product is updated successfully";
				$result['status'] = 'success';
				$result['data']   = $this->product->update_product_by_id($param);
			}

		}else{
			$result['info'] = "oop! please pass product id";
			$result['status'] = "fail";
			$result['data'] = [];
		}

		$this->response($result);

	}

}
