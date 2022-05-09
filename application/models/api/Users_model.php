<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends App_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 	
 	public function login($email, $password, $remember, $staff)
    {
        if ((!empty($email)) and (!empty($password))) {
            $table = db_prefix() . 'contacts';
            $_id   = 'id';
            if ($staff == true) {
                $table = db_prefix() . 'staff';
                $_id   = 'staffid';
            }
            $this->db->where('email', $email);
            $user = $this->db->get($table)->row();
            if ($user) {
                // Email is okey lets check the password now
                if (!app_hasher()->CheckPassword($password, $user->password)) {
                    hooks()->do_action('failed_login_attempt', [
                        'user'            => $user,
                        'is_staff_member' => $staff,
                    ]);

                    log_activity('Failed Login Attempt [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

                    // Password failed, return
                    return false;
                }
            } else {

                hooks()->do_action('non_existent_user_login_attempt', [
                        'email'           => $email,
                        'is_staff_member' => $staff,
                ]);

                log_activity('Non Existing User Tried to Login [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

                return false;
            }

            if ($user->active == 0) {
                hooks()->do_action('inactive_user_login_attempt', [
                        'user'            => $user,
                        'is_staff_member' => $staff,
                ]);
                log_activity('Inactive User Tried to Login [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

                return [
                    'memberinactive' => true,
                ];
            }

            $twoFactorAuth = false;
            if ($staff == true) {
                $twoFactorAuth = $user->two_factor_auth_enabled == 0 ? false : true;

                if (!$twoFactorAuth) {
                    hooks()->do_action('before_staff_login', [
                        'email'  => $email,
                        'userid' => $user->$_id,
                    ]);

                    $user_data = [
                        'staff_user_id'   => $user->$_id,
                        'staff_logged_in' => true,
                    ];
                } else {
                    $user_data = [];
                    if ($remember) {
                        $user_data['tfa_remember'] = true;
                    }
                }
            } else {
                hooks()->do_action('before_client_login', [
                    'email'           => $email,
                    'userid'          => $user->userid,
                    'contact_user_id' => $user->$_id,
                ]);

                $user_data = [
                    'client_user_id'   => $user->userid,
                    'contact_user_id'  => $user->$_id,
                    'client_logged_in' => true,
                ];
            }

            //return base64_encode($user->userid);
            return $user;
        }

        return false;
    }
    
    /* Register function */
    public function register($data)
    {
        $clientdata['company'] = $data['firstname'].' '.$data['lastname'];
        $clientdata['phonenumber'] = $data['mobile'];
        $clientdata['addedfrom'] = 1;
        $clientdata['datecreated'] = date('Y-m-d H:i:s');
        $this->db->insert(db_prefix() . 'clients', $clientdata);
        $userid = $this->db->insert_id();
        
        if($userid)
        {
            $user_data['password'] = app_hash_password(@$data['password']);
            $user_data['userid'] = $userid;
            $user_data['firstname'] = $data['firstname'];
            $user_data['lastname'] = $data['lastname'];
            $user_data['phonenumber'] = $data['mobile'];
            $user_data['email'] = $data['mobile'];
            $user_data['gender'] = $data['gender'];
            $user_data['birth_time'] = $data['birth_time'];
            $user_data['birth_place'] = $data['birth_place'];
            $user_data['email_verified_at'] = date('Y-m-d h:i:s');
            $user_data['datecreated'] = date('Y-m-d h:i:s');
            $user_data['dob'] = date('Y-m-d', strtotime($data['dob']));
            
            $this->db->insert(db_prefix() . 'contacts', $user_data);
            $contact_id = $this->db->insert_id();
            
            $this->db->where('id', $contact_id);
            $this->db->update(db_prefix() . 'contacts', [
                'invoice_emails'     => 1,
                'estimate_emails'    => 1,
                'credit_note_emails' => 1,
                'contract_emails'    => 1,
                'task_emails'        => 1,
                'project_emails'     => 1,
                'ticket_emails'      => 1,
            ]);
            
            $groupData['groupid'] = 1;
            $groupData['customer_id'] = $userid;
            $this->db->insert(db_prefix().'customer_groups', $groupData);
            $this->db->insert_id();
            
            for($i<1; $i<7;$i++)
            {
                $this->db->insert(db_prefix() . 'contact_permissions', [
                    'userid'        => $userid,
                    'permission_id' => $i,
                ]);
            }
            
            return true;
            exit();
        }
        return false;    
    }
    
    /* Register function */
    public function signUp($data)
    {
        $clientdata['company'] = ucwords($data['firstname']);
        $clientdata['phonenumber'] = $data['mobile'];
        $clientdata['address'] = $data['address'];
        $clientdata['addedfrom'] = 1;
        $clientdata['datecreated'] = date('Y-m-d H:i:s');
        $this->db->insert(db_prefix() . 'clients', $clientdata);
        $userid = $this->db->insert_id();
        
        if($userid)
        {
            $user_data['password'] = app_hash_password(@$data['password']);
            $user_data['userid'] = $userid;
            $user_data['firstname'] = ucwords($data['firstname']);
            $user_data['phonenumber'] = $data['mobile'];
            $user_data['email'] = $data['email'];
            //$user_data['state'] = $data['state'];
            //$user_data['city'] = $data['city'];
            $user_data['email_verified_at'] = date('Y-m-d h:i:s');
            $user_data['datecreated'] = date('Y-m-d h:i:s');
            //$user_data['dob'] = date('Y-m-d', strtotime($data['dob']));
            
            $this->db->insert(db_prefix() . 'contacts', $user_data);
            $contact_id = $this->db->insert_id();
            
            $this->db->where('id', $contact_id);
            $this->db->update(db_prefix() . 'contacts', [
                'invoice_emails'     => 1,
                'estimate_emails'    => 1,
                'credit_note_emails' => 1,
                'contract_emails'    => 1,
                'task_emails'        => 1,
                'project_emails'     => 1,
                'ticket_emails'      => 1,
            ]);
            
            $groupData['groupid'] = 1;
            $groupData['customer_id'] = $userid;
            $this->db->insert(db_prefix().'customer_groups', $groupData);
            $this->db->insert_id();
            
            for($i<1; $i<7;$i++)
            {
                $this->db->insert(db_prefix() . 'contact_permissions', [
                    'userid'        => $userid,
                    'permission_id' => $i,
                ]);
            }
            
            return true;
            exit();
        }
        return false;    
    }
    
    /* this function is for to update data in any table*/

    public function updateData($table_name , $where_array , $post)
    {
        $this->db->where($where_array);
        $res = $this->db->update($table_name, $post);
        if ($res > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /* this function is for to select data count any table*/

    public function selectCount($table_name , $where_array=null)
    {
        $this->db->from($table_name);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        return $this->db->get()->num_rows();
    }

    /* this function is for to select data count any table*/

    public function Select($table_name , $where_array=null,$select=null,$orderby_id=null,$order_by=null)
    {
        $select=isset($select)?$select:'*';
        $this->db->select($select);
        $this->db->from($table_name);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        if ($orderby_id!=""&& $order_by!="") {
            $this->db->order_by($orderby_id,$order_by);
        }
        return $this->db->get()->result_array();
    }

    /* this function is for to select data count any table*/

    public function Insert($table_name , $data)
    {
        return $this->db->insert($table_name,$data);
    }

    /* this function is for to select data count sums*/

    public function CountSums($table_name , $where_array,$column)
    {
        $this->db->select('SUM('.$column.') as '.$column.'');
        $this->db->from($table_name);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        $res= $this->db->get()->row($column);
        if ($res != null) {
           return $res;
        }else{
            return 0;
        }
    }

    /* this function is for to select data count sums points*/

    public function CountSumspoints($table_name , $where_array,$column)
    {
        $this->db->select('*, SUM('.$column.') as '.$column.'');
        $this->db->from($table_name);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        $res= $this->db->group_by('status_type')->get()->row();
        print_r($res);die;
        if ($res != null) {
           return $res;
        }else{
            return 0;
        }
    }

    /* this function is for to select data count any table*/

    public function SelectJoin($table_name ,$table_name1 ,$Joinon, $where_array=null,$select=null,$orderby_id=null,$order_by=null)
    {
        $select=isset($select)?$select:'*';
        $this->db->select($select);
        $this->db->from($table_name);
        $this->db->join($table_name1,$Joinon);
        if ($where_array!="")
        {
            $this->db->where($where_array);
        }
        if ($orderby_id!=""&& $order_by!="") {
            $this->db->order_by($orderby_id,$order_by);
        }
        return $this->db->get()->result_array();
    }
}