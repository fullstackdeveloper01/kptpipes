<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Area extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('area_model');
        $this->load->library('CSVReader');
    }

    /* List all knowledgebase locationmakes */
    public function index()
    {
        if (!has_permission('master', '', 'view')) {
            access_denied('master');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('area');
        }
      
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'area');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['timeslot_list'] = $this->db->get_where(db_prefix().'timeslot')->result();
        //$data['state_result'] = $this->db->get_where(db_prefix().'city')->result();
        //$data['city_result'] = $this->db->get_where(db_prefix().'area')->result();
        $data['title']     = _l($subheader_text);
        $this->load->view('admin/area/areas', $data);
    }

    /* Function: State List */
    public function getStatelist()
    {
        $profileResult = [];
        $country_id = $_POST['country_id'];
        $profileResult = $this->db->get_where(db_prefix().'city', array('country_id' => $country_id))->result();
        echo json_encode($profileResult);
    }
    
    /* Function: City List */
    public function getCitylist()
    {
        $profileResult = [];
        $state_id = $_POST['state_id'];
        $profileResult = $this->db->get_where(db_prefix().'area', array('city_id' => $state_id))->result();
        echo json_encode($profileResult);
    }

    /**
    * @ Change status
    */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
           
            $areadata['status'] = $status;
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'area_new', $areadata);
            
            $pincodedata['status'] = $status;
            $this->db->where('area_id', $id);
            $this->db->update(db_prefix().'area_pincode', $pincodedata  );
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
                $data['created_date'] = date('Y-m-d h:i:s');
                $data['time_slot'] = implode(',',$data['time_slot']);
                $data['extra_charge'] = ($data['extra_charge'] != '')?$data['extra_charge']:0;
                $id = $this->area_model->add_area($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Area')));
                    redirect(admin_url('area'));
                }
            } else {
                if (!has_permission('master', '', 'edit')) {
                    access_denied('master');
                }
                $data['time_slot'] = implode(',',$data['time_slot']);
                $success = $this->area_model->update_area($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Area')));
                }
                redirect(admin_url('area'));
            }
        }
        
        $subheader_text = setupTitle_text('aside_menu_active', 'master', 'area');
        $data['sheading_text'] = $subheader_text;
        $data['sh_text'] = $subheader_text;
        
        $data['article'] = $this->db->get_where(db_prefix().'area_new',array('id' => $id))->row();
        
        $data['country_result'] = $this->db->get_where(db_prefix().'country')->result();
        $data['timeslot_list'] = $this->db->get_where(db_prefix().'timeslot')->result();
        //$data['city_result'] = $this->db->get_where(db_prefix().'area')->result();

        $data['title']     = _l($sheader_text);
        $this->load->view('admin/area/area', $data);
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
            $this->app->get_table_data('area');
        }
    }

    public function saveArea() {
        if(is_uploaded_file($_FILES['fileURL']['tmp_name'])) {     
            $csvData = $this->csvreader->parse_csv($_FILES['fileURL']['tmp_name']);     
            if(!empty($csvData)){
                $k = 1;
                foreach($csvData as $element){   
                    $country =   $element['Country'];
                    $state =   $element['State'];
                    $city =   $element['City'];
                    $area =   $element['Area'];
                    $extracharge =   $element['Extra_Charge'];
                    $pincode =   $element['Pincode'];
                    if($country != '' && $state != '' && $city != '' && $area != '' && $extracharge != '' && $pincode != '')
                    {
                        $country_id = $this->db->get_where(db_prefix().'country', array('name' => $country))->row('id');
                        if($country_id)
                        {
                            $yeardata['country_id'] = $country_id;
                            $areadata['country_id'] = $country_id;
                            $pincodedata['country_id'] = $country_id;
                        }
                        else
                        {
                            $data_['name'] = $country;
                            $this->db->insert(db_prefix() . 'country', $data_);
                            $makelid = $this->db->insert_id();
                            $yeardata['country_id'] = $makelid;
                            $areadata['country_id'] = $makelid;
                            $pincodedata['country_id'] = $makelid;
                            $country = '';
                            $data_ = '';
                        }
                        $state_id = $this->db->get_where(db_prefix().'city', array('name' => $state))->row('id');
                        if($state_id)
                        {
                            //$yeardata['city_id'] = $state_id;
                            $areadata['state_id'] = $state_id;
                        }
                        else
                        {
                            $datamodel_['country_id'] = $yeardata['country_id'];
                            $datamodel_['name'] = $state;
                            $this->db->insert(db_prefix() . 'city', $datamodel_);
                            $modellid = $this->db->insert_id();
                            $yeardata['city_id'] = $modellid;
                            $areadata['state_id'] = $modellid;
                            $pincodedata['state_id'] = $modellid;
                            $state = '';
                            $datamodel_ = '';
                        }
                        $city_id = $this->db->get_where(db_prefix().'area', array('name' => $city))->row('id');
                        if($city_id)
                        {
                            $areadata['city_id'] = $city_id;
                            $pincodedata['city_id'] = $city_id;
                        }
                        else
                        {
                            $yeardata['name'] = $element['City'];
                            $this->db->insert(db_prefix() . 'area', $yeardata);
                            $cityid = $this->db->insert_id();
                            $areadata['city_id'] = $cityid;
                            $pincodedata['city_id'] = $cityid;
                        }
                        $area_id = $this->db->get_where(db_prefix().'area_new', array('areaname' => $area))->row('id');
                        if($area_id)
                        {
                            $pincodedata['area_id'] = $area_id;
                        }
                        else
                        {
                            $areadata['areaname'] = $area;
                            $areadata['extra_charge'] = $extracharge;
                            $this->db->insert(db_prefix() . 'area_new', $areadata);
                            $areaid = $this->db->insert_id();
                            $pincodedata['area_id'] = $areaid;
                        }
                        $pincode_id = $this->db->get_where(db_prefix().'area_pincode', array('pincode' => $pincode))->row('id');
                        if($pincode_id)
                        {
                            //$pincodedata['area_id'] = $pincode_id;
                        }
                        else
                        {
                            $pincodedata['pincode'] = $pincode;
                            $this->db->insert(db_prefix() . 'area_pincode', $pincodedata);
                            //$areaid = $this->db->insert_id();
                            //$pincodedata['area_id'] = $areaid;
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
        redirect(admin_url('area'));
    }
    
    // export Data
    public function sampledataArea() {
        $storData = array();
        $data[] = array('country_id' => 'Country', 'state_id' => 'State', 'city_id' => 'City', 'areaname' => 'Area', 'extra_charge' => 'Extra_Charge', 'pincode' => 'Pincode');       
        
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"csv-sample-area".".xlsx\"");
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
    public function delete_area($id)
    {
        if (!has_permission('master', '', 'delete')) {
            access_denied('master');
        }
        if (!$id) {
            redirect(admin_url('area'));
        }
        $response = $this->area_model->delete_area($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Area')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Area')));
        }
        redirect(admin_url('area'));
    }
}
