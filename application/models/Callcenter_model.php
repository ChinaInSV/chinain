<?php
class Callcenter_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->CallcenterDB=$this->load->database('callcenter', TRUE);
	}
	function save($table,$data,$return=false){
		if($this->CallcenterDB->insert($table, $data)){
			if($return):
				return $this->CallcenterDB->insert_id();
			else:
				return true;
			endif;
		}
	}
	
	function savebatch($table,$data){
		if($this->CallcenterDB->insert_batch($table, $data))
			return true;
	}
	
	function delete($table,$field,$value){
		$this->CallcenterDB->where($field, $value);
		if($this->CallcenterDB->delete($table))
			return true;	
	}

    function get($type,$table,$param = '*',$wheres='',$orders = '',$likes = '', $joins = '',$limits = '',$groups = '',$orlikes='',$whereStr=''){
        $this->CallcenterDB->select($param);
        $this->CallcenterDB->from($table);
		if($wheres != ''):
			foreach($wheres as $field => $value):
				$this->CallcenterDB->where($field,$value);
			endforeach;
		endif;
		if($joins != ''):
			foreach($joins as $field => $value):
				$value = explode(',',$value);
				if(isset($value[1])){
					$this->CallcenterDB->join($field,$value[0],$value[1]);
				}else{
					$this->CallcenterDB->join($field,$value[0]);
				}
			endforeach;
		endif;
		if($orders != ''):
			foreach($orders as $field => $value):
				$this->CallcenterDB->order_by($field,$value);
			endforeach;
		endif;
		if($likes != ''):
			foreach($likes as $field => $value):
				$this->CallcenterDB->like($field,$value);
			endforeach;
		endif;
		if($orlikes != ''):
			foreach($orlikes as $field => $value):
				$this->CallcenterDB->or_like($field,$value);
			endforeach;
		endif;
		if($limits != ''):
			if(is_array($limits)):
				foreach($limits as $field => $value):
					$this->CallcenterDB->limit($field,$value);
				endforeach;
			else:
				$this->CallcenterDB->limit($limits); 
			endif;
			
		endif;
		if($groups != ''):
			$this->CallcenterDB->group_by($groups); 
		endif;
		if($whereStr != ''){
			$this->CallcenterDB->where($whereStr);
		}
		
        $query = $this->CallcenterDB->get();
    
        if($query->num_rows() > 0){
			if($type == "q"){
				$result= $query->result();				
			}else{
				$result= $query->num_rows();
			}
            return $result;
        }
    }
	
	function update($table,$data,$where){
		$this->CallcenterDB->where($where);
		
		if($this->CallcenterDB->update($table, $data))
			return true;
	}
	function aumentar($table,$where,$value,$field,$cant){
		$this->CallcenterDB->where($where, $value);
		$this->CallcenterDB->set($field, $field.'+'.$cant, FALSE);
		$this->CallcenterDB->update($table);
	}
	function disminuir($table,$where,$value,$field,$cant){
		$this->CallcenterDB->where($where, $value);
		$this->CallcenterDB->set($field, $field.'-'.$cant, FALSE);
		$this->CallcenterDB->update($table);
	}
	function sql_custom($sql){
		$query = $this->CallcenterDB->query($sql);
        
        if($query->num_rows() > 0){
            $result= $query->result();
            return $result;
        }
	}
}
?>