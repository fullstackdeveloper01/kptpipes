<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php'); 

class General extends REST_Controller {

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
    *@function complain Raise 
    *-------------------------------------------------------------------*/
    public function complainRaise()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid'] != ''&& $postData['type']!="" && $postData['message']!=""){

            $userData = $this->api_model->Insert(db_prefix().'complain', $postData);
            if($userData){
                $msg = array('status' =>true, 'message' => 'Complain Raise Successfully', 'result' => []);
            }else{
                $msg = array('status' => false, 'message' => 'Records are not matching', 'result' =>[]);
            }
        }else{
            $msg = array('status' => false, 'message' => 'All Feilds Required');
        }   
        $this->response($msg, REST_Controller::HTTP_OK);
    }

    /*-------------------------------------------------------------------
    *@function complain Raise list
    *-------------------------------------------------------------------*/
    public function complainList()
    {
        $postData = array_merge($_POST,json_decode(file_get_contents('php://input'),true));
        if($postData['userid'] != ''&& $postData['type']!=""){

            $userData = $this->api_model->Select(db_prefix().'complain', $postData);
            if($userData){
                $msg = array('status' =>true, 'message' => 'Complain List', 'result' => $userData);
            }else{
                $msg = array('status' => false, 'message' => 'No Data Found', 'result' =>[]);
            }
        }else{
            $msg = array('status' => false, 'message' => 'All Feilds Required');
        }   
        $this->response($msg, REST_Controller::HTTP_OK);
    }

}
