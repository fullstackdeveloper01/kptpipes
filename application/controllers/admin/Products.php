<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }

    /* List all knowledgebase articles */
    public function index()
    {
        // if (!has_permission('products', '', 'view')) {
        //     access_denied('products');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('products');
        }
       
        $sheader_text = title_text('aside_menu_active', 'products');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_list'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $this->load->view('admin/product/products', $data);
    }

    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {   
            if (!checkPermissions('product')) {
                access_denied('product');
            }     
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'products', $postdata);
        }
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        // if (!has_permission('products', '', 'view')) {
        //     access_denied('products');
        // }
        if (!checkPermissions('product')) {
            access_denied('product');
        }
        if ($this->input->post()) {
            $data  = $this->input->post();
            
            if ($id == '') {
                // if (!has_permission('products', '', 'create')) {
                //     access_denied('products');
                // }
                $data['created_date'] = date('Y-m-d H:i:s');
                $error=0;
                for ($is=0; $is < count($this->input->post('color')) ; $is++) { 
                    $data['color']=$this->input->post('color')[$is];
                    $data['product_variant']=$data['title'].' ('.$data['color'].')';
                    $check_entry = $this->db->get_where(db_prefix().'products',['product_variant'=>$data['product_variant']])->row();
                    if ($check_entry=="") {
                        $id = $this->product_model->add_article($data);
                        if ($id) {
                            $uploadedFiles = handle_file_upload($id,'product', $data['color']);
                            if ($uploadedFiles && is_array($uploadedFiles)) {
                                foreach ($uploadedFiles as $file) {
                                    $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                                }
                            }                    
                        }

                    }else{
                        $error++;
                    }
                }
                if ($error==0) {
                    set_alert('success', _l('added_successfully', _l('Product')));
                    redirect(admin_url('products'));
                }else{
                    set_alert('error', _l('Product Already Exits'));
                    redirect(admin_url('products'));
                }
            } else {
                // if (!has_permission('products', '', 'edit')) {
                //     access_denied('products');
                // }
                // print_r($data);die;
                $data['product_variant']=$data['title'].' ('.$data['color'].')';
                $success = $this->product_model->update_article($data, $id);
                if ($id) {
                    $uploadedFiles = handle_file_upload($id,'product', $data['color']);
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'))->row('file_name');
                            $fullPath  = 'uploads/product/' . $id . '/'.$filename;
                            unlink($fullPath);
                            $this->db->delete(db_prefix().'files', array('rel_id' => $id, 'rel_type' => 'product'));
                            $this->misc_model->add_attachment_to_database($id, 'product', [$file]);
                        }
                    }                    
                    set_alert('success', _l('updated_successfully', _l('Product')));
                }
                redirect(admin_url('products'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Product'));
        } else {
            $article         = $this->product_model->get($id);
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'products');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['category_list'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/product/product', $data);
    }

    /* Function: Category List */
    public function getCategorylist()
    {
        $profileResult = [];
        $state = $_POST['state'];
        $profileResult = $this->db->get_where(db_prefix().'category', array('brand_id' => $state))->result();
        echo json_encode($profileResult);
    }

    /* Function: Category List */
    public function getSubCategorylist()
    {
        $profileResult = [];
        $state = $_POST['state'];
        $profileResult = $this->db->get_where(db_prefix().'category', array('parent_id' => $state))->result();
        echo json_encode($profileResult);
    }

    /* Delete article from database */
    public function delete_product($id)
    {
        // if (!has_permission('products', '', 'delete')) {
        //     access_denied('products');
        // }
        if (!checkPermissions('product')) {
            access_denied('product');
        }
        if (!$id) {
            redirect(admin_url('products'));
        }
        $response = $this->product_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Product')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Product')));
        }
        redirect(admin_url('products'));
    }

    /* List all knowledgebase articles */
    public function stocks()
    {
        // if (!has_permission('stocks', '', 'view')) {
        //     access_denied('stocks');
        // }

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('stocks');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Stocks');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $data['category_list'] = $this->db->get_where(db_prefix().'category', array('parent_id' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $this->load->view('admin/product/stocks', $data);
    }

    public function stoke_status($id, $status)
    {
        if ($this->input->is_ajax_request()) { 
            if (!checkPermissions('product-stock')) {
                access_denied('product-stock');
            }       
            $postdata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'stocks', $postdata);
        }
    }
    /* Delete article from database */
    public function delete_stoke($id)
    {
        // echo $id;die;
        if (!checkPermissions('product-stock')) {
                access_denied('product-stock');
            }
        // if (!has_permission('stocks', '', 'delete')) {
        //     access_denied('stocks');
        // }
        if (!$id) {
            redirect(site_url('stocks'));
        }
        $response = $this->Stocks_model->delete_article($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Product')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Product')));
        }
        redirect(site_url('stocks'));
    }

    /* Add new article or edit existing*/
    public function addstock($id = '')
    {

        if (!has_permission('Stocks', '', 'view')) {
            access_denied('Stocks');
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            // print_r($data);die;
            if ($id == '') {
                if (!has_permission('Stocks', '', 'create')) {
                    access_denied('Stocks');
                }
                unset($data['barcode']);
                $id = $this->Stocks_model->add_article($data);
                if ($id) {
                    if ($this->input->post('barcode')=='yes') {
                        $this->barcode($data);
                    }
                    set_alert('success', _l('added_successfully', _l('Stocks')));
                    redirect(site_url('stocks'));
                }
            } else {
                if (!has_permission('stocks', '', 'edit')) {
                    access_denied('Stocks');
                }
                $success = $this->Stocks_model->update_article($data, $id);
                set_alert('success', _l('Updated_successfully', _l('Stocks')));
                redirect(site_url('stocks'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('Stokes'));
        } else {
            $article         = $this->Stocks_model->get($id);
            $data['article'] = $article;
        }
        $sheader_text = title_text('aside_menu_active', 'Stocks');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        $data['title']     = _l($sheader_text);
        $data['product_list'] = $this->db->get_where(db_prefix().'products', array('isDeleted' => 0, 'status' => 1))->result();
        $data['brand_list'] = $this->db->get_where(db_prefix().'brand', array('status' => 1))->result();
        $this->load->view('admin/product/stock', $data);
    }
    // genrate barcode
    public function barcode($data)
    {
        // print_r($data);die;
        for ($i=0; $i <$data['quantity'] ; $i++) { 
            // echo $code = rand(10000, 99999);
            $count=$i+1;
            $code = $data['bach_no'].'-'.$count;
            //load library
            $this->load->library('zend');
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
            //generate barcode
            $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
            // $imageResource = Zend_Barcode::render('code128', 'image', array('text'=>$code), array())->draw();die;
            imagepng($imageResource, 'uploads/barcodes/'.$code.'.png');
            $insertdata['product_id']=$data['product_id'];
            $insertdata['bach_no']=$data['bach_no'];
            $insertdata['barcode_value']=$code;
            $insertdata['image']='uploads/barcodes/'.$code.'.png';
            $this->Stocks_model->add_article_new($insertdata);
            //unlink(base_url("uploads/".$group_picture));
        }
        return true;
        // $data['barcode'] = 'barcodes/'.$code.'.png';
        // $this->load->view('welcome',$data);
    }

    /* Function: Product List */
    public function getProductlist()
    {
        $profileResult = [];
        $id = $_POST['id'];
        $profileResult = $this->db->get_where(db_prefix().'products', array('brand_id' => $id,'isDeleted'=>0))->result();
        echo json_encode($profileResult);
    }

    /* List all knowledgebase articles */
    public function getbarcode()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('barcode');
        }
       
        $sheader_text = title_text('aside_menu_active', 'Barcode');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;
        
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/product/barcode', $data);
    }

    /* List all knowledgebase articles */
    public function printbarcode($product_id,$barcode)
    {
        $sheader_text = title_text('aside_menu_active', 'Barcode Print');
        $data['sheading_text'] = $sheader_text;
        $data['sh_text'] = $sheader_text;

        $this->db->select('image');
        $this->db->from(db_prefix().'barcode');
        $this->db->where(['product_id'=>$product_id,'bach_no'=>$barcode,'status'=>1]);
        $data['response'] =$this->db->get()->result_array();
        // echo "<pre>";
        // print_r($response);die;
        $data['title']     = _l($sheader_text);
        $this->load->view('admin/product/printbarcode', $data);
    }
}
