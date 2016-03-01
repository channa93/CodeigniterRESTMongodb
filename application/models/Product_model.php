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

class Product_model extends CI_Model {


    public function __construct()
    {
        parent::__construct();
    } 
    
    public function get_products($id='', $limit='', $offset='')
    {  
        $limit = empty($limit)?0:$limit;
        $offset = empty($offset)?0:$offset;

        if(empty($id) ){
            $result = $this->mongo_db->
                    order_by(array('LOWER(name)' => 'ASC'))->
                    //aggregate_sort(array('name' => 'ASC'))->
                    limit($limit)->
                    offset($offset)->
                    get('product');  // --->(tableName)
            $idOwner = $result[0]['ownerId'];


            $user = $this->mongo_db->
                    where(array("_id" => new MongoId($idOwner)))->
                    get('user');
            //var_dump($idOwner,$user);die;
            $result['owner'] = $user;
            return $result;
        }else{ // find by id
            $result = $this->mongo_db->
                    where(array("_id" => new MongoId($id)))->
                    order_by(array('name' => 'ASC'))->
                    //aggregate_sort(array('name' => 'ASC'))->
                    get('product');  
            return $result;
        }
      
    } 


    public function insert_product($data)
    {
        $id = $this->mongo_db->insert('product', $data);

        if($id){
            $result['status'] = true; // success
            $result['id'] = $id; // success
            return $result;
        }else{
            $result['status'] = false;  // fail
            return $result;       
        }

    }

    public function delete_product_by_id($id)
    {

        // 
        // $id = new MongoId($idParam);  
        // $isExist = $this->mongo_db->where(array('_id'=>$id))->get('product');
        
        // if(!empty($isExist) ){
        //     $status = $this->mongo_db->where(array('_id'=> $id))->delete('product');
        // }else{
        //     $status = false;
        // }
        // // var_dump($status);die;
        // return $status;
        
        
        $isExist = $this->base->isProductExist($id); //call Base_model for check is exist
        
        if($isExist){
            $status = $this->mongo_db->where(array('_id'=> new MongoId($id)))->delete('product');
        }else{
            $status = false;
        }
        // var_dump($status);die;
        return $status;
    }


   
    public function delete_product_by_name($name)
    {

         $status = $this->mongo_db->where(array('name'=> $name))->delete('product'); // delete a product by a specific name
        //$status = $this->mongo_db->where(array('name'=> null))->delete_all('product');   // delete all products that its names are null
        // var_dump($status);die;
         return $status;
    }

    /**
     * [update_product_by_id description]
     * @param  [string] $id [description]
     * @return [type]     [description]
     */
    public function update_product_by_id($data){
        //$status = $this->mongo_db->where(array('_id'=>new MongoId($data['id'])))->update('product',$data);
        $status = $this->mongo_db->update_all('product',$data);
        $data = $this->mongo_db->get('product');
       // $data = $this->mongo_db->where(array('_id'=>new MongoId($data['id'])))->get('product');
        return $data;
    }


    



     

 }