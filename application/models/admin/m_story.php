<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-05-10
 * Time: 오후 4:51
 */

class M_story extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->limit        = 20;
        $this->offset       = 0;

        $this->total        = 0;
        $this->result_array = array();
        $this->result       = FALSE;
        $this->result_msg   = "실패";
    }

    function selectStoryCount(){
        if ($this->data['search_field'] != ""){
            $this->db->like($this->data['search_field'] , $this->data['search_string']);
        } else {
            $where = sprintf("(ST_TTL like '%s' or ST_CONT like '%s')", "%".$this->data['search_string']."%", "%".$this->data['search_string']."%");
            $this->db->where($where);
        }

        if ($this->data['start_date'] != ''){
            $this->db->where("date_format(ST_RGST_YMDT,'%Y-%m-%d')  >=", $this->data['start_date']);
        }
        if ($this->data['end_date'] != ''){
            $this->db->where("date_format(ST_RGST_YMDT,'%Y-%m-%d')  <=", $this->data['end_date']);
        }
        if ($this->data['is_exps'] != ""){
            $this->db->where("ST_EXPS_YN", $this->data['is_exps']);
        }

        $this->db->select('ST_SEQ');
        $this->db->from('t_story');
        $this->total = $this->db->count_all_results();
        return  $this->total;
    }

    function selectStory(){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }

        $this->limit  = $this->data['size'];

        if ($this->data['search_field'] != ""){
            $this->db->like($this->data['search_field'] , $this->data['search_string']);
        } else {
            $where = sprintf("(ST_TTL like '%s' or ST_CONT like '%s')", "%".$this->data['search_string']."%", "%".$this->data['search_string']."%");
            $this->db->where($where);
        }

        if ($this->data['start_date'] != ''){
            $this->db->where("date_format(ST_RGST_YMDT,'%Y-%m-%d')  >=", $this->data['start_date']);
        }
        if ($this->data['end_date'] != ''){
            $this->db->where("date_format(ST_RGST_YMDT,'%Y-%m-%d')  <=", $this->data['end_date']);
        }
        if ($this->data['is_exps'] != ""){
            $this->db->where("ST_EXPS_YN", $this->data['is_exps']);
        }

        $this->db->order_by('ST_SEQ desc');
        $query = $this->db->get('t_story', $this->limit , $this->offset );
        return $this->result_array = $query->result_array();
    }

    function selectStoryOne($ST_SEQ){

        $this->db->where('ST_SEQ', $ST_SEQ);

        $query  = $this->db->get('t_story');
        return $result  = $query->row();
    }

    function insertProcess($data){
        return $this->db->insert("t_story", $data);
    }

    function updateProcess($data, $ST_SEQ){
        $this->db->where("ST_SEQ", $ST_SEQ);
        return $this->db->update("t_story", $data);
    }

    function deleteProcess($ST_SEQ){
        $this->db->where("ST_SEQ", $ST_SEQ);
        return $this->db->delete("t_story");
    }
}