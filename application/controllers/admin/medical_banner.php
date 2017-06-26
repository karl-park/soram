<?php
class Medical_banner extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('admin/m_medical_banner');
    }

    function index(){
        $this->data['result']           = $this->m_medical_banner->selectMedicalBanner();        
        $this->load->view('admin/medical_banner/index', $this->data);
    }
    
    function registProcess(){
        $this->yield                    = false;

        $BN_TTL                         = $this->input->post('BN_TTL');
        $BN_CONT                        = $this->input->post('BN_CONT');
        $BN_IMG                         = $this->input->post('BN_IMG');
        $BN_LINK                        = $this->input->post('BN_LINK');
        
        $data                           = array("BN_TTL"=>$BN_TTL, "BN_CONT"=>$BN_CONT, "BN_IMG"=>$BN_IMG, "BN_LINK"=>$BN_LINK);
        echo $this->m_medical_banner->updateProcess($data);
    }
}