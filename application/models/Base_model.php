<?php

/*
 * @Copy Right Borama Consulting
 *
 * @Author: Tola 
 *
 * @Since: 23/12/2015
 *
 * @Editor: Tola ,07/01/2016
 *
 */

class Base_model extends CI_Model {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('mongo_db');

    } 
    
    public function isProductExist($id) {
        $data = $this->mongo_db->where(array('_id'=> new MongoId($id)))->get('product');

        if(!empty($data)){ // exist
            return true;
        }else{
            return false;
        }
    }

    public function filterParamTemplate($paramClient, $myParamTemplate){

        
    
        for($i=0 ; $i< count($myParamTemplate); $i++){
            if(array_key_exists($myParamTemplate[$i], $paramClient)){
                $result[$myParamTemplate[$i]] = $paramClient[$myParamTemplate[$i]];
            }else{
                return PARAM_NOT_MATCH; // 
            }
        }

        return $result;

    }

 }