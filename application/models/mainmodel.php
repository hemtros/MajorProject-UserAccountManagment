<?php
class Mainmodel extends CI_Model {

    var $username   = '';
    var $password= '';
    var $phone    = '';
    var $monitored_keyword = '';
    var $valid = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database() ;

    }
    
    
    function registration($username,$password,$phone)
    {
        $data = array(
            'username' => $username ,
            'password' => $password ,
            'phone' => $phone
            );
        $this->db->insert('account', $data);
        return $this->db->affected_rows();

    }

    function validate($username)
    {
        $data = array('valid' => 1);

        $this->db->where('username', $username);
        $this->db->update('account', $data); 
        return $this->db->affected_rows();
    }

    function monitored_keyword($username,$password)
    {
        $this->db->select('monitored_keyword');
        $query = $this->db->get_where('account', array('username' => $username,'password' => $password));
        if ($this->db->affected_rows() !== -1)
        {
            $row = $query->result();
            return $row;
        }
        else
        {
            return -1;
        }
        


    }

    function set_monitored_keyword($username,$password,$new_keyword)
    {
        $data = $this->monitored_keyword($username,$password);
        $current_keywords = $data[0]->monitored_keyword;
        if ($current_keywords  == "")
        {
            $new_monitored_keywords = $new_keyword;
        }
        else
        {
            $new_monitored_keywords = $current_keywords.",".$new_keyword;
        }
        $data = array('monitored_keyword' => $new_monitored_keywords);

        $this->db->where('username', $username);
        $this->db->update('account', $data); 
        return $this->db->affected_rows();
    }

    

}
?>