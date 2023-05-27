<?php 
function get_field($table,$where,$select){
    $ci=& get_instance();
	if(!empty($select)){
		$ci->db->select($select);
	}
	$ci->db->where($where);
	return $ci->db->get($table)->row();
}
function get_all_field($table,$where,$select,$order_name,$order_type){
    $ci=& get_instance();
	if(!empty($select)){
		$ci->db->select($select);
	}
	if(!empty($order_name)){
		$ci->db->order_by($order_name,$order_type);
	}
	$ci->db->where($where);
	return $ci->db->get($table)->result();
}
?>