<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* Technology name */
function technologyname($techid)
{
    $CI = &get_instance();
    
    $newValuess = [];
    $newvalue = explode(",",$techid);
    $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from(db_prefix().'technology');
        $CI->db->where_in('id', $newvalue); 
        $query = $CI->db->get();
        $name = $query->result_array();

    if($name == '')
    {
        $name1 = '-';
    }
    else
    {
        foreach ($name as  $value) 
        {
            $newValuess[] = $value['technology'];
        }
         $name1 = implode(", ",$newValuess);
    }    
    return $name1;
}

/* Brand name */
function brandnamelist($techid)
{
    $CI = &get_instance();
    
    $newValuess = [];
    $newvalue = explode(",",$techid);
    $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from(db_prefix().'brand');
        $CI->db->where_in('id', $newvalue); 
        $query = $CI->db->get();
        $name = $query->result_array();

    if($name == '')
    {
        $name1 = '-';
    }
    else
    {
        foreach ($name as  $value) 
        {
            $newValuess[] = $value['brandname'];
        }
         $name1 = implode(", ",$newValuess);
    }    
    return $name1;
}

    /* Category name */
function categoryname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'category', array('id' => $catid))->row('name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

    /* Brand name */
function brandname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'brand', array('id' => $catid))->row('brandname');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* AGE */
function todayAGE($catid)
{
    $dob = date('Y-m-d', strtotime($catid));
    $bday = new DateTime($dob); // Your date of birth
    $today = new Datetime(date('Y-m-d'));
    $diff = $today->diff($bday);
    
    return $diff->y;
}

/* Phrases name */
function phrasesname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'essential_phrases', array('id' => $catid))->row('name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* Country name */
function countryname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'country', array('id' => $catid))->row('name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* State name */
function statename($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'state', array('id' => $catid))->row('name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* City name */
function cityname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'city', array('id' => $catid))->row('name');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* Area name */
function areaname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'area_new', array('id' => $catid))->row('areaname');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* Product name */
function productname($catid)
{
    $CI = &get_instance();
    $catname = $CI->db->get_where(db_prefix().'product', array('id' => $catid))->row('title');
    if($catname == '')
    {
        $catname = '-';
    }
    return $catname;
}

/* Product name */
function order_status($statusId)
{
    $CI = &get_instance();
    if($statusId == 0)
    {
        $catname = 'Pending';
    }if($statusId == 1)
    {
        $catname = 'Picked';
    }if($statusId == 2)
    {
        $catname = 'Process';
    }if($statusId == 3)
    {
        $catname = 'Packed';
    }if($statusId == 4)
    {
        $catname = 'Shipped';
    }if($statusId == 5)
    {
        $catname = 'Delivered';
    }if($statusId == 6)
    {
        $catname = 'Cancelled';
    }
    return $catname;
}
/* Product name */
function payment_status($statusId)
{
    $CI = &get_instance();
    if($statusId == 0)
    {
        $catname = 'Unpaid';
    }if($statusId == 1)
    {
        $catname = 'Paid';
    }if($statusId == 2)
    {
        $catname = 'COD';
    }
    return $catname;
}

/* Product price */
function productprice($catid)
{
    $CI = &get_instance();
    $price = $CI->db->get_where(db_prefix().'product', array('id' => $catid))->row('price');
    if($price == '')
    {
        $price = 0;
    }
    return $price;
}

/* Product price */
function isPrimeDelivery($isPrimeDelivery,$price)
{
    $CI = &get_instance();
    $prime_delivery_info = $CI->db->get_where(db_prefix().'content', array('page_name' => 'Prime_delivery'))->row();
    if($isPrimeDelivery == 0)
    {
        $final_price = $price;
    }
    else
    {
    	$prime_price = floatval($prime_delivery_info->description);
    	$new_price = $prime_price + $price;
    	 $final_price = $new_price;
    }
    return $final_price;
}


/* Send Sms */
    function send_sms($data,$schedule='no')
    {
        $apiKey    =   "bf61253f-a547-48a5-95d8-fb518f749f1b";        
        $clientid    =   "925e8af2-5645-42db-8b6b-1dda4f07e8f9";        
        $senderId   =   isset($senderId) ? $senderId : "KPTPIP";         

        //Multiple mobiles numbers separated by comma
        $mobileNumber = $data['moblie_no'];
        //Your message to send, Add URL encoding here.
        $message = $data['message'];
        //API URL
        $url='http://smsl.myappstores.com/vendorsms/pushsms.aspx?apiKey=bf61253f-a547-48a5-95d8-fb518f749f1b&clientid=925e8af2-5645-42db-8b6b-1dda4f07e8f9&msisdn='.$mobileNumber.'&sid=KPTPIP&msg='.$message.'&fl=0&gwid=2';
        // init the resource
        $curl = curl_init();

        curl_setopt_array($curl, array(
          // CURLOPT_URL => 'http://smsl.myappstores.com/vendorsms/pushsms.aspx?apiKey=bf61253f-a547-48a5-95d8-fb518f749f1b&clientid=925e8af2-5645-42db-8b6b-1dda4f07e8f9&msisdn='.$mobileNumber.'&sid=KPTPIP&msg=Hi,%20%20'.$message.'%20%20is%20the%20OTP%20(One%20Time%20Password)%20to%20open%20your%20application.%20For%20security%20reasons,%20do%20not%20share%20your%20OTP%20with%20anyone.%20Regards,%20KPT%20PIPES&fl=0&gwid=2',
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Cookie: ASP.NET_SessionId=35b4nrg2egt2kfc5amlnmt1j'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return true;   
    }
 	function send_sms_old($data,$schedule='no')
	{
		$authKey = "132272ATNr8vCu1583bd153";
	
		$tran_sms 			=	messageTransactional($authKey);
		$trans_check		=	json_decode($tran_sms);
		if($trans_check->msgType=="error")
		{
			$due_balance 		=	"0";
			
		}else{
			$due_balance 		=	str_replace("\n", "", ($tran_sms!='') ? $tran_sms : "0");
		}
		if($due_balance!=0){
			
			$authKey	=	($authKey!='') ? $authKey : "132272ATNr8vCu1583bd153"; 		
			$senderId	=	($senderId!='') ? $senderId : "BJINII"; 		
		
			//Multiple mobiles numbers separated by comma
		 	$mobileNumber = $data['moblie_no'];
	 
			//Your message to send, Add URL encoding here.
			$message = urlencode($data['message']);
			//Define route 
			$route = "4";
			
			$postData['authkey'] = $authKey;
			$postData['mobiles'] = $mobileNumber;
			$postData['message'] = $message;
			$postData['sender'] = $senderId;
			$postData['route'] = $route;
			$postData['unicode'] = 1;
			if($schedule=='yes'){
				$postData['schtime'] = $data['schtime'];
				
			}
			

			//API URL
			$url="https://control.msg91.com/api/sendhttp.php";

			// init the resource
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postData
				//,CURLOPT_FOLLOWLOCATION => true
			));
	 
			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	 
			//get response
			$output = curl_exec($ch);

			return true;	
		}	
	}
	
    /**
    *   @Function: messageTra
    **/
    function messageTransactional($authKey){
		//Authentication key
		//$authKey = "208759Ak8kUUaL5acb1154";
 
		$url =	"https://control.msg91.com/api/balance.php";
		
		$postData = array(
			'authkey' => ($authKey!='1') ? $authKey : '',
			'type' => '4'
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));
 
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 
		//get response
		$output = curl_exec($ch);
		//echo 'output=======>'.$output;die;
		return $output;		
	}
	
    function send_mail($email,$subject,$message)
    {
        $CI =& get_instance();      
        $url = 'smtp.gmail.com';
        $user = 'welcome@shyamnaamtrust.com';
        $pass = 'yaacuszsqvlhojfr';
        $params = array(
            'api_user'  => $user,
            'api_key'   => $pass,
            'to'        => $email,
            'subject'   => $subject,
            'html'      => $message,
            'from'      => 'admin@kptpipes.com',
          );
        print_r($params);
        $request =  $url.'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        print_r($response);
        curl_close($session);
        return $response;
    }
	function send_mail_old($email,$subject,$message)
	{
		$CI =& get_instance();		
		$url = 'https://api.sendgrid.com/';
		$user = 'basant0906';
		$pass = 'Immersive@1qaz2wsx';
 		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
	 		'to'        => $email,
			'subject'   => $subject,
			'html'      => $message,
		 	'from'      => 'info@estree.com',
		  );
		$request =  $url.'api/mail.send.json';
		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		// Tell PHP not to use SSLv3 (instead opting for TLS)
		curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);

		curl_close($session);
		return $response;
	}  

    function sendNotifications($device_id, $message, $notify_type,$url = null)
    {
     
        $CI =& get_instance();
        
        //  define( 'API_ACCESS_KEY', 'AAAAL7VukEo:APA91bFlb8tuWE4bEdv3jdanlTwIG6zHogrif798kc7YrtFJLfANeRCDOVG9ozaypuQrIt3lcRlVIgT_Q_Bqpsh3zWfizp8ObnLuRo46KpiLjPWnoHa1jlvs_i72Q7SCqu80EsWlmUnb' );
        
        if($device_id!='')
        {
            //print_r($device_id);
            $registrationDeviceIds = array($device_id);
            // prep the bundle
            $msg = array
            (
                'message'   => $message,
                'image'   => $url,
                'notify_type'   => $notify_type,
                'title'     => 'DHANVARSHA',
                'subtitle'  => 'New notification',
                'tickerText'  => 'Update Status',
                'vibrate'   => 1,
                'sound'     => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );
            $fields = array
            (
                'registration_ids'  => $registrationDeviceIds,
                'data'          => $msg
            );
          
            $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            //var_dump($result);//
            curl_close( $ch );
           // echo $result;
           // die;
            return $result;
        }else{
            return true;
        }
    }

    function sendNotification_new($table,$userId, $message, $notify_type,$url = null)
    {
     
        $CI =& get_instance();
        
        //  define( 'API_ACCESS_KEY', 'AAAAL7VukEo:APA91bFlb8tuWE4bEdv3jdanlTwIG6zHogrif798kc7YrtFJLfANeRCDOVG9ozaypuQrIt3lcRlVIgT_Q_Bqpsh3zWfizp8ObnLuRo46KpiLjPWnoHa1jlvs_i72Q7SCqu80EsWlmUnb' );
        
        $device_id = $CI->db->get_where($table,$userId)->row('token');
        
        if($device_id!='')
        {
            //print_r($device_id);
            $registrationDeviceIds = array($device_id);
            // prep the bundle
            $msg = array
            (
                'message'   => $message,
                'image'   => $url,
                'notify_type'   => notify_type($notify_type),
                'title'     => 'Pink-blood',
                'subtitle'  => 'New notification',
                'tickerText'    => 'Update Status',
                'vibrate'   => 1,
                'sound'     => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );
            $fields = array
            (
                'registration_ids'  => $registrationDeviceIds,
                'data'          => $msg
            );
          
            $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            //var_dump($result);//
            curl_close( $ch );
           // echo $result;
           // die;
            return $result;
        }else{
            return true;
        }
    }