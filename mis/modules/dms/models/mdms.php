<?php
class Mdms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function hasKeyword($userid, $keyword, $path, $keywordornot, $searchtype)
    {
        $data = array(
            'userid' => $userid,
            'keywords' => $keyword,
            'module' => $path,
            'status' => 'uncheck',
            'keywordornot' => $keywordornot,
            'searchtype' => $searchtype,
        );
        if ($this->checkDuplicate($userid, $keyword)) {
            $this->db->insert('doc_keyword', $data);
        } else {
            unset($data['status']);
            $this->db->where("keywords", $keyword);
            $this->db->where("userid", $userid);
            $this->db->update('doc_keyword', $data);
        }
    }

    public function getLastId($userid, $keyword)
    {

        $this->db->select("id");
        $this->db->where("keywords", $keyword);
        $this->db->where("userid", $userid);
        $this->db->where("status", 'checked');
        $query = $this->db->get('doc_keyword');
        $id = $query->row_array();

        return $id['id'];
    }

    public function checkDuplicate($userid, $keyword)
    {

        $this->db->select("*");
        $this->db->where("keywords", $keyword);
        $this->db->where("userid", $userid);
        $result = $this->db->get('doc_keyword');
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }

    }

    //getting list
    public function getKEYWordList($key, $userid, $counter)
    {
        $data = array();
        $offset = 0;
        $limit = 10;
        if ($counter) {
            $offset = $counter * $limit;
        }

        $this->db->select('UK.*');
        $this->db->where('UK.userid', $userid);
        $this->db->where('DK.status', "checked");
        $this->db->like('UK.keyword', $key);
        $this->db->order_by("UK.id", "DESC");
        $this->db->limit($limit, $offset);
        $this->db->join('doc_keyword as DK', 'DK.keywords = UK.keyword');
        $query = $this->db->get('updatedword as UK');
        $data = $query->result_array();
        $query->free_result();
        return $data;
    }

    public function getSearchedDocsByUSERID($userid)
    {
        $query = "SELECT DK.*,count(Uk.id) as count from doc_keyword as DK JOIN updatedword as Uk ON (DK.keywords = Uk.keyword) where DK.userid = '" . $userid . "' GROUP BY DK.keywords LIMIT 0 , 15";
        $result = $this->db->query($query);

        $value = $result->result_array();
        return $value;
    }
    public function getkeyresults($userid)
    {
        $query = "SELECT * from updatedword where userid = '" . $userid . "'";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function gekeywordresultsBykeyword($userid, $keyword)
    {
        $query = "SELECT * from updatedword where userid = '" . $userid . "' AND keyword= '" . $keyword . "' ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function deleteKeywordBYID($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('updatedword');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }

        return 'Successfully Deleted';
    }

}
