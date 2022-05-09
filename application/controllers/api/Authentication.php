<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php'); 

class Authentication extends REST_Controller {

    /**
     * Construct : A method to load all the helper, language and model files
     * validation_helper
     */
    public function __construct() {
        parent::__construct();
		$this->load->model('api/users_model','api_model',true);
		$this->load->library('session');
		// $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	 	date_default_timezone_set('Asia/Kolkata'); 
    }

    /*-------------------------------------------------------------------
    *@function User Login
    *-------------------------------------------------------------------*/
    public function login_old()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['mobile'] != '' && $postData['type']!="")
        // if($postData['mobile'] != '' && $postData['password'] !=""&&$postData['type']!="")
        {
            $mobile = $postData['mobile'];
            // distributor, dealer, plumber
            if ($postData['type']=='dealer') {
                $table=db_prefix().'dealer';
                $where['dealer_mobile']=$mobile;
                // $columns='dealer_password';
                $userdata = $this->db->get_where($table, $where)->row_array();
            }elseif ($postData['type']=='plumber') {
                $table=db_prefix().'plumber';
                $where['plumber_mobile']=$mobile;
                // $columns='plumber_password';
                $response = $this->db->get_where($table, $where)->row_array();
                if (!empty($response)) {
                    $userdata=$response;
                }else{
                    $where1['dealer_mobile']=$mobile;
                    $data= $this->api_model->selectCount(db_prefix().'dealer',$where1);
                    $where2['distributor_mobile']=$mobile;
                    $data1= $this->api_model->selectCount(db_prefix().'distributors',$where2);
                    if ($data==0 && $data1==0){
                        $this->db->insert($table,$where);
                        $userdata = $this->db->get_where($table, $where)->row_array();
                    }else{
                        $userdata = '';
                        $message='This Number already in use';
                    }
                }
            }else{
                $table=db_prefix().'distributors';
                $where['distributor_mobile']=$mobile;
                // $columns='distributor_password';
                $userdata = $this->db->get_where($table, $where)->row_array();
            }
            // print_r($userdata);die;
            if($userdata!="" && $userdata['status']==1)
            {
                $otp = rand(1000,9999);
                $dataadd['otp'] = $otp;
                $res = $this->api_model->updateData($table,$where,$dataadd);
                // echo $res;die;
                $userdata['otp']=$otp;
                $userdata['type']=$postData['type'];
                if ($res) {
                    $this->db->where('id', $userdata['id']);
                    $this->db->update($table, [
                        'last_ip' =>  $postData['ip_address'],
                        'last_login' =>  YMD_date(),
                        'token' => $postData['token'],
                    ]);
                    $msg = array('status' => true, 'message' =>'Otp Send To your registered number', 'result' => $userdata);
                }else{
                    $msg = array('status' => false, 'message' =>'Some error Found', 'result' => []);
                }
                // if(password_verifyed($postData['password'],$userdata[$columns])){
                //     if($userdata['status'] > 0)
                //     {
                //         $msg = array('status' => true, 'message' =>'user login successfully', 'result' =>$userdata);
                //     }
                //     else
                //     {
                //         $msg = array('status' => false, 'message' =>'Your Account is not Active', 'result' => array());
                //     }                    
                // }else{
                //     $msg = array('status' => false, 'message' =>'Password mismatch', 'result' => []);

                // }
            }else{
                // print_r($userdata);die;
                if (isset($userdata)&&!empty($userdata)) {
                    $newMessage='Your account is deactivated';
                }else{
                    $newMessage='Records are not matching';
                }
                $msg = array('status' => false, 'message' =>isset($message)&&$message!=""?$message:$newMessage, 'result' => array());
            }
        }
        else
        {
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }


    public function login()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['mobile'] != '')
        {
            $mobile = $postData['mobile'];
            // distributor, dealer, plumber
            $table1=db_prefix().'dealer';
            $where1['dealer_mobile']=$mobile;
            $userdata1 = $this->db->get_where($table1, $where1)->row_array();

            $table2=db_prefix().'distributors';
            $where2['distributor_mobile']=$mobile;
            $userdata2 = $this->db->get_where($table2, $where2)->row_array();

            $table3=db_prefix().'plumber';
            $where3['plumber_mobile']=$mobile;
            $response = $this->db->get_where($table3, $where3)->row_array();
            if (!empty($response)) {
                $userdata3=$response;
            }else{
                if (count($userdata1)==0 && count($userdata2)==0){
                    $insertdata['plumber_mobile']= $mobile;
                    $insertdata['plumber_doj']= date('Y-m-d');
                    $this->db->insert($table3,$insertdata);

                    $insert['user_id']=$this->db->insert_id();
                    $insert['type']='plumber';
                    $insert['mobile']=$mobile;
                    $this->Common_model->add_article(db_prefix().'user_master',$insert);
                    $userdata3 = $this->db->get_where($table3, $where3)->row_array();
                    $postData['type']='plumber';
                    $msg = UpdateUser($table3,$where3,$userdata3,$postData);
                }
            }
            if (!empty($userdata1) && $userdata1['status']==1) {
                $postData['type']='dealer';
                $msg = UpdateUser($table1,$where1,$userdata1,$postData);
            }elseif (!empty($userdata2) && $userdata2['status']==1) {
                $postData['type']='distributor';
                $msg = UpdateUser($table2,$where2,$userdata2,$postData);
            }elseif (!empty($userdata3) && $userdata3['status']==1) {
                $postData['type']='plumber';
                $msg = UpdateUser($table3,$where3,$userdata3,$postData);
            }else{
                $msg = array('status' => false, 'message' =>'Your account is deactivated', 'result' => array());
            }
            $smsdata['moblie_no'] = $postData['mobile'];
            $smsdata['message'] = "Hi,%20%20".$msg['result']['otp']."%20%20is%20the%20OTP%20(One%20Time%20Password)%20to%20open%20your%20application.%20For%20security%20reasons,%20do%20not%20share%20your%20OTP%20with%20anyone.%20Regards,%20KPT%20PIPES";
            send_sms($smsdata);
            
        }
        else
        {
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function User Token Update
    *-------------------------------------------------------------------*/
    public function tokenUpdate()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid'] != '' && $postData['type']!="" && $postData['token']!="")
        {
            $response = databasetable($postData);
            $res = $this->api_model->updateData($response['table'],['id'=>$postData['userid']],['token'=>$postData['token']]);
            if ($res) {
                $msg = array('status' => true, 'message' =>'token updated', 'result' => []);
            }else{
                $msg = array('status' => false, 'message' =>'Some error Found', 'result' => []);
            }
        }
        else
        {
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }
    /*-------------------------------------------------------------------
    *@function User forgotPassword
    *-------------------------------------------------------------------*/
    // public function forgotPassword()
    // {
    //     $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    //     if($postData['mobile']!='' && $postData['type']!="")
    //     {   
    //         $response = databasetable($postData);
    //         $where[$response['mobile']]  =  $postData['mobile'];
    //         $mobile = $this->db->get_where($response['table'], $where)->row($response['mobile']);
    //         if($mobile!=""){
    //             $otp = rand(1000,9999);
    //             $response = $this->api_model->updateData($response['table'],$where,['otp'=>$otp,'otp_verification'=>'']);
                
    //             if($response){
    //                 $data['moblie_no'] = $mobile;
    //                 $data['message']   = 'KptPipes : Your verification code is '.$otp;
    //                 send_sms1($data, false);
    //                 $smsdata['moblie_no'] = $postData['mobile'];
    //                 $smsdata['message'] = $otp;
    //                 send_sms($smsdata);

    //                 $msg = array('status' => true, 'message' => 'Otp Send To your registered number ', 'result' =>$data);
    //             }else{
    //                 $msg = array('status' => false, 'message' => 'Some error found Try after Some time', 'result' =>array());
    //             }
    //         }else{
    //             $msg = array('status' => false, 'message' => 'mobile Number Not Exits', 'result' =>array());
    //         }
    //     }
    //     else
    //     {
    //         $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
    //     }
    //     $this->response($msg, REST_Controller::HTTP_OK);
    // }
    /*-------------------------------------------------------------------
    *@function:  MAtch otp
    *-------------------------------------------------------------------*/
    public function matchOTP()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['mobile'] != "" && $postData['otp'] != "" && $postData['type']!="" && $postData['token']!="" )
        {
            $response = databasetable($postData);
            $where[$response['mobile']] = $postData['mobile'];
            $where['otp'] = $postData['otp'];
            $userid = $this->db->get_where($response['table'], $where)->row('id');
            //print_r($response);
            // die;
            if($userid)
            {
                $updatedata = array('otp' => null,'otp_verification'=>date('Y-m-d H:i:s'),'token'=>$postData['token']);
                $updateresponse = $this->db->where($where);
                $updateresponse = $updateresponse->update($response['table'], $updatedata);
                if($updateresponse)
                {
                    $msg = array('status' => true, 'message' =>'Otp Matched');
                }
                else
                {
                    $msg = array('status' => false, 'message' =>'Your Account is not verified', 'result' => array());
                }                    
            }
            else
            {
                $msg = array('status' => false, 'message' =>'Records are not matching', 'result' => array());
            }
            
        }
        else
        {
            $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
        }
        $this->response($msg, REST_Controller::HTTP_OK);
    }
    /*-------------------------------------------------------------------
    *@function User update Password
    *-------------------------------------------------------------------*/
    // public function resetPassword()
    // {
    //     $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    //     // print_r($postData);die;
    //     if($postData['mobile']!='' && $postData['password'] && $postData['type']!="")
    //     {   
    //         $response = databasetable($postData);
    //         $where[$response['mobile']]  =  $postData['mobile'];
    //         $mobile = $this->db->get_where($response['table'], $where)->row($response['mobile']);
    //         if($mobile!=""){
    //             $Updatedata[$response['columns_pass']] = $postData['password'];
    //             $Updatedata[$response['columns']] = md5($postData['password']);
    //             $response = $this->api_model->updateData($response['table'],$where,$Updatedata);
    //             if($response){
    //                 $msg = array('status' => true, 'message' => 'Password changed Succesfully', 'result' =>array());
    //             }else{
    //                 $msg = array('status' => false, 'message' => 'Some error found Try after Some time', 'result' =>array());
    //             }
    //         }else{
    //             $msg = array('status' => false, 'message' => 'mobile Number Not Exits', 'result' =>array());
    //         }
    //     }
    //     else
    //     {
    //         $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
    //     }
    //     $this->response($msg, REST_Controller::HTTP_OK);
    // }

    /*-------------------------------------------------------------------
    *@function User change Password
    *-------------------------------------------------------------------*/
    // public function changePassword()
    // {
    //     $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));

    //     if($postData['mobile']!='' && $postData['type']!='' && $postData['password'] && $postData['oldPassword'])
    //     {   
    //         $response = databasetable($postData);
    //         $where[$response['mobile']]  =  $postData['mobile'];
    //         $user = $this->db->get_where($response['table'], $where)->row_array();
    //         if($user!=""){
    //             if(password_verifyed($postData['oldPassword'],$user[$response['columns']])){
    //                 $Updatedata[$response['columns_pass']] = $postData['password'];
    //                 $Updatedata[$response['columns']] = md5($postData['password']);
    //                 $response = $this->api_model->updateData($response['table'],$where,$Updatedata);
    //                 if($response){
    //                     $msg = array('status' => false, 'message' => 'Password changed Succesfully', 'result' =>array());
    //                 }else{
    //                     $msg = array('status' => false, 'message' => 'Some error found Try after Some time', 'result' =>array());
    //                 }
    //             }else{
    //                 $msg = array('status' => false, 'message' => 'Old Password Not Match', 'result' =>array());
    //             }
                
    //         }else{
    //             $msg = array('status' => false, 'message' => 'mobile Number Not Exits', 'result' =>array());
    //         }
    //     }
    //     else
    //     {
    //         $msg = array('status' => false, 'message' => 'All fields are required', 'result' =>array());
    //     }
    //     $this->response($msg, REST_Controller::HTTP_OK);
    // }

    

}
