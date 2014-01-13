<?php
class Ebook_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all_titles()
    {
    	$query = $this->db->get('title');
		
    	if($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    
	}
	
	function get_characters($title_id)
    {
    	$this->db->where('title_id', $title_id);
    	$query = $this->db->get('characters');
		
    	if($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    
	}
}