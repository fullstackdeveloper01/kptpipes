<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ExportDatabase extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /* List all announcements */
    public function index()
    {
        if (!has_permission('content', '', 'view')) {
            access_denied('content');
        }
        if($this->input->post())
        {
            $where['page_name']=$this->input->post('page_name');
            $res = $this->db->get_where(db_prefix().'content',$where)->num_rows();
            // print_r($res);
            // die;
            if ($res>0) {
                $postData['description'] = $this->input->post('description');
                $this->db->where($where);
                $this->db->update(db_prefix().'content',$postData);
                set_alert('success', _l('updated_successfully', _l('About Us')));
            }else{
                $data =$this->input->post();
                $this->db->insert(db_prefix().'content',$data);
                set_alert('success', _l('added_successfully', _l('About Us')));
            }
            redirect(admin_url('aboutUs'));
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'content', 'back-up');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = 'Back-Up';
        $this->load->view('admin/backup/index', $data);
    }

    public function export(){
        if (!empty($this->input->post())) {
            $user = $this->Common_model->get(db_prefix().'staff',['email'=>$this->input->post('email'),'admin'=>1]);
            if ($user) {
                $password=$this->input->post('password');
                if (app_hasher()->CheckPassword($password, $user->password)) {
                    $res = $this->exportData();
                    if ($res) {
                        set_alert('success', 'Back up exported Successfully');
                        redirect(site_url('backup'));
                    }
                }else{
                    set_alert('danger', 'Invalid User Credential');
                    redirect(site_url('backup'));
                }
            }else{
                set_alert('danger', 'Invalid User ID Password');
                redirect(site_url('backup'));
            }
        }
    }
    public function exportData(){
        // $this->load->dbutil();
        //     $prefs = array(     
        //         'format'      => 'sql',             
        //         'filename'    => 'qapin.sql'
        //       );
        //     $backup =& $this->dbutil->backup($prefs); 
        //     $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.sql';
        //     $save = '/dbbackup/_tmp/'.$db_name;
        //     $this->load->helper('file');
        //     write_file($save, $backup); 
        //     $this->load->helper('download');
        //     force_download($db_name, $backup); 
        // die;
        $this->load->dbutil();
        // $this->load->helper('url');
        // $this->load->helper('file');
        $this->load->helper('download');
        // $this->load->library('zip');
        $prefs = array(
           // 'tables'        => array('table1', 'table2', 'table3'),   // Array of tables to backup.
           // 'ignore'        => array(),                     // List of tables to omit from the backup
           'format'        => 'sql',                       // gzip, zip, txt
           'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
           // 'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
           // 'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
           // 'newline'       => "\n"                         // Newline    character used in backup file
        );

        $backup=& $this->dbutil->backup($prefs);
        $dbname='backup-on-'.date('Y-m-d-h:i:s').'.sql';
        $save=UPLOAD_PATH_FEE_MANAGEMENT_TABLES.$dbname;
        write_file($save,$backup);
        force_download($dbname,$backup);
        return true;
    }
}
