<?php

class Common_model extends CI_Model {

	// +++++++ For Selection Of All Row +++++++++
	function selectAll($table)
	{
		$this->db->select('*');
		$this->db->from($table);		
		$query=$this->db->get();
		return $query->result();
	} 

	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	function updateData($table,$data,$where)
	{
		$this->db->update($table,$data,$where);			
	}
	
	function deleteData($table,$where)
	{	
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	// +++++++ For Select Where (multiple condition in array) +++++++++
	function selectWhere($table,$where)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query=$this->db->get();
		return $query->result();
	}

	// +++++++ For Select Where In (array) +++++++++
	function selectWhereIn($table,$column,$wherein)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where_in($column,$wherein);
		$query=$this->db->get();
		return $query->result();
	}
	// +++++++ For Select Join Where+++++++++
	function selectJoinWhere($table1,$column1,$table2,$column2,$where)
	{
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, $table1.'.'.$column1.' = '.$table2.'.'.$column2);
		$this->db->where($where);
		$query=$this->db->get();
		return $query->result();
	}
	// +++++++ Select max Table +++++++++++++++++
	function selectMax($table,$column)
	{
		$this->db->select_max($column);
		$query = $this->db->get($table); 
		return $query->result();
	}
	// +++++++ Select min Table +++++++++++++++++
	function selectMin($table,$column)
	{
		$this->db->select_min($column);
		$query = $this->db->get($table); 
		return $query->result();
	}	
	
	function login_check($data)
	{		
		$this->db->select('CD_USER_ID,CD_GROUP_ID,NM_USER_FULLNAME,FL_USER_ACTIVE,CD_PARENT_ID','NM_USER_EMAIL');
		$this->db->from('tbl_user');
		$this->db->where('NM_USER_EMAIL',$data['user']);
		$this->db->where('USER_PASSWORD',$data['pass']);
		$this->db->where('CD_GROUP_ID',1);
		$query=$this->db->get();
		return $query->result();
	}
	//++++++++ User log ++++++++++++++++++++++++
	function userLog($user_id)
	{
		if ($this->agent->is_browser())
		{
			$browser = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$browser = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
			$browser = $this->agent->mobile();
		}
		else
		{
			$browser = 'Unidentified';
		}
		$platform = $this->agent->platform();
		$ip_address = $_SERVER['REMOTE_ADDR'];

		$data=array(
			'CD_USER_ID'=>$user_id,
			'SN_IPADDRESS'=>$ip_address,
			'SN_BROWSER'=>$browser,
			'SN_OS'=>$platform,
			'TS_CREATED_AT'=>date('Y-m-d H:i:s'),
		);
		$this->db->insert('tbl_user_log',$data);
			//return $this->db->insert_id();
	}     

	function getCategory($parent_id) {
		$query = $this->db->query("SELECT c.category_id,c.category_name,cd.category_slug 
			FROM tbl_category c
			join tbl_category_description cd on cd.category_id=c.category_id
			where c.parent_category ='".$parent_id."' and c.category_status='active'");
		return $query->result();
	}	
}
?>