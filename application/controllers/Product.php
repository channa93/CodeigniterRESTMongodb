<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Product extends REST_Controller {

	function __construct()
	{
		parent::__construct();
	}
	function category_get()
	{
		$this->response('My first API response from:  category/get_category_get()');
	}
	public function index_get()
	{
		$this->response('My first API response from: category/index_get() ');

	}



}
