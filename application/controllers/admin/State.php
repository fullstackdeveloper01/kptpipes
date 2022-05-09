<?php

defined('BASEPATH') or exit('No direct script access allowed');

class State extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('location_model');
        $this->load->library('CSVReader');
    }

    /* List all knowledgebase locationmakes */
    public function index()
    {
        // if (!has_permission('master', '', 'view')) {
        //     access_denied('master');
        // }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('location_city');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'state');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['city_result'] = $this->db->get_where(db_prefix().'city')->result();
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/location/addState', $data);
    }

    /* Function: City List */
    public function getCitylist()
    {
        $profileResult = [];
        $country_id = $_POST['country_id'];
        $profileResult = $this->db->get_where(db_prefix().'city', array('country_id' => $country_id))->result();
        echo json_encode($profileResult);
    }
    
    /**
    * @ Change status
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {           
            $statedata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'state', $statedata);
            
            $citydata['status'] = $status;
            $this->db->where('state_id', $id);
            $this->db->update(db_prefix().'city', $citydata);
        }
    }

    /* Add new article or edit existing*/
    public function add($id = '')
    {
        if (!has_permission('master', '', 'view')) {
            access_denied('master');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('master', '', 'create')) {
                    access_denied('master');
                }
                $id = $this->location_model->add_locationCountry($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Country')));
                    redirect(admin_url('state'));
                }
            } else {
                if (!has_permission('master', '', 'edit')) {
                    access_denied('master');
                }
                
                $success = $this->location_model->update_locationCountry($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Country')));
                }
                redirect(admin_url('state'));
            }
        }
        
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'state');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['article'] = $this->db->get_where(db_prefix().'country',array('id' => $id))->row();
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['city_result'] = $this->db->get_where(db_prefix().'city')->result();

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/location/location', $data);
    }

    /* getCityModel */
    public function citytable()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('location_city');
        }
    }
    /* Area table */
    public function areatable()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('location_area');
        }
    }

    /* Add new article or edit existing*/
    public function addState($id = '')
    {
        // if (!has_permission('master', '', 'view')) {
        //     access_denied('master');
        // }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!checkPermissions('state')) {
                    access_denied('state');
                } 
                $countryName = $this->db->get_where('tblstate', array('name' => $data['name']))->row('name');
                if($countryName)
                {
                    set_alert('warning', _l($countryName.' state name is already exists'));
                    redirect(admin_url('state'));
                }
                $code = $this->db->get_where('tblstate', array('state_code' => $data['state_code']))->row('state_code');
                if($code)
                {
                    set_alert('warning', _l($code.' state code is already exists'));
                    redirect(admin_url('state'));
                }
                else
                {
                    $this->db->insert(db_prefix().'state', $data);
                    $id = $this->db->insert_id();
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('State')));
                        redirect(admin_url('state'));
                    }                    
                }
            } else {
                if (!checkPermissions('state')) {
                    access_denied('state');
                } 
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'state', $data);
                //$success = $this->location_model->update_locationmake($data, $id);
                if ($this->db->affected_rows() > 0) {
                    set_alert('success', _l('updated_successfully', _l('State')));
                }
                redirect(admin_url('state'));
            }
        }
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['city_result'] = $this->db->get_where(db_prefix().'state', array('id' => $id))->row();
        
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'state');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/location/state', $data);
    }

    /* Add new article or edit existing*/
    public function addArea($id = '')
    {
        if (!has_permission('master', '', 'view')) {
            access_denied('master');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('master', '', 'create')) {
                    access_denied('master');
                }
                $this->db->insert(db_prefix().'area', $data);
                $id = $this->db->insert_id();
                //$id = $this->location_model->add_locationCountry($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('City')));
                    redirect(admin_url('state#locationyear'));
                }
            } else {
                if (!has_permission('master', '', 'edit')) {
                    access_denied('master');
                }
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'area', $data);
                //$success = $this->location_model->update_locationmake($data, $id);
                if ($this->db->affected_rows() > 0) {
                    set_alert('success', _l('updated_successfully', _l('City')));
                }
                redirect(admin_url('state#locationyear'));
            }
        }
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['city_result'] = $this->db->get_where(db_prefix().'city')->result();
        $data['area_result'] = $this->db->get_where(db_prefix().'area', array('id' => $id))->row(); 
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'state');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/location/area', $data);
    }
    
    public function getmodel(){
        echo 'make model ';
    }

    public function save() {
        // If file uploaded
        if(is_uploaded_file($_FILES['fileURL']['tmp_name'])) {                            
            // Parse data from CSV file
            $csvData = $this->csvreader->parse_csv($_FILES['fileURL']['tmp_name']);       
            //echo '<pre>'; print_r($csvData); die;
            // create array from CSV file
            if(!empty($csvData)){
                foreach($csvData as $element){                    
                    // Prepare data for Database insertion
                    $data = array(
                        'name' => $element['Country']
                    );
                    $exitcategory = $this->db->get_where(db_prefix().'country', array('name' => $data['name']))->row('name');
                    if($exitcategory != ''){}
                    else
                    {
                        $this->db->insert(db_prefix() . 'country', $data);
                        $data[] = '';
                    }
                }
                set_alert('success', _l('Data are stored successful!'));
            }
            else
            {
                set_alert('warning', _l('File is required'));
            }
        }
        else
        {
            set_alert('warning', _l('File is required'));
        } 
        redirect(admin_url('state'));
    }
    
    // export Data
    public function sampledata() {
        $storData = array();
        $data[] = array('name' => 'Country');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"csv-sample-country".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;
    }

    public function saveState() {
        if(is_uploaded_file($_FILES['fileURL']['tmp_name'])) {     
            $csvData = $this->csvreader->parse_csv($_FILES['fileURL']['tmp_name']);       
            //echo '<pre>'; print_r($csvData); die;
           if(!empty($csvData)){
            $lid = '';
                foreach($csvData as $element){   
                    $name_make =   $element['Country'];
                    if($name_make != '')
                    {
                        $country_id = $this->db->get_where(db_prefix().'country', array('name' => $name_make))->row('id');
                        if($country_id)
                        {
                            $modeldata['country_id'] = $country_id;
                        }
                        else
                        {
                            $data_['name'] = $name_make;
                            $this->db->insert(db_prefix() . 'country', $data_);
                            $makelid = $this->db->insert_id();
                            $modeldata['country_id'] = $makelid;
                            unset($name_make);
                            unset($data_);
                        }
                        $modeldata['name'] = $element['State'];
                        $modeldata['state_code'] = $element['Code'];
                        $cityName = $this->db->get_where(db_prefix().'state', array('name' => $modeldata['name']))->row('name');
                        if($cityName == '')
                        {
                            $this->db->insert(db_prefix() . 'state', $modeldata);
                            $lid = $this->db->insert_id();
                            unset($modeldata);
                        }
                    }
                }
                if($lid != '')
                    set_alert('success', _l('Data are stored successful!'));
            }
            else
            {
                set_alert('warning', _l('File is required'));
            }
        }
        else
        {
            set_alert('warning', _l('File is required'));
        } 
        redirect(admin_url('state'));
    }
    
    // export Data
    public function sampleStateData() {
        $storData = array();
        $data[] = array('country_id' => 'Country', 'state_code' => 'Code', 'name' => 'State');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"state-list".".xlsx\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;
    }
    
    public function saveArea() {
        if(is_uploaded_file($_FILES['fileURL']['tmp_name'])) {     
            $csvData = $this->csvreader->parse_csv($_FILES['fileURL']['tmp_name']);       
            //echo '<pre>'; print_r($csvData); die;
           if(!empty($csvData)){
               $k = 1;
                foreach($csvData as $element){   
                    $name_make =   $element['Country'];
                    $name_model =   $element['City'];
                    if($name_make != '' && $name_model != '')
                    {
                        $country_id = $this->db->get_where(db_prefix().'country', array('name' => $name_make))->row('id');
                        if($country_id)
                        {
                            $yeardata['country_id'] = $country_id;
                        }
                        else
                        {
                            $data_['name'] = $name_make;
                            $this->db->insert(db_prefix() . 'country', $data_);
                            $makelid = $this->db->insert_id();
                            $yeardata['country_id'] = $makelid;
                            $name_make = '';
                            $data_ = '';
                        }
                        $city_id = $this->db->get_where(db_prefix().'city', array('name' => $name_model))->row('id');
                        if($city_id)
                        {
                            $yeardata['city_id'] = $city_id;
                        }
                        else
                        {
                            $datamodel_['country_id'] = $yeardata['country_id'];
                            $datamodel_['name'] = $name_model;
                            $this->db->insert(db_prefix() . 'city', $datamodel_);
                            $modellid = $this->db->insert_id();
                            $yeardata['city_id'] = $modellid;
                            $name_model = '';
                            $datamodel_ = '';
                        }
                        $yeardata['name'] = $element['Area'];
                        //$areaid = '';
                        $areaid.$k = $this->db->get_where(db_prefix().'area', array('name' => $yeardata['name']))->row('id');
                        if($areaid.$k == '')
                        {
                            $this->db->insert(db_prefix() . 'area', $yeardata);
                            //$yeardata[] = ''; 
                            //$areaid = '';
                        }
                    }
                    $k++;
                }
                set_alert('success', _l('Data are stored successful!'));
            }
            else
            {
                set_alert('warning', _l('File is required'));
            }
        }
        else
        {
            set_alert('warning', _l('File is required'));
        } 
        redirect(admin_url('state'));
    }
    
    // export Data
    public function sampledataArea() {
        $storData = array();
        $data[] = array('country_id' => 'Country', 'city_id' => 'State', 'name' => 'City');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"xlsx-sample-city".".xlsx\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;
    }

    /* Delete article from database */
    public function delete_locationCountry($id)
    {
        if (!has_permission('master', '', 'delete')) {
            access_denied('master');
        }
        if (!$id) {
            redirect(admin_url('state'));
        }
        $response = $this->location_model->delete_locationCountry($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Country')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Country')));
        }
        redirect(admin_url('state'));
    }
    
    /* Delete article from database */
    public function delete_state($id)
    {
        if (!checkPermissions('state')) {
            access_denied('state');
        } 
        if (!$id) {
            redirect(admin_url('state'));
        }
        $response = $this->location_model->delete_state($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('State')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('State')));
        }
        redirect(admin_url('state'));
    }
    /* Delete article from database */
    public function delete_locationArea($id)
    {
        if (!has_permission('master', '', 'delete')) {
            access_denied('master');
        }
        if (!$id) {
            redirect(admin_url('state'));
        }
        $response = $this->location_model->delete_locationArea($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('City')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('City')));
        }
        redirect(admin_url('state#locationyear'));
    }
}
