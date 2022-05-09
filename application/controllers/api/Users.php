<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php'); 

class Users extends REST_Controller {

    /**
     * Construct : A method to load all the helper, language and model files
     * validation_helper
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('api/users_model','api_model',true);
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Kolkata'); 
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    /*-------------------------------------------------------------------
    *@function get User Profile 
    *-------------------------------------------------------------------*/
    public function getProfile()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid'] != ''&& $postData['type']!="")
        {
            $response = databasetable($postData);
            // print_r($response);die;
            $userData = $this->db->get_where($response['table'], array('id' => $postData['userid']))->num_rows();
            
            if($userData > 0){
                $success = $this->db->select('*')->get_where($response['table'], array('id' => $postData['userid']))->row(); 
                if ($postData['type'] == "distributor") {
                    $success->distributor_id=$success->id;
                } 
                if ($response['type']!="plumber") {
                	$success->brandName=brandNames($success->brand_id);
                }
                $attachment_image = $this->db->get_where(db_prefix().'files', array("rel_type" => $response['image'], "rel_id" => $postData['userid']))->row('file_name');
                $attachment_imagepath = site_url('uploads/'.$response['image'].'s/'. $postData['userid'].'/'. $attachment_image);
                if($attachment_image!='')
                {
                    $success->profile_image = $attachment_imagepath;

                }else{
                    $success->profile_image ='null';
                }
                $success->type = $postData['type'];
                $msg = array('status' =>true, 'message' => 'Data Found', 'result' => $success);
            }else{
                $msg = array('status' => false, 'message' => 'Records are not matching', 'result' =>array());
            }
        }
        else
        {
            $msg = array('status' => false, 'message' => 'User Id Required');
        }   
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function Update user  Profile 
    *-------------------------------------------------------------------*/
    public function updateProfile()
    {
        $postData = $_POST;
        // $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid'] != '' && $postData['type']!="")
        {
            $response = databasetable($postData);
            $where['id']=$postData['userid'];
            $userData = $this->db->get_where($response['table'], $where)->num_rows();
            if($userData > 0){
                $insertdata[$response['name']]=$postData['name'];
                $insertdata[$response['dob']]=date('Y-m-d',strtotime($postData['dob']));
                $insertdata[$response['gender']]=$postData['gender'];
                if ($response['type']=="plumber") {
                    $insertdata[$response['email']]=$postData['email'];
                    $insertdata[$response['pan']]=$postData['pan'];
                    $insertdata[$response['aadhar']]=$postData['aadhar'];
                    $insertdata['plumber_state']=$postData['state'];
                    $insertdata['plumber_city']=$postData['city'];
                    $insertdata['plumber_permanent_address']=$postData['address'];
                }
                $res = $this->api_model->updateData($response['table'],$where,$insertdata);
                $uploadedFiles = handle_file_upload($postData['userid'],$response['image'].'s', 'image');
                if ($uploadedFiles && is_array($uploadedFiles)) {
                    $wherefiles['rel_id'] = $where['id'];
                    $wherefiles['rel_type'] = $response['image'];
                     $count = $this->api_model->selectCount(db_prefix().'files',$wherefiles);
                    
                    foreach ($uploadedFiles as $file) {
                        if ($count>0) {
                            $this->api_model->updateData(db_prefix().'files',$wherefiles,$file);
                        }else{
                            // print_r($uploadedFiles);die;
                            $this->misc_model->add_attachment_to_database($where['id'], $response['image'], [$file]);
                        }
                    }
                } 
                $msg = array('status' =>true, 'message' => 'Profile Updated Successfully', 'result' => []);
            }else{
                $msg = array('status' => false, 'message' => 'Records are not matching', 'result' =>array());
            }
        }
        else
        {
            $msg = array('status' => false, 'message' => 'User Id Required');
        }   
        $this->response($msg, REST_Controller::HTTP_OK);
    }


    /*-------------------------------------------------------------------
    *@function for counts on dashboard
    *-------------------------------------------------------------------*/
    public function dashboardCount()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if ($postData['userid']!=""&& $postData['type']!="") {
            $response = databasetable($postData);
            $userData=$this->db->get_where($response['table'],['id'=>$postData['userid']]);
            if ($userData!="") {
                $pointscountadd =  $this->api_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>$response['type'],'status_type'=>'add'],'points');
                $pointscountless =  $this->api_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>$response['type'],'status_type'=>'less'],'points');
                // die;
                $data['totalpointsCount']=$pointscountadd-$pointscountless;
            	// $data['totalpointsCount']= $this->api_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>$response['type']],'points');
            	if ($response['type']=='plumber') {
            		$value = $this->db->get_where(db_prefix().'reward_value')->row('reward_value');
            		$data['totalproductsCount']= $data['totalpointsCount']*$value;
	                
	                $data['totalordersCount'] =$this->db->from(db_prefix().'user_reward')->where(['user_id'=>$postData['userid'],'type'=>$response['type']])->get()->num_rows();
            	}else{
	                $data['totalproductsCount']= $this->db->from(db_prefix().'orders_history')->where(['user_id'=>$postData['userid'],'type'=>$response['type']])->group_by('product_id')->get()->num_rows();
	                
	                $data['totalordersCount'] =$this->db->from(db_prefix().'orders')->where(['user_id'=>$postData['userid'],'user_type'=>$response['type']])->group_by('order_id')->get()->num_rows();
            	}
                $data['notificationCount'] = $this->db->from(db_prefix()."notifications")->where(['touserid'=>$postData['userid'],'type'=>$postData['type'],'user_read'=>0])->get()->num_rows();
                $msg = array('status' => true, 'message' => 'Dashboard Counts', 'result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'Records are not matching', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required');
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function for cms pages
    *-------------------------------------------------------------------*/
    public function cmsPage()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        // aboutus,contactus,privacypolicy,terms&condition
        if ($postData['page_name']!="") {
            $where['page_name']=$postData['page_name'];
            $response = $this->api_model->Select(db_prefix().'content',$where);
            $msg = array('status' => true, 'message' => 'Data found Successfully', 'result' =>$response);
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function for brand list
    *-------------------------------------------------------------------*/
    public function brandList()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['type'] !=""){
            $response = databasetable($postData);
            $userData = $this->db->get_where($response['table'], array('id' => $postData['userid']))->row('brand_id');
            if($userData!=""){
                $select="id,brandname";
                $response = $this->api_model->Select(db_prefix().'brand',['id'=>$userData],$select);
                if (!empty($response)) {
                    $msg = array('status' => true, 'message' => 'Data found Successfully', 'result' =>$response);
                }else{
                    $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
                }
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function for brand Productlist
    *-------------------------------------------------------------------*/
    public function brandProductList()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if ($postData['brand_id']!="") {
            $where['brand_id']=$postData['brand_id'];
            $where['isDeleted']=0;
            $select='id,title,color,measurement';
            $response = $this->api_model->Select(db_prefix().'products',$where,$select,'id','DESC');
            $data=[];
            foreach ($response as $key => $value) {
                $data[$key]=$value;
                $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['id']])->row('file_name');
                if ($image!="") {
                    $data[$key]['image']= base_url('uploads/product/').$value['id'].'/'.$image;
                }else{
                    $data[$key]['image']='';
                }
            }
            if (!empty($data)) {
                $msg = array('status' => true, 'message' => 'Data found Successfully', 'result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'Brand Id Required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function for Product details
    *-------------------------------------------------------------------*/
    public function ProductDetails()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if ($postData['product_id']!="") {
            $where['id']=$postData['product_id'];
            $select='*';
            $response = $this->api_model->Select(db_prefix().'products',$where,$select,'id','DESC');
            $data=[];
            foreach ($response as $key => $value) {
                $data[$key]= $value;
                if ($value['brand_id']!="") {
                    $data[$key]['brandName']= brandNames($value['brand_id']);
                }
                if ($value['category_id']!="") {
                    $data[$key]['categoryName']= categoryNames($value['category_id']);
                }
                if ($value['subcategory_id']!="") {
                    $data[$key]['subcategoryName']= subcategoryNames($value['subcategory_id']);
                }
                $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['id']])->row('file_name');
                if ($image!="") {
                    $data[$key]['image']= base_url('uploads/product/').$postData['product_id'].'/'.$image;
                }else{
                    $data[$key]['image']='';
                }
            }
            if (!empty($data)) {
                $msg = array('status' => true, 'message' => 'Data found Successfully', 'result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'Brand Id Required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }
    /*-------------------------------------------------------------------
    *@create order api
    *-------------------------------------------------------------------*/
    public function order()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['type'] !="" && $postData['product_id']!="" &&  $postData['quantity']!=""){
            $postData['order_id']= OrderID();
            $data =  PlaceOrder($postData);
            if($data == 1){
                $msg = array('status' => true, 'message' => 'Order Successfully Placed', 'result' =>array());
               
            }else{
                $msg = array('status' => false, 'message' => $data, 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    } 

    /*-------------------------------------------------------------------
    *@dealer order createdBy distributor api
    *-------------------------------------------------------------------*/
    public function dealer_orderby_distributor()
    {   
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['distributor_id']!="" && $postData['type'] !="" && $postData['product_id']!="" &&  $postData['quantity']!=""){
            $postData['order_id']= OrderID();
            $data =  PlaceOrderfordealer($postData);
            if($data == 1){
                $msg = array('status' => true, 'message' => 'Order Successfully Placed', 'result' =>array());
               
            }else{
                $msg = array('status' => false, 'message' => $data, 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }    
    /*-------------------------------------------------------------------
    *@this function is for  order list
    *-------------------------------------------------------------------*/
    public function order_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['type'] !=""){
            $where['user_id']=$postData['userid'];
            $where['user_type']=$postData['type'];
            if ($postData['filter']!="") {
                $fromdata= date('Y-m-d H:i:s');
                $todata= date('Y-m-d',strtotime('-7 days')).' 00:00:00';
                $response= $this->db->select("*")->from(db_prefix().'orders')->where($where)->where('created_date BETWEEN "'.$todata.'" AND "'.$fromdata.'"')->group_by('order_id')->order_by('id','DESC')->get()->result_array();
                // echo $this->db->last_query();
                // print_r($response);die;
                $data=[];
                foreach ($response as $key => $value) {
                    $data[$key]=$value;
                    $ordarr = $this->db->select('product_id,status')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
                    $statusarr=[];
                    $productarr=[];
                    foreach ($ordarr as $k => $v) {
                        $statusarr[]=$v['status'];
                        $productarr[]=productNames($v['product_id']);
                    }
                    $data[$key]['prductnames']=$productarr;
                    if (in_array(0, $statusarr)) {
                        $data[$key]['status'] =  0;
                    }elseif (in_array(1, $statusarr)) {
                        $data[$key]['status'] =  1;
                    }elseif (in_array(2, $statusarr)) {
                        $data[$key]['status'] =  2;
                    }elseif (in_array(3, $statusarr)) {
                        $data[$key]['status'] =  3;
                    }
                }
            }else{
                $response= $this->db->select("*")->from(db_prefix().'orders')->where($where)->group_by('order_id')->order_by('id','DESC')->get()->result_array();
                // print_r($response);die;
                $data=[];
                foreach ($response as $key => $value) {
                    $data[$key]=$value;
                    $ordarr = $this->db->select('product_id,status,quantity')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
                    $statusarr=[];
                    $productarr=[];
                    $qtysum=0;
                    foreach ($ordarr as $k => $v) {
                        $statusarr[]=$v['status'];
                        $productarr[]=productNames($v['product_id']);
                        $qtysum += $v['quantity'];
                    }
                    $data[$key]['prductnames']=$productarr;
                    $data[$key]['quantity']=$qtysum;
                    if (in_array(0, $statusarr)) {
                        $data[$key]['status'] =  0;
                    }elseif (in_array(1, $statusarr)) {
                        $data[$key]['status'] =  1;
                    }elseif (in_array(2, $statusarr)) {
                        $data[$key]['status'] =  2;
                    }elseif (in_array(3, $statusarr)) {
                        $data[$key]['status'] =  3;
                    }
                }
            }
            if($data){
                $msg = array('status' => true, 'message' => 'Order List', 'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    } 

    //this function is for  points/reward list
    public function point_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['type'] !=""){
            $where['user_id']=$postData['userid'];
            $where['type']=$postData['type'];
            $response = databasetable($postData);
            $res= $this->db->select("*")->from(db_prefix().'user_reward')->where($where)->order_by('id','DESC')->get()->result_array();
            $data=[];
            foreach ($res as $key => $value) {
                $data[$key]=$value;
                $data[$key]['productname'] = productNames($value['product_id']);
                $data[$key]['order_id'] = GetOrderID($value['order_id']);
                $data[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $data[$key]['brandname']=brandNames($this->db->get_where(db_prefix().'products',['id'=>$value['product_id']])->row('brand_id'));
            }
            if($res){
                $msg = array('status' => true, 'message' => 'Points List', 'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for  My Product list
    public function myStock_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['type'] !=""){
            $where['user_id']=$postData['userid'];
            $where['type']=$postData['type'];
            $response = databasetable($postData);
            $this->db->select('*');
            $this->db->select('SUM(quantity) as sumqty');
            $this->db->select('SUM(unit) as sumunit');
            $this->db->select('SUM(price) as sumprice');
            $res= $this->db->from(db_prefix().'orders_history')->where($where)->group_by('product_id')->order_by('id','DESC')->get()->result_array();
            $data=[];
            foreach ($res as $key => $value) {
                $data[$key]=$value;
                $data[$key]['productname'] = productNames($value['product_id']);
                $data[$key]['order_id'] = GetOrderID($value['order_id']);
                $data[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['product_id']])->row('file_name');
                if ($image!="") {
                    $data[$key]['image']= base_url('uploads/product/').$value['product_id'].'/'.$image;
                }else{
                    $data[$key]['image']='';
                }
            }
            //-----------------------------------updated code--------------------------------------------------------
            $res1= $this->db->select('*')->select('SUM(quantity) as quantity')->from(db_prefix().'user_stock')->where($where)->group_by('product_id')->order_by('id','DESC')->get()->result_array();
            // print_r($res1);die;
            $data1=[];
            foreach ($res1 as $key => $value) {
                $data1[$key]=$value;
                $data1[$key]['productname'] = productNames($value['product_id']);
                $data1[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $image1 = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['product_id']])->row('file_name');
                if ($image1!="") {
                    $data1[$key]['image']= base_url('uploads/product/').$value['product_id'].'/'.$image1;
                }else{
                    $data1[$key]['image']='';
                }
            }
            // print_r($data1);die;
            if($res){
                $msg = array('status' => true, 'message' => 'Data Found Successfully', 'result' =>$data,'newResult' =>$data1);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    // //this function is for  My Product details
    public function myStock_details()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['product_id'] !="" && $postData['type'] !=""){

            $where['user_id']=$postData['userid'];
            $where['type']=$postData['type'];
            $where['product_id']=$postData['product_id'];
            $response = databasetable($postData);
            $res= $this->db->select("*")->from(db_prefix().'orders_history')->where($where)->order_by('id','DESC')->get()->result_array();
            $data=[];
            $qtysum=0;
            $amountsum=0;
            foreach ($res as $key => $value) {
                $data[$key]=$value;
                $data[$key]['productname'] = productNames($value['product_id']);
                $data[$key]['order_id'] = GetOrderID($value['order_id']);
                $data[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['product_id']])->row('file_name');
                if ($image!="") {
                    $data[$key]['image']= base_url('uploads/product/').$value['product_id'].'/'.$image;
                }else{
                    $data[$key]['image']='';
                }
                $qtysum+=$value['quantity'];
                $amountsum+=$value['price'];
            }
            $count['qtysum']=$qtysum;
            $count['amountsum']=$amountsum;

            //------------------------------------------- updated code-------------------------------------------------------------
            $where1['tbldistributor_stock_history.user_id']=$postData['userid'];
            $where1['tblorders_history.type']=$postData['type'];
            $where1['tbldistributor_stock_history.product_id']=$postData['product_id'];
            $res1= $this->db->select("tbldistributor_stock_history.*,tblorders_history.unit")->from(db_prefix().'distributor_stock')->join(db_prefix().'orders_history',db_prefix().'orders_history.id = '.db_prefix().'distributor_stock.ord_history_id')->where($where1)->order_by('id','DESC')->get()->result_array();
            $data1=[];
            $qtysum1=0;
            $amountsum1=0;
            foreach ($res1 as $key => $value) {
                $data1[$key]=$value;
                $data1[$key]['productname'] = productNames($value['product_id']);
                $data1[$key]['order_id'] = GetOrderID($value['order_id']);
                $data1[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $image1 = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['product_id']])->row('file_name');
                if ($image1!="") {
                    $data1[$key]['image']= base_url('uploads/product/').$value['product_id'].'/'.$image1;
                }else{
                    $data1[$key]['image']='';
                }

                $qtysum+=$value['quantity'];
                $amountsum+=$value['quantity']*$value['unit'];
                $data1[$key]['price']=$value['quantity']*$value['unit'];
            }
            $count1['qtysum']=$qtysum1;
            $count1['amountsum']=$amountsum1;
            // print_r($data);die;
            if($res){
                $msg = array('status' => true, 'message' => 'Data Found Successfully','count'=>$count, 'result' => $data , 'newResult' =>$data1);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }   

    // //this function is for  My order details
    public function myOrder_details()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['order_id'] !="" && $postData['type']){
            // print_r($postData);die;
            $where['user_id']=$postData['userid'];
            $where['user_type']=$postData['type'];
            $where['order_id']=$postData['order_id'];
            $response = databasetable($postData);
            $res= $this->db->select("*")->from(db_prefix().'orders')->where($where)->get()->result_array();
            $data=[];
            foreach ($res as $key => $value) {
                $data[$key]=$value;
                $data[$key]['productname'] = productNames($value['product_id']);
                $data[$key]['username'] = $this->db->get_where($response['table'],['id'=>$value['user_id']])->row($response['name']);
                $where_history['user_id']=$postData['userid'];
                $where_history['order_id']=$value['id'];
                $where_history['product_id']=$value['product_id'];
                $data[$key]['assginqty']=$this->api_model->CountSums(db_prefix().'orders_history',$where_history,'quantity');
                $data[$key]['totalamount']=$this->api_model->CountSums(db_prefix().'orders_history',$where_history,'price');
                $productarr=$this->api_model->Select(db_prefix().'orders_history',$where_history);

                $data[$key]['products']=$productarr;
                $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'product','rel_id'=>$value['product_id']])->row('file_name');
                if ($image!="") {
                    $data[$key]['image']= base_url('uploads/product/').$value['product_id'].'/'.$image;
                }else{
                    $data[$key]['image']='';
                }
            }
                // print_r($data);
                // die;
            if($res){
                $msg = array('status' => true, 'message' => 'Data Found Successfully', 'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    } 

    //this function is for State List
    public function state_list()
    {
        // $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        // if($postData['userid']!="" && $postData['product_id'] !="" && $postData['type'] !=""){

            $data= $this->api_model->Select(db_prefix().'state',['is_deleted'=>0],'id,name');
            if($data){
                $msg = array('status' => true, 'message' => 'Data Found Successfully', 'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        // }else{
        //     $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        // }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for State List
    public function city_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['state_id']!=""){

            $data= $this->api_model->Select(db_prefix().'city',['state_id'=>$postData['state_id'],'is_deleted'=>0],'id,name');
            if($data){
                $msg = array('status' => true, 'message' => 'Data Found Successfully', 'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }
    // user validation
    public function userValidation()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['type']!="" && $postData['pan_no']!="" || $postData['aadhar_no']!="" || $postData['gst_no']!="" || $postData['email']!="" || $postData['mobile_no']!=""){
            $response = databasetable($postData);
            if ($postData['type']=='dealer'|| $postData['type']=="distributor") {
                if ($postData['pan_no']!="") {
                   $where['dealer_pan_number']=$postData['pan_no'];
                   $where1['distributor_pan_number']=$postData['pan_no'];
                   $where2['plumber_pan_number']=$postData['pan_no'];
                   $where3=[];
                }elseif ($postData['aadhar_no']!="") {
                    $where['dealer_aadhar_number']=$postData['aadhar_no'];
                    $where1['distributor_aadhar_number']=$postData['aadhar_no'];
                    $where2['plumber_aadhar_number']=$postData['aadhar_no'];
                    $where3=[];
                }elseif ($postData['gst_no']!="") {
                    $where['dealer_GST']=$postData['gst_no'];
                    $where1['distributor_GST']=$postData['gst_no'];
                    $where2=[];
                    $where3=[];
                }elseif ($postData['email']!="") {
                    $where['dealer_email']=$postData['email'];
                    $where1['distributor_email']=$postData['email'];
                    $where2['plumber_email']=$postData['email'];
                    $where3['email']=$postData['email'];
                }elseif ($postData['mobile_no']!="") {
                    $where['dealer_mobile']=$postData['mobile_no'];
                    $where1['distributor_mobile']=$postData['mobile_no'];
                    $where2['plumber_mobile']=$postData['mobile_no'];
                    $where3['phonenumber'] = $postData['mobile'];
                }
                $data= $this->api_model->selectCount(db_prefix().'dealer',$where);
                $data1= $this->api_model->selectCount(db_prefix().'distributors',$where1);
                if (!empty($where2)) {
                    $data2= $this->api_model->selectCount(db_prefix().'plumber',$where2);
                }else{
                    $data2=0;
                }
                if (!empty($where3)) {
                    $data3= $this->api_model->selectCount(db_prefix().'staff',$where3);
                }else{
                    $data3=0;
                }
            }else{
                $data=1;
            }
            if($data == 0 && $data1 == 0 && $data2 == 0 && $data3 == 0){
                $msg = array('status' => true, 'message' => 'Data Available', 'result' =>'True');
               
            }else{
                $msg = array('status' => false, 'message' => 'Data Already Exits', 'result' =>'False');
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    // create dealer
    public function addDealer()
    {
        $postData = $_POST;
        // $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['distributor_id']!="" && $postData['brand_id']!="" && $postData['pan_no']!="" && $postData['aadhar_no']!="" && $postData['gst_no']!="" && $postData['address']!="" && $postData['state']!="" && $postData['city']!="" && $postData['name']!=""&& $postData['email']!=""&& $postData['dob']!=""&& $postData['doj']!=""&& $postData['mobile']!=""&& $postData['gender']!=""){

            $validation = validation($postData);

            if ($validation['validation']==0) {
                $insertdata['distributor_id']=$postData['distributor_id'];
                $insertdata['brand_id']=$postData['brand_id'];
                $insertdata['dealer_business_name']=$postData['business_name'];
                $insertdata['dealer_pan_number']=$postData['pan_no'];
                $insertdata['dealer_aadhar_number']=$postData['aadhar_no'];
                $insertdata['dealer_GST']=$postData['gst_no'];
                $insertdata['dealer_permanent_address']=$postData['address'];
                $insertdata['dealer_state']=$postData['state'];
                $insertdata['dealer_city']=$postData['city'];
                $insertdata['dealer_name']=$postData['name'];
                $insertdata['dealer_email']=$postData['email'];
                $insertdata['dealer_dob']=date('Y-m-d',strtotime($postData['dob']));
                $insertdata['dealer_doj']=$postData['doj'];
                $insertdata['dealer_mobile']=$postData['mobile'];
                $insertdata['dealer_gender']=$postData['gender'];
                $data= $this->api_model->Insert(db_prefix()."dealer",$insertdata);
                if($data){
                    $id=$this->db->insert_id();
                    $insert['user_id']=$id;
                    $insert['type']='dealer';
                    $insert['mobile']=$postData['mobile'];
                    $this->Common_model->add_article(db_prefix().'user_master',$insert);

                    $uploadedFiles = handle_file_upload($id,'dealers', 'image');
                        if ($uploadedFiles && is_array($uploadedFiles)) {
                            foreach ($uploadedFiles as $file) {
                                $this->misc_model->add_attachment_to_database($id, 'dealer', [$file]);
                            }
                        } 
                    $msg = array('status' => true, 'message' => 'Dealer Added Successfully', 'result' =>[]);
                   
                }else{
                    $msg = array('status' => false, 'message' => 'Some Error Found', 'result' =>[]);
                }

            }else{
                $msg = array('status' => false, 'message' => $validation['message'], 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for Dealer List
    public function dealer_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['distributor_id']!=""){

            $data= $this->api_model->Select(db_prefix().'dealer',['distributor_id'=>$postData['distributor_id']],'id,dealer_name as name,dealer_mobile,dealer_email,status');
            $res=[];
            foreach ($data as $key => $value) {
                $res[$key]=$value;
                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $value['id'], 'rel_type' => 'dealer'))->row('file_name');
                if ($filename!="") {
                    $res[$key]['image'] = site_url('uploads/dealers/'.$value['id'].'/'. $filename);
                }else{
                    $res[$key]['image'] = '';
                }
            }
            if($res){
                $msg = array('status' => true, 'message' => 'Data Found Successfully', 'result' =>$res);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for delete Dealer
    public function deactiveDealer()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['dealer_id']!="" && $postData['status']==0 || $postData['status']==1){
            $res = $this->Common_model->get(db_prefix().'dealer',['id'=>$postData['dealer_id']]);
            $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->dealer_mobile]);
            // $response = $this->Common_model->get(db_prefix().'user_master',['status'=>1,'mobile'=>$res->dealer_mobile,'user_id!='=>$id,'type!='=>'dealer']);
            if ($postData['status'] == 1 && count($response) == 0 ) {

                $data= $this->api_model->updateData(db_prefix().'dealer',['id'=>$postData['dealer_id']],['status'=>$postData['status']]);

                $this->db->where(['user_id'=>$postData['dealer_id'],'type'=>'dealer']);
                $this->db->update(db_prefix().'user_master', ['status'=>$postData['status']]);
            }elseif ($postData['status'] == 0) {
                $data= $this->api_model->updateData(db_prefix().'dealer',['id'=>$postData['dealer_id']],['status'=>$postData['status']]);

                $this->db->where(['user_id'=>$postData['dealer_id'],'type'=>'dealer']);
                $this->db->update(db_prefix().'user_master', ['status'=>$postData['status']]);
            }
            if($data){
                $msg = array('status' => true, 'message' => ($postData['status']==1)?'Dealer Activated Successfully':'Dealer Deactivated Successfully', 'result' =>true);
            }else{
                $msg = array('status' => false, 'message' => 'Dealer Not Successfully Updated', 'result' =>array());
            }
            //--------------------------old
            // $data= $this->api_model->updateData(db_prefix().'dealer',['id'=>$postData['dealer_id']],['status'=>$postData['status']]);
            // if($data){
            //     $msg = array('status' => true, 'message' => ($postData['status']==1)?'Dealer Activated Successfully':'Dealer Deactivated Successfully', 'result' =>true);
            // }else{
            //     $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            // }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for details of Dealer
    public function dealerDetail()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid']!="" && $postData['dealer_id']!=""){
            // $data= $this->api_model->Select(db_prefix().'dealer',['id'=>$postData['dealer_id'],'distributor_id'=>$postData['userid']]);
            $Joinon=db_prefix().'distributors.id = '.db_prefix().'dealer.distributor_id';
            $select="tbldealer.*,tbldistributors.*,tbldealer.id as dealer_id";
            $data= $this->api_model->SelectJoin(db_prefix().'dealer' ,db_prefix().'distributors' ,$Joinon, ['tbldealer.id'=>$postData['dealer_id'],'distributor_id'=>$postData['userid']],$select);
            if($data){
                foreach ($data as $key => $value) {
                    $image = $this->db->get_where(db_prefix().'files',['rel_type'=>'dealer','rel_id'=>$value['dealer_id']])->row('file_name');
                    if (!empty($image)) {
                        $data[$key]['image']=base_url('uploads/dealers/').$value['dealer_id'].'/'.$image;
                    }else{
                        $data[$key]['image']=base_url('uploads/company/').'/'.'logo.png';
                    }
                }
                $msg = array('status' => true, 'message' => 'Dealer Data Found', 'result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for details of Dealer
    public function dealerupdate()
    {
        // $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        $postData = $_POST;
        if($postData['distributor_id']!="" && $postData['dealer_id']!=""){

            // $validation = validation($postData);

            // if ($validation['validation']==0) {
                $insertdata['brand_id']=$postData['brand_id'];
                $insertdata['dealer_business_name']=$postData['business_name'];
                // $insertdata['dealer_pan_number']=$postData['pan_no'];
                // $insertdata['dealer_aadhar_number']=$postData['aadhar_no'];
                // $insertdata['dealer_GST']=$postData['gst_no'];
                $insertdata['dealer_permanent_address']=$postData['address'];
                $insertdata['dealer_state']=$postData['state'];
                $insertdata['dealer_city']=$postData['city'];
                $insertdata['dealer_name']=$postData['name'];
                // $insertdata['dealer_email']=$postData['email'];
                $insertdata['dealer_dob']=$postData['dob'];
                $insertdata['dealer_doj']=$postData['doj'];
                // $insertdata['dealer_mobile']=$postData['mobile'];
                $insertdata['dealer_gender']=$postData['gender'];
                $data= $this->api_model->updateData(db_prefix()."dealer",['id'=>$postData['dealer_id'],'distributor_id'=>$postData['distributor_id']],$insertdata);
                if($data){
                    $id=$postData['dealer_id'];
                    $uploadedFiles = handle_file_upload($id,'dealers', 'image');
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'dealer', [$file]);
                        }
                    } 
                    $msg = array('status' => true, 'message' => 'Dealer Updated Successfully', 'result' =>[]);
                   
                }else{
                    $msg = array('status' => false, 'message' => 'Some Error Found', 'result' =>[]);
                }

            // }else{
            //     $msg = array('status' => false, 'message' => $validation['message'], 'result' =>array());
            // }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for Dealer order List
    public function dealer_orderRecived_old()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['distributor_id']!=""){
            $count['totalorder'] = $this->db->from(db_prefix().'orders')->where(['to_user'=>$postData['distributor_id']])->group_by('order_id')->get()->num_rows();
            $response = $this->db->from(db_prefix().'orders')->where(['to_user'=>$postData['distributor_id']])->group_by('order_id')->get()->result_array();
            $pending=0;
            $complete=0;
            $cancelled=0;
            $accept=0;
            foreach ($response as $key => $value) {
                $ordarr = $this->db->select('status')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
                $statusarr=[];
                foreach ($ordarr as $key => $value) {
                    $statusarr[]=$value['status'];
                }
                if (in_array(0, $statusarr)) {
                    $pending++;
                }elseif (in_array(1, $statusarr)) {
                    $accept++;
                }elseif (in_array(2, $statusarr)) {
                    $cancelled++;
                }elseif (in_array(3, $statusarr)) {
                    $complete++;
                }
            }
            
            $count['pendingorder']=$pending;
            $count['acceptorder']=$accept;
            $count['deliveredorder']=$complete;
            $count['cancelledorder']=$cancelled;
            $response= $this->db->from(db_prefix().'orders')->where(['to_user'=>$postData['distributor_id']])->group_by('order_id')->order_by('id','DESC')->get()->result_array();
            foreach ($response as $key => $value) {
                    $data[$key]=$value;
                    $ordarr = $this->db->select('product_id,status,quantity')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
                    $statusarr=[];
                    $productarr=[];
                    $qtysum=0;
                    foreach ($ordarr as $k => $v) {
                        $statusarr[]=$v['status'];
                        $productarr[]=productNames($v['product_id']);
                        $qtysum += $v['quantity'];
                    }
                    $data[$key]['prductnames']=$productarr;
                    $data[$key]['quantity']=$qtysum;
                    if (in_array(0, $statusarr)) {
                        $data[$key]['status'] =  0;
                    }elseif (in_array(1, $statusarr)) {
                        $data[$key]['status'] =  1;
                    }elseif (in_array(2, $statusarr)) {
                        $data[$key]['status'] =  2;
                    }elseif (in_array(3, $statusarr)) {
                        $data[$key]['status'] =  3;
                    }
                }
            if($data){
                $msg = array('status' => true, 'message' => 'Data Found Successfully','count'=>$count,'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    public function dealer_orderRecived()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['distributor_id']!=""){
            $count['totalorder'] = $this->db->from(db_prefix().'orders')->where(['to_user'=>$postData['distributor_id']])->group_by('order_id')->get()->num_rows();
            $response= $this->db->from(db_prefix().'orders')->where(['to_user'=>$postData['distributor_id']])->group_by('order_id')->order_by('id','DESC')->get()->result_array();
            $pending=0;
            $complete=0;
            $cancelled=0;
            $accept=0;
            foreach ($response as $key => $value) {
                    $data[$key]=$value;
                    $data[$key]['name']=dealerNames($value['user_id']);
                    $ordarr = $this->db->select('product_id,status,quantity')->from(db_prefix().'orders')->where(['order_id'=>$value['order_id']])->get()->result_array();
                    $statusarr=[];
                    $productarr=[];
                    $qtysum=0;
                    foreach ($ordarr as $k => $v) {
                        $statusarr[]=$v['status'];
                        $productarr[]=productNames($v['product_id']);
                        $qtysum += $v['quantity'];
                    }
                    $data[$key]['prductnames']=$productarr;
                    $data[$key]['quantity']=$qtysum;
                    if (in_array(0, $statusarr)) {
                        $data[$key]['status'] =  0;
                        $pending++;
                    }elseif (in_array(1, $statusarr)) {
                        $data[$key]['status'] =  1;
                        $accept++;
                    }elseif (in_array(2, $statusarr)) {
                        $data[$key]['status'] =  2;
                        $cancelled++;
                    }elseif (in_array(3, $statusarr)) {
                        $data[$key]['status'] =  3;
                        $complete++;
                    }
                }
                $count['pendingorder']=$pending;
                $count['acceptorder']=$accept;
                $count['deliveredorder']=$complete;
                $count['cancelledorder']=$cancelled;
            if($data){
                $msg = array('status' => true, 'message' => 'Data Found Successfully','count'=>$count,'result' =>$data);
               
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
            
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for change order status
    public function change_orderStatus()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['order_id']!=""&& $postData['status']!=""){
            $response = change_orderStatus($postData['order_id'],$postData['status']);
            if($response){
                $msg = array('status' => true, 'message' => 'Status Change Successfully','result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is Edit dealer order
    public function edit_dealerOrder()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['order_id']!=""){
            $select='tbldealer.id,tbldealer.dealer_email,tbldealer.dealer_name,tbldealer.dealer_mobile';
            $res = $this->db->select($select)->from(db_prefix().'orders')->join(db_prefix().'dealer',db_prefix().'dealer.id = '.db_prefix().'orders.user_id')->where(['tblorders.order_id'=>$postData['order_id']])->get()->row_array();
            $img= $this->db->get_where(db_prefix().'files',['rel_id'=>$res['id'],'rel_type'=>'dealer'])->row('file_name');
            $image= base_url('uploads/dealers/').$res['id'].'/'.$img;
            $res['image']=isset($img)&&!empty($img)?$image:'';
            $response = editOrder($postData['order_id']);
            if($response){
                $data['userdetails']=$res;
                $data['orderdetails']=$response;
                $msg = array('status' => true, 'message' => 'Data Found','result' =>$response,'newresult'=>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is Update dealers order
    public function update_dealerOrder_old()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['distributor_id'] !="" && $postData['user_id'] !="" && $postData['id']!="" && $postData['product_id']!="" && $postData['bach_no']!="" && $postData['quantity']!="" && $postData['unit']!="" && $postData['price']!=""){
            // $response = update_dealerOrder($postData);
            $insertdata['from_user']=$postData['distributor_id'];
            $insertdata['user_id']=$postData['user_id'];
            $insertdata['type']='dealer';

            $order_id =explode(',', $postData['id']);
            $product_id=explode(',', $postData['product_id']);
            $bach_no =explode(',', $postData['bach_no']);
            $quantity =explode(',', $postData['quantity']);
            $unit =explode(',', $postData['unit']);
            $price=explode(',', $postData['price']);
            if (count($order_id) == count($product_id) && count($order_id) == count($bach_no)&& count($order_id) == count($quantity) && count($order_id) == count($unit) && count($order_id) == count($price)) {
                for ($i=0; $i <count($order_id) ; $i++) { 
                    $insertdata['order_id']=$order_id[$i];
                    $insertdata['product_id']=$product_id[$i];
                    $insertdata['bach_no']=$bach_no[$i];
                    $insertdata['quantity']=$quantity[$i];
                    $insertdata['unit']=$unit[$i];
                    $insertdata['price']=$price[$i];
                    // print_r($insertdata);//die;
                    unset($insertdata['ord_history_id']);
                    $orders_history_res = $this->db->insert(db_prefix().'orders_history',$insertdata);
                    if ($orders_history_res) {
                        $history_id = $this->db->insert_id();
                        $insertdata_new=$insertdata;
                        $insertdata_new['ord_history_id'] = $history_id;
                        $insertdata_new['transaction_status'] = 'add';
                        unset($insertdata_new['unit']);
                        unset($insertdata_new['price']);
                        unset($insertdata_new['type']);
                        unset($insertdata_new['from_user']);
                        $this->db->insert(db_prefix().'dealer_stock_history',$insertdata_new);
                        $where['user_id'] = $insertdata['user_id'];
                        $where['bach_no'] = $insertdata['bach_no'];
                        $where['product_id'] = $insertdata['product_id'];
                        $where['type']= "dealer";
                        $stock = $this->db->get_where(db_prefix().'user_stock',$where)->row('quantity');
                        if ($stock != "") {
                            $update['quantity']=$stock+$insertdata['quantity'];
                            $this->db->where($where)->update(db_prefix().'user_stock',$update);
                        }else{
                            unset($insertdata_new['ord_history_id']);
                            unset($insertdata_new['order_id']);
                            unset($insertdata_new['transaction_status']);
                            $insertdata_new['type']='dealer';
                            $this->db->insert(db_prefix().'user_stock',$insertdata_new);
                        }
                        dealerReward($history_id);
                        $updatedOrder =$this->db->select('order_id')->from(db_prefix().'orders_history')->where(['order_id'=>$order_id[$i]])->get()->result_array();
                        if (!empty($updatedOrder)) {
                            $status = ChangeDealerStatus($order_id[$i]);
                        }
                        $msg = array('status' => true, 'message' => 'Order Assgin Successfully', 'result' =>array());
                    }else{
                        $msg = array('status' => false, 'message' => 'Order Not Updated Try again', 'result' =>array());
                    }
                    // tbluser_stock
                    // tblorders_history
                    // tbluser_reward
                    //tbldealer_stock_history
                }
            }else{
                $msg = array('status' => false, 'message' => 'Data Not Recived properly', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }
    public function update_dealerOrder()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        
        // this code is for Check requested post is not empty
        if($postData['distributor_id'] !="" && $postData['user_id'] !="" && $postData['id']!="" && $postData['product_id']!="" && $postData['bach_no']!="" && $postData['quantity']!="" && $postData['unit']!="" && $postData['price']!=""){
            // $response = update_dealerOrder($postData);
            $insertdata['from_user']=$postData['distributor_id'];
            $insertdata['user_id']=$postData['user_id'];
            $insertdata['type']='dealer';

            $order_id =explode(',', $postData['id']);
            $product_id=explode(',', $postData['product_id']);
            $bach_no =explode(',', $postData['bach_no']);
            $quantity =explode(',', $postData['quantity']);
            $unit =explode(',', $postData['unit']);
            $price=explode(',', $postData['price']);
            // this code is for Check requested post is correct or not
            if (count($order_id) == count($product_id) && count($order_id) == count($bach_no)&& count($order_id) == count($quantity) && count($order_id) == count($unit) && count($order_id) == count($price)) {
                $error=0;
                for ($i=0; $i <count($order_id) ; $i++) { 
                    $insertdata['order_id']=$order_id[$i];
                    $insertdata['product_id']=$product_id[$i];
                    $insertdata['bach_no']=$bach_no[$i];
                    $insertdata['quantity']=$quantity[$i];
                    $insertdata['unit']=$unit[$i];
                    $insertdata['price']=$price[$i];
                    // print_r($insertdata);//die;
                    unset($insertdata['ord_history_id']);
                    
                    // this code is for insert order history
                    $orders_history_res = $this->db->insert(db_prefix().'orders_history',$insertdata);
                    if ($orders_history_res) {
                        $history_id = $this->db->insert_id();
                        $insertdata_new=$insertdata;
                        $insertdata_new['ord_history_id'] = $history_id;
                        $insertdata_new['transaction_status'] = 'add';
                        unset($insertdata_new['unit']);
                        unset($insertdata_new['price']);
                        unset($insertdata_new['type']);
                        unset($insertdata_new['from_user']);
                        // this code is for insert dealer stock history
                        $this->db->insert(db_prefix().'dealer_stock_history',$insertdata_new);
                        $where['user_id'] = $insertdata['user_id'];
                        $where['bach_no'] = $insertdata['bach_no'];
                        $where['product_id'] = $insertdata['product_id'];
                        $where['type']= "dealer";
                        // this code is for check dealer stock
                        $stock = $this->db->get_where(db_prefix().'user_stock',$where)->row('quantity');
                        if ($stock != "") {
                            $update['quantity']=$stock+$insertdata['quantity'];
                            // this code is for update dealer stock
                            $this->db->where($where)->update(db_prefix().'user_stock',$update);
                        }else{
                            unset($insertdata_new['ord_history_id']);
                            unset($insertdata_new['order_id']);
                            unset($insertdata_new['transaction_status']);
                            $insertdata_new['type']='dealer';
                            // this code is for Insert dealer stock
                            $this->db->insert(db_prefix().'user_stock',$insertdata_new);
                        }
                        dealerReward($history_id);
                        
                        $status = ChangeDealerStatus($order_id[$i]);
                        // $updatedOrder =$this->db->select('order_id')->from(db_prefix().'orders_history')->where(['order_id'=>$order_id[$i]])->get()->result_array();
                        // if (!empty($updatedOrder)) {
                        //     $status = ChangeDealerStatus($order_id[$i]);
                        // }
                        
                    }else{
                        $error++;
                    }
                    // tbluser_stock
                    // tblorders_history
                    // tbluser_reward
                    //tbldealer_stock_history
                }
                if ($error == 0) {
                    $msg = array('status' => true, 'message' => 'Order Assgin Successfully', 'result' =>array());
                }else{
                    $msg = array('status' => false, 'message' => 'Order Not Updated Try again', 'result' =>array());
                }
            }else{
                $msg = array('status' => false, 'message' => 'Data Not Recived properly', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is calculate user reward value
    public function calculate_reward()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['type']!="" && $postData['userid']!=""){
            $where['type']=$postData['type'];
            $where['user_id']=$postData['userid'];
            $pointssum = $this->db->select_sum('points')->from(db_prefix().'user_reward')->where($where)->get()->row('points');
            $value = $this->db->get_where(db_prefix().'reward_value',['user_type'=>$postData['type']])->row('reward_value');
            $rewardvalue['value']=$pointssum*$value;
            // print_r($rewardvalue);die;
            if($rewardvalue!=""){
                $msg = array('status' => true, 'message' => 'Data Found','result' =>$rewardvalue);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is Scan barcode
    public function scanBarcode()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['type']!="" && $postData['userid']!="" && $postData['barcode_value']!=""){
            $response = $this->db->get_where(db_prefix()."barcode",['barcode_value'=>$postData['barcode_value'],'status'=>1])->row_array();
            if ($response) {
                $wherereward['user_type']=$postData['type'];
                $wherereward['product_id']=$response['product_id'];
                $rewardpercent = $this->db->get_where(db_prefix()."reward",$wherereward)->row('percent');
                if ($rewardpercent!="") {
                	$res =$this->db->where(['barcode_value'=>$postData['barcode_value'],'status'=>1])->update(db_prefix()."barcode",['status'=>0,'userid'=>$postData['userid'],'type'=>$postData['type']]);
                    if($res){
                        $where['type']=$postData['type'];
                        $where['user_id']=$postData['userid'];
                        $insertdata['user_id']=$postData['userid'];
	                    $insertdata['product_id']=$response['product_id'];
	                    $insertdata['bach_no']=$response['bach_no'];
	                    $insertdata['type']=$postData['type'];
	                    $insertdata['points']=$rewardpercent;
	                    $insertdata['barcode_id']=$response['id'];
	                    $this->db->insert(db_prefix()."user_reward",$insertdata);
                        $msg = array('status' => true, 'message' => 'Scanned Successfully done','result' =>[]);
                    }else{
                        $msg = array('status' => false, 'message' => 'some error found', 'result' =>array());
                    }
                }else{
                    $msg = array('status' => false, 'message' => 'No reward found', 'result' =>array());
                }
            }else{
                $msg = array('status' => false, 'message' => 'Barcode Already Scanned', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    public function scanBarcode_old()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['type']!="" && $postData['userid']!="" && $postData['barcode_value']!=""){
            $response = $this->db->get_where(db_prefix()."barcode",['barcode_value'=>$postData['barcode_value'],'status'=>1])->row_array();
            if ($response) {
                $wherereward['user_type']=$postData['type'];
                $wherereward['product_id']=$response['product_id'];
                $rewardpercent = $this->db->get_where(db_prefix()."reward",$wherereward)->row('percent');
                if ($rewardpercent!="") {
                    $insertdata['user_id']=$postData['userid'];
                    $insertdata['product_id']=$response['product_id'];
                    $insertdata['bach_no']=$response['bach_no'];
                    $insertdata['type']=$postData['type'];
                    $insertdata['points']=$rewardpercent;
                    $res = $this->db->insert(db_prefix()."user_reward",$insertdata);
                    if($res){
                        $where['type']=$postData['type'];
                        $where['user_id']=$postData['userid'];
                        $this->db->where(['barcode_value'=>$postData['barcode_value'],'status'=>1])->update(db_prefix()."barcode",['status'=>0,'userid'=>$postData['userid']]);
                        $msg = array('status' => true, 'message' => 'Scanned Successfully done','result' =>[]);
                    }else{
                        $msg = array('status' => false, 'message' => 'some error found', 'result' =>array());
                    }
                }else{
                    $msg = array('status' => false, 'message' => 'No reward found', 'result' =>array());
                }
            }else{
                $msg = array('status' => false, 'message' => 'Barcode Already Scanned', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is advertisement
    public function advertisement()
    {
        // $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        $start_date =strtotime(date('Y-m-d'));
        $res = $this->db->select(db_prefix().'advertisement.*,'.db_prefix().'files.file_name as image')
        ->from(db_prefix().'advertisement')
        ->join(db_prefix().'files',db_prefix().'files.rel_id = '.db_prefix().'advertisement.id')
        ->where(db_prefix().'advertisement.start_date <=',$start_date)
        ->where(db_prefix().'advertisement.end_date >=',$start_date)
        ->where(db_prefix().'files.rel_type','advertisement')
        ->where(db_prefix().'advertisement.status',1)
        ->get()->result();
        
        if($res){
            foreach($res as $value){
            	$url=base_url('/uploads/advertisement').'/'.$value->id.'/'.$value->image;
            	$value->image=$url;
            }
            $msg = array('status' => true, 'message' => 'advertisement List','result' =>$res);
        }else{
            $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>array());
        }
                
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is plumber barcode scan list
    public function plumber_scanRecent()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        // print_r($postData);die;
        if($postData['type']!="" && $postData['userid']!=""){
        	$fromdata= date('Y-m-d H:i:s');

            $todata= date('Y-m-d',strtotime('-7 days')).' 00:00:00';

            $response= $this->db->select("*")->from(db_prefix()."user_reward")->where(['user_id'=>$postData['userid'],'type'=>$postData['type']])->where('created_at BETWEEN "'.$todata.'" AND "'.$fromdata.'"')->order_by('id','DESC')->get()->result_array();
            $data=[];
            foreach ($response as $key => $value) {
                $data[$key]=$value;
                $data[$key]['productname'] = productNames($value['product_id']);
                // $data[$key]['order_id'] = GetOrderID($value['order_id']);
                $data[$key]['username'] = $this->db->get_where(db_prefix().'plumber',['id'=>$value['user_id']])->row('plumber_name');
                $data[$key]['brandname']=brandNames($this->db->get_where(db_prefix().'products',['id'=>$value['product_id']])->row('brand_id'));
            }
            if ($data) {
                $msg = array('status' => true, 'message' => 'Data Found','result' =>$data);
            }else{
                $msg = array('status' => false, 'message' => 'No Datafound', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is notification list
    public function notification_list()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        // print_r($postData);die;
        if($postData['type']!="" && $postData['user_id']!=""){

            $response= $this->db->select("*")->from(db_prefix()."notifications")->where(['touserid'=>$postData['user_id'],'type'=>$postData['type']])->order_by('id','DESC')->get()->result_array();
            if ($response) {
                $msg = array('status' => true, 'message' => 'Data Found','result' =>$response);
            }else{
                $msg = array('status' => false, 'message' => 'No Datafound', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for read notification
    public function readnotification()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        // print_r($postData);die;
        if($postData['user_id']!=""&& $postData['type']!=""){

            $response= $this->db->where(['touserid'=>$postData['user_id'],'type'=>$postData['type']])->update(db_prefix()."notifications",['user_read'=>1]);
            if ($response) {
                $msg = array('status' => true, 'message' => 'Data Readed','result' =>array());
            }else{
                $msg = array('status' => false, 'message' => 'Data Not Readed', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for claim rewards points
    public function claimReward()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if(!empty($postData['userid']) && !empty($postData['type']) && !empty($postData['claim_type']) && !empty($postData['points'])){
            $pointscountadd =  $this->api_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>$postData['type'],'status_type'=>'add'],'points');
            $pointscountless =  $this->api_model->CountSums(db_prefix().'user_reward',['user_id'=>$postData['userid'],'type'=>$postData['type'],'status_type'=>'less'],'points');
            // die;
            $pointscount=$pointscountadd-$pointscountless;
            if ($pointscount >= $postData['points'] ) {
                $user_reward['user_id']=$postData['userid'];
                $user_reward['type']=$postData['type'];
                $user_reward['points']=$postData['points'];
                $user_reward['message']=$postData['claim_type'];
                $user_reward['status_type']='less';
                $this->api_model->Insert(db_prefix().'user_reward',$user_reward);
                $id = $this->db->insert_id();
                if (!empty($id)) {
                    // print_r($postData);die;
                    $insertdata['type']=$postData['type'];
                    $insertdata['user_id']=$postData['userid'];
                    $insertdata['claim_type']=$postData['claim_type'];
                    $insertdata['points']=$postData['points'];
                    $insertdata['user_reward_id']=$id;
                    $response= $this->api_model->Insert(db_prefix().'claim_reward',$insertdata);
                    if ($response) {
                        $msg = array('status' => true, 'message' => 'Request Submitted Successfully','result' =>array());
                    }else{
                        $msg = array('status' => false, 'message' => 'Request Not Submitted', 'result' =>array());
                    }
                }else{

                    $msg = array('status' => false, 'message' => 'Some Error Found Please Try Again later.', 'result' =>array());
                }
            }else{
                $msg = array('status' => false, 'message' => 'Redeem Points Request Is Greater than Available points ', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    //this function is for claim rewards list
    public function claimRewardlist()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if(!empty($postData['userid']) && !empty($postData['type'])){
            $response =  $this->api_model->Select(db_prefix().'claim_reward',['user_id'=>$postData['userid'],'type'=>$postData['type']],'*','id','DESC');
            if ($response) {
                $msg = array('status' => true, 'message' => 'Data Found Successfully','result' =>$response);
            }else{
                $msg = array('status' => false, 'message' => 'Data Not Found', 'result' =>array());
            }
        }else{
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }
}
