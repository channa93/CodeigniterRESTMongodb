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

class User_model extends CI_Model {


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('product');
    } 


    public function get_users(){
        return $this->mongo_db->get(TABLE_USER);
    }

    public function add_user($param){
        $myParam = array(
            'name','email','tel'
        );

        $filterParam = $this->base->filterParamTemplate($param, $myParam);

        if($filterParam === PARAM_NOT_MATCH){
            $newUser['status'] = "fail";
            $newUser['message'] = "not enough params";
        }else{
             $filterParam['created'] = date('Y-M-d H:m:s A');
             if(isset($param['picture'])){
                $filterParam['picture'] = base_url().$param['picture'];
             }

             $newUserId = $this->mongo_db->
                         insert(TABLE_USER, $filterParam);
            $newUser['status'] = "success";
            $newUser['message'] = "add new user successfully";
            $newUser['user'] = $this->mongo_db->
                        where(array('_id'=>new MongoId($newUserId)))->
                        get(TABLE_USER);
            $this->_upload_image($_FILES['picture']);
        }

        return $newUser;
    }

    private function _upload_image($image){
        $destination = UPLOAD_PATH_IMAGE;
        $name = $image['name'];
        $tmp_name = $image['tmp_name'];

        move_uploaded_file($tmp_name, $destination.$name);

    }
    


}