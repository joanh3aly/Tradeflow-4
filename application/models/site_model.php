<?php
class Site_model extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }
    
    public function getAll()
    {
        $q    = array();
        $data = array();
        
        $q = $this->db->get('tradeInfo');
        
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    
    public function getIDs($stage)
    {
        $queryInfo = array();
        $data      = array();
        $queryInfo = $this->db->get_where('tradeStageTime', array(
            $stage . ' IS NOT NULL' => NULL
        ));
        
        if ($queryInfo->num_rows() > 0) {
            foreach ($queryInfo->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    public function getRecordByID($id)
    {
        $queryInfo = array();
        $dataID    = array();
        $sql       = "SELECT * FROM tradeInfo WHERE TFL_tradeID = ? ";
        $queryInfo = $this->db->query($sql, array(
            $id
        ));
        
        if ($queryInfo->num_rows() > 0) {
            foreach ($queryInfo->result() as $row) {
                $dataID[] = $row;
            }
            return $dataID;
        }
    }
    
    public function insertJSONdata($data)
    {
        $query = $this->db->insert('tradeInfo', $data);
        return;
    }
    
    public function insertStage($data)
    {
        $query = $this->db->insert('tradeStageTime', $data);
        return;
    }
}