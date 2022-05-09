<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PriceRange extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pricerange_model');
    }

    /* List all articles */
    public function index()
    {
        if (!has_permission('priceRange', '', 'view')) {
            access_denied('priceRange');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('priceRange');
        }
       
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'priceRange');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/priceRange/priceRanges', $data); 
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('priceRange', '', 'view')) {
            access_denied('priceRange');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            if ($id == '') {
                if (!has_permission('priceRange', '', 'create')) {
                    access_denied('priceRange');
                }
                $data['created_date'] = date('Y-m-d h:i:s');
                $priceval = $this->db->get_where(db_prefix().'master_price', array('price' => $data['price']))->row('price');
                if($priceval != '')
                {
                    set_alert('warning', _l('Price are already addedd: ', _l($data['price'])));
                    redirect(admin_url('priceRange'));
                }
                else
                {
                    $id = $this->pricerange_model->add_article($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('Price range')));
                        redirect(admin_url('priceRange'));
                    }
                }                    
            } else {
                if (!has_permission('priceRange', '', 'edit')) {
                    access_denied('priceRange');
                }
                $success = $this->pricerange_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Price range')));
                }
                redirect(admin_url('priceRange'));
            }
        }
        
        if ($id == '') {
        } else {
            $article         = $this->pricerange_model->get($id);
            $data['article'] = $article;
        }
        
        $sheader_text = setupTitle_text('aside_menu_active', 'master', 'priceRange');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/priceRange/priceRanges', $data);
    }

    /**
    * @funciton: Status change
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'master_price', $postdata);
        }
    }

    /* Delete article from database */
    public function delete_priceRange($id)
    {
        if (!has_permission('priceRange', '', 'delete')) {
            access_denied('priceRange');
        }
        if (!$id) {
            redirect(admin_url('priceRange'));
        }
        $this->pricerange_model->delete_article($id);
        set_alert('success', _l('deleted', _l('Price range')));
        redirect(admin_url('priceRange'));
    }
}
