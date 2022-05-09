<?php

defined('BASEPATH') or exit('No direct script access allowed');

class City extends AdminController
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
            $this->app->get_table_data('location_area');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'city');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['state_result'] = $this->db->get_where(db_prefix().'state')->result();
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/location/addCity', $data);
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
           
            $citydata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'city', $citydata);
        }
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
    public function addCity($id = '')
    {
        // if (!has_permission('master', '', 'view')) {
        //     access_denied('master');
        // }
        if ($this->input->post()) {
            $data                = $this->input->post();
            if ($id == '') {
                if (!checkPermissions('city')) {
                    access_denied('city');
                }
                $countryName = $this->db->get_where('tblcity', array('name' => $data['name']))->row('name');
                if($countryName)
                {
                    set_alert('warning', _l($countryName.' city name is already exists'));
                    redirect(admin_url('city'));
                }
                else
                {                    
                    $this->db->insert(db_prefix().'city', $data);
                    $id = $this->db->insert_id();
                    //$id = $this->location_model->add_locationCountry($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('City')));
                        //redirect(admin_url('state#locationyear'));
                        redirect(admin_url('city'));
                    }
                }
            } else {
                if (!checkPermissions('city')) {
                    access_denied('city');
                }
                $this->db->where('id', $id);
                $this->db->update(db_prefix().'city', $data);
                //$success = $this->location_model->update_locationmake($data, $id);
                if ($this->db->affected_rows() > 0) {
                    set_alert('success', _l('updated_successfully', _l('City')));
                }
                //redirect(admin_url('state#locationyear'));
                redirect(admin_url('city'));
            }
        }
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $cityRow = $this->db->get_where(db_prefix().'city', array('id' => $id))->row(); 
        $data['state_result'] = $this->db->get_where(db_prefix().'state', array('country_id' => $cityRow->country_id))->result();
        $data['cityRow'] = $cityRow;
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'city');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;

        $data['title']     = _l($subheader_text);
        $this->load->view('admin/location/area', $data);
    }
    
    public function getmodel(){
        echo 'make model';
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
        redirect(admin_url('city'));
    }
    
    // export Data
    public function sampledata() {
        $storData = array();
        $data[] = array('name' => 'Country');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"xlsx-sample-country".".xlsx\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;
    }
    
    // export Data
    public function sampledataCity() {
        $storData = array();
        $data[] = array('country_id' => 'Country', 'name' => 'State');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"xlsx-sample-state".".xlsx\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;
    }
    
    public function saveCity() {
        if(is_uploaded_file($_FILES['fileURL']['tmp_name'])) {     
            $csvData = $this->csvreader->parse_csv($_FILES['fileURL']['tmp_name']);       
            //echo '<pre>'; print_r($csvData); die;
           if(!empty($csvData)){
            $lid = '';
               $k = 1;
                foreach($csvData as $element){   
                    $name_make =   $element['Country'];
                    $name_model =   $element['State'];
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
                            unset($name_make);
                            unset($data_);
                        }
                        $city_id = $this->db->get_where(db_prefix().'state', array('name' => $name_model))->row('id');
                        if($city_id)
                        {
                            $yeardata['state_id'] = $city_id;
                        }
                        else
                        {
                            $datamodel_['country_id'] = $yeardata['country_id'];
                            $datamodel_['name'] = $name_model;
                            $this->db->insert(db_prefix() . 'state', $datamodel_);
                            $modellid = $this->db->insert_id();
                            $yeardata['state_id'] = $modellid;
                            $name_model = '';
                            unset($datamodel_);
                        }
                        $yeardata['name'] = $element['City'];
                        //$areaid = '';
                        $areaid.$k = $this->db->get_where(db_prefix().'city', array('name' => $yeardata['name']))->row('id');
                        if($areaid.$k == '')
                        {
                            $this->db->insert(db_prefix() . 'city', $yeardata);
                            $lid = $this->db->insert_id();
                            unset($yeardata); 
                            //$areaid = '';
                        }
                    }
                    $k++;
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
        redirect(admin_url('city'));
    }
    
    // export Data
    public function sampleCityData() {
        $storData = array();
        $data[] = array('country_id' => 'Country', 'state_id' => 'State', 'name' => 'City');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"city".".xlsx\"");
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
            redirect(admin_url('city'));
        }
        $response = $this->location_model->delete_locationCountry($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Country')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Country')));
        }
        redirect(admin_url('city'));
    }
    
    /* Delete article from database */
    public function delete_city($id)
    {
        if (!checkPermissions('city')) {
            access_denied('city');
        }
        if (!$id) {
            redirect(admin_url('city'));
        }
        $response = $this->location_model->delete_city($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('City')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('City')));
        }
        redirect(admin_url('city'));
    }
    /* Delete article from database */
    public function delete_locationArea($id)
    {
        if (!has_permission('master', '', 'delete')) {
            access_denied('master');
        }
        if (!$id) {
            redirect(admin_url('city'));
        }
        $response = $this->location_model->delete_locationArea($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('City')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('City')));
        }
        //redirect(admin_url('state#locationyear'));
        redirect(admin_url('city'));
    }
}
