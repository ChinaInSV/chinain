<?php
class Generic_model extends CI_Model{
	function save($table,$data,$return = false){
		if($this->db->insert($table, $data)){
			if($return):
				return $this->db->insert_id();
			else:
				return true;
			endif;
		}
	}
	
	function savebatch($table,$data){
		if($this->db->insert_batch($table, $data))
			return true;
	}
	
	function delete($table,$field,$value){
		$this->db->where($field, $value);
		if($this->db->delete($table))
			return true;	
	}

    function get($type,$table,$param = '*',$wheres='',$orders = '',$likes = '', $joins = '',$limits = '',$groups = '',$orlikes='',$whereStr=''){
        $this->db->select($param);
        $this->db->from($table);
		if($wheres != ''):
			foreach($wheres as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		if($joins != ''):
			foreach($joins as $field => $value):
				$value = explode(',',$value);
				if(isset($value[1])){
					$this->db->join($field,$value[0],$value[1]);
				}else{
					$this->db->join($field,$value[0]);
				}
			endforeach;
		endif;
		if($orders != ''):
			foreach($orders as $field => $value):
				$this->db->order_by($field,$value);
			endforeach;
		endif;
		if($likes != ''):
			foreach($likes as $field => $value):
				$this->db->like($field,$value);
			endforeach;
		endif;
		if($orlikes != ''):
			foreach($orlikes as $field => $value):
				$this->db->or_like($field,$value);
			endforeach;
		endif;
		if($limits != ''):
			if(is_array($limits)):
				foreach($limits as $field => $value):
					$this->db->limit($field,$value);
				endforeach;
			else:
				$this->db->limit($limits); 
			endif;
			
		endif;
		if($groups != ''):
			$this->db->group_by($groups); 
		endif;
		if($whereStr != ''){
			$this->db->where($whereStr);
		}
		
        $query = $this->db->get();
    
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
		$this->db->where($where);
		
		if($this->db->update($table, $data))
			return true;
	}
	function aumentar($table,$where,$value,$field,$cant){
		$this->db->where($where, $value);
		$this->db->set($field, $field.'+'.$cant, FALSE);
		$this->db->update($table);
	}
	function disminuir($table,$where,$value,$field,$cant){
		$this->db->where($where, $value);
		$this->db->set($field, $field.'-'.$cant, FALSE);
		$this->db->update($table);
	}
	function sql_custom($sql){
		$query = $this->db->query($sql);
        
        if($query->num_rows() > 0){
            $result= $query->result();
            return $result;
        }
	}
}
?>