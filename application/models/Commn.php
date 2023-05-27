<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Commn extends CI_Model
{
    public $Modal;

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_row_data($table,$where){
        $this->db->where($where);
        $result = $this->db->get($table);
        $result = $result->row();  
        return $result; 
    }

    public function select_get_row_data($table,$where,$select){
        if(!empty($select)){
            $this->db->select($select);
        }
        $this->db->where($where);
        $result = $this->db->get($table);

        $result = $result->row(); 
        
        return $result; 
    }

    public function get_row($table,$where){
        $this->db->where($where);
        $result = $this->db->get($table);
        $num_row = $result->num_rows();
        return $num_row;
        // if($num_row == 1){
        //  $result = $result->row();  
        //  return $result; 
        // }
    }
    
    public function insert_data($table, $data){
        $this->db->insert($table, $data);
        return "1";
    }
    
    public function insert_batch($table, $data){
        $this->db->insert_batch($table, $data);
        return "1";
    }
    
    public function update_data($table, $data, $where){
        $this->db->where($where);
        $this->db->update($table, $data);
        return 1;
    }
    
    public function delete_data($table, $where){
        $this->db->where($where);
        $this->db->delete($table);
        return 1;
    }
    
    public function search($table, $search){
        $this->db->like($search);
        $res = $this->db->get($table)->result();
        return $res;
    }
    
    public function all_records($table,$select){
        if(!empty($select)){
            $this->db->select($select);
        }
        return $this->db->get($table)->result();
    }
    public function order_by_all_records($table,$select,$order_key,$order_type){
        if(!empty($select)){
            $this->db->select($select);
        }
        if(!empty($order_key)){
            $this->db->order_by($order_key, $order_type);
        }
        return $this->db->get($table)->result();
    }
    public function where_all_records($table,$where,$select){
        if(!empty($select)){
            $this->db->select($select);
        }
        $this->db->where($where);
        return $this->db->get($table)->result();
    }
    
    public function get_product($id){
        // `products`.*, `product_variants`.*, `product_variant_options`.*, `skus`.*, `skus_product_variant_options`.*
        $this->db->select('product_variant_options.id as variant_id, products.id as product_id,  product_variants.name as option_name, product_variant_options.name as variant_name,skus.sku as sku, skus.price as price');
        $this->db->join('product_variants', 'product_variants.product_id = products.id');
        $this->db->join('product_variant_options', 'product_variant_options.product_variant_id = product_variants.id');
        $this->db->join('skus', 'skus.product_id = product_variant_options.id');
        // $this->db->join('product_images', 'product_images.v_opt_id = product_variant_options.id');
        $this->db->where('products.id',$id);
        return $this->db->get('products')->result();
    }

    public function get_all_product(){

        $this->db->select('*,products.id as product_id, products.name as product_name');
        return $this->db->get('products')->result();
        // $this->db->select(' products.name as product_name, products.cate_id as  cate_id, product_variant_options.id as variant_id, products.id as product_id,  product_variants.name as option_name, product_variant_options.name as variant_name,skus.sku as sku, skus.price as price');
        // $this->db->join('product_variants', 'product_variants.product_id = products.id');
        // $this->db->join('product_variant_options', 'product_variant_options.product_variant_id = product_variants.id');
        // $this->db->join('skus', 'skus.product_id = product_variant_options.id');
        // return $this->db->get('products')->result();
    }

    public function get_options($id){
        $this->db->select('product_variant_options.id as variant_id,product_variants.name as option_name, product_variant_options.name as variant_name');
        $this->db->join('product_variant_options', 'product_variant_options.product_variant_id = product_variants.id');
        $this->db->where('product_variants.product_id',$id);
        return $this->db->get('product_variants')->result();
    }


    public function shopify_dashboard_date($dashboard_date){
         $this->db->select('*');
         $this->db->from('shopify_orders');
         $this->db->where('DATE(order_date) =', $dashboard_date);
         return $this->db->get()->result();
    }
    
    public function top_cities(){
        $this->db->select('id, order_city, count(*) as total_no_orders, count(1) as total_orders');
        $this->db->from('shopify_orders');
        $this->db->limit(5);
        $this->db->order_by('id','asc');
        $this->db->group_by('order_city');
        return $this->db->get()->result();
    }
    
    public function order_history($order_history_type,$date_start,$date_end){
        $where= array();
        if($order_history_type == "sales"){
            $where = array('financial_status' => 'paid', 'order_status' => "fulfilled");
        }else{
            // $where = array('financial_status' => 'paid', 'order_status' => "fulfilled");
        }
        $this->db->select('COUNT(*) AS total_orders, DAYNAME(order_date) as day');
        $this->db->from('shopify_orders');
        // $this->db->where('DATE(order_date) >=', $date_start);
        $this->db->where('DATE(order_date) >=', $date_start);
        $this->db->where('DATE(order_date) <=', $date_end);
        $this->db->where($where);
        $this->db->group_by('DAYNAME(order_date)');
        return $this->db->get()->result();
    }
    
    public function order_platform($first_date,$last_date){
        $this->db->select('COUNT(*) AS total_orders');
        $this->db->from('shopify_orders');
        // $this->db->where('DATE(order_date) >=', $date_start);
        $this->db->where('DATE(order_date) >=', $first_date);
        $this->db->where('DATE(order_date) <=', $last_date);
        return $this->db->get()->row();        
    }
    
    public function get_filter_orders($table,$order_status,$payment_method){
         $this->db->select('*');
         if(isset($order_status) && !empty($order_status)){
            $this->db->where_in('order_status',$order_status);
         }
         if(isset($payment_method) && !empty($payment_method)){
            $this->db->where_in('payment_mode',$payment_method);
         }
         return $this->db->get($table)->result(); 
    }
}
?>