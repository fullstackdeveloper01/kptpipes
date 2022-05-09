<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrimeDelivery extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /* List all Prime Delivery */
    public function index()
    {
        if (!has_permission('primeDelivery', '', 'view')) {
            access_denied('primeDelivery');
        }
        if($this->input->post())
        {
            $postData['description'] = $this->input->post('description');
            $this->db->where('id', 6);
            $this->db->update(db_prefix().'content',$postData);
            set_alert('success', _l('updated_successfully', _l('Prime delivery')));
            redirect(admin_url('primeDelivery'));
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'primeDelivery');
        $data['aboutus'] = $this->db->get_where(db_prefix().'content', array('id' => 6))->row('description');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title'] = 'Prime Delivery';
        $this->load->view('admin/content/primeDelivery', $data);
    }
}
