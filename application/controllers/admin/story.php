<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-05-10
 * Time: 오후 4:51
 */

class Story extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $admin = $this->session->userdata("idx");
        if($admin == ""){
            redirect("admin/session", "refresh");
        }

        $this->load->model('admin/m_story');

        $this->data['page']             = $this->input->get_post('page')? $this->input->get_post('page') : 1;
        $this->data['size']             = $this->input->get_post('size')? $this->input->get_post('size') : 20;
        $this->data['start_date']       = $this->input->get_post('start_date');
        $this->data['end_date']         = $this->input->get_post('end_date');
        $this->data['is_exps']          = $this->input->get_post('is_exps')? $this->input->get_post('is_exps') : "";
        $this->data['search_field']     = $this->input->get_post('search_field');
        $this->data['search_string']    = $this->input->get_post('search_string');
        $this->data['base_url']         = current_url() ."?is_exps=" . $this->data['is_exps'] . "&search_field=" . $this->data['search_field'] . "&search_string=" . $this->data['search_string'] . "&start_date=" . $this->data['start_date'] . "&end_date=" . $this->data['end_date'] . "&size=" . $this->data['size'];
        $this->data['cur_page']         = $this->data['page'];
        $this->data['row_cnt']          = 0;

        //$this->output->enable_profiler(TRUE);
    }

    public function index(){

        $this->data["tot_row"]          = $this->m_story->selectStoryCount();
        $this->data['cur_num']          = $this->data['tot_row'] - $this->data['size'] *($this->data['cur_page']-1);
        $this->paging->init($this->data);
        $this->data['paging']           = $this->paging->create_page($this->data['size'], $this->data['cur_page']);
        $this->data["result"]           = $this->m_story->selectStory();
        $this->load->view('admin/story/index',$this->data);
    }

    public function regist(){

        $ST_SEQ                            = $this->input->get_post('ST_SEQ');

        $result                            = $this->m_story->selectStoryOne($ST_SEQ);

        $this->data['ST_SEQ']               = '';
        $this->data['ST_TTL']               = '';
        $this->data['ST_VOD_MP4']           = '';
        $this->data['ST_CONT']              = '';
        $this->data['ST_EXPS_YN']           = 'N';

        if(count($result) > 0){
            $this->data['ST_SEQ']           = $result->ST_SEQ;
            $this->data['ST_TTL']           = $result->ST_TTL;
            $this->data['ST_VOD_MP4']       = $result->ST_VOD_MP4;
            $this->data['ST_CONT']          = $result->ST_CONT;
            $this->data['ST_EXPS_YN']       = $result->ST_EXPS_YN;

        }

        $this->load->view('admin/story/regist', $this->data);
    }

    public function registProcess(){
        $this->yield                        = FALSE;

        $ST_SEQ                             = $this->input->post('ST_SEQ');
        $ST_TTL                             = $this->input->post('ST_TTL');
        $ST_VOD_MP4                         = $this->input->post('ST_VOD_MP4');
        $ST_CONT                            = $this->input->post('ST_CONT');
        $ST_EXPS_YN                         = $this->input->post('ST_EXPS_YN');

        $data                               = array("ST_TTL"=>$ST_TTL, "ST_VOD_MP4"=>$ST_VOD_MP4, "ST_CONT"=>$ST_CONT, "ST_EXPS_YN"=>$ST_EXPS_YN);

        if($ST_SEQ == ""){
            $data['ST_RGST_YMDT']           = date('Y-m-d H:i:s');
            $this->result                   = $this->m_story->insertProcess($data);
        }else{
            $this->result                   = $this->m_story->updateProcess($data, $ST_SEQ);
        }

        echo $this->result;
    }

    public function deleteProcess(){
        $this->yield                        = FALSE;

        $ST_SEQ                             = $this->input->post('ST_SEQ');

        if($ST_SEQ != ""){
            $result                         = $this->m_story->deleteProcess($ST_SEQ);

            echo $result;
        }
    }
}