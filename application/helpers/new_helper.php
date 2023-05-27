<?php 
function get_field($table,$where,$select){
    $ci=& get_instance();
	if(!empty($select)){
		$ci->db->select($select);
	}
	$ci->db->where($where);
	return $ci->db->get($table)->row();
}
function get_all_field($table,$where,$select){
    $ci=& get_instance();
	if(!empty($select)){
		$ci->db->select($select);
	}
	$ci->db->where($where);
	return $ci->db->get($table)->result();
}
?>