<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_matchpricesshop extends CI_Model {
	public function select_all() {
		$this->db->select('*');
		$this->db->from('userpie_users');
		$this->db->order_by('user_id','desc');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_shop_ingrama() {
		$this->db->select('*');
		$this->db->from('shop_shop_ingram');
		$this->db->where('update',null);

		$data = $this->db->get();

		return $data->result();
	}

	public function selectIngram($sku){
		$this->db->select('*');
		$this->db->from('shop_shop_ingram');
		$this->db->where('sku',$sku);

		$data = $this->db->get();
	    //var_dump($this->db->last_query());
		return $data->result();
	}

	public function select_advance($label=null){
		$this->db->select('*');
		$this->db->from('map_advance');
		if(!is_null($label))$this->db->where('label',$label);

		$data = $this->db->get();
	    //var_dump($this->db->last_query());
		return $data->result();
	}
	

	public function select_match_shop_vs_server($data) {		
		
		$this->db->select('
			if(((s.precio_ingram-d.precio)<='.$data->margediff_shopdm.'),\'1\',\'0\') as match_prices_shopvsdm,
			"none" as match_prices_shopvsingram,
			if(((s.stock-d.disponibilidad)<=0),\'1\',\'0\') as match_stock,
			if(s.category_id=d.id_categoria,\'1\',\'0\') as match_category,
			if(s.manufacturer_id=d.id_fabricante,\'1\',\'0\') as match_manufacturer,
			if(s.status=d.isactive,\'1\',\'0\') as match_active,
			s.status as shop_active,
			d.isactive as dm_active,
			if(s.product_name is null or s.product_name = \'\',\'none\', s.product_name) as name,
			if(s.model is null or s.model = \'\',\'none\', s.model) as modelo,
			if(s.sku is null or s.sku = \'\',\'none\',s.sku) as sku,
			if(s.precio_ingram is null or s.precio_ingram = \'\',\'0.00\',s.precio_ingram) as ShopPrecio,
			if(s.precio_ingram is not null and s.precio_ingram > 0,\'1\',\'0\') as ShopPrecioMayor0,
			if(d.precio is null or d.precio = \'\',\'0.00\',d.precio) as DMPrecio,
			if(d.precio is not null and d.precio > 0,\'1\',\'0\') as DMPrecioMayor0,
			"none" as IngramPrecio,
			if(s.utilidad_por_producto is null or s.utilidad_por_producto = \'\',\'0.00\',s.utilidad_por_producto) as UtilidadProducto,			
			if(s.utilidad_por_categoria is null or s.utilidad_por_categoria = \'\',\'0.00\',s.utilidad_por_categoria) as UtilidadCategoria,
			if(s.utilidad_por_marca is null or s.utilidad_por_marca = \'\',\'0.00\',s.utilidad_por_marca) as UtilidadMarca,
			if(s.utilidad_por_tienda is null or s.utilidad_por_tienda = \'\',\'0.00\',s.utilidad_por_tienda) as UtilidadTienda,
			if(s.precio_tienda_con_utilidad is null or s.precio_tienda_con_utilidad = \'\',\'0.00\',s.precio_tienda_con_utilidad) as ShopUtilidadPrecio,			
			if(s.precio_tienda_con_utilidad_con_iva is null or s.precio_tienda_con_utilidad_con_iva = \'\',\'0.00\',s.precio_tienda_con_utilidad_con_iva) as ShopUtilidadPrecioIva,
			if(s.stock is null or s.stock = \'\',\'0.00\',s.stock) as ShopStock,
			if(s.stock is not null and s.stock >0,\'1\',\'0\') as ShopStockMayor0,
			if(d.disponibilidad is null or d.disponibilidad = \'\',\'0.00\',d.disponibilidad) as DMStock,
			if(d.disponibilidad is not null and d.disponibilidad > 0,\'1\',\'0\') as DMStockMayor0,			
			"none" as IngramStock,
			"none" as IngramCheck,
			if(s.category_name is null or s.category_name = \'\',\'none\', s.category_name) as CategoryShop,
			if(d.categoria is null or d.categoria = \'\',\'none\', d.categoria) as CategoryDM,
			if(s.manufacturer_name is null or s.manufacturer_name = \'\',\'none\', s.manufacturer_name) as ManufacturerShop,
			if(d.marca is null or d.marca = \'\',\'none\', d.marca) as ManufacturerDM,
			if(s.category_id is null or s.category_id = \'\',\'none\', s.category_id) as CategoryShopID,
			if(d.id_categoria is null or d.id_categoria = \'\',\'none\', d.id_categoria) as CategoryDMID,
			if(s.manufacturer_id is null or s.manufacturer_id = \'\',\'none\', s.manufacturer_id) as ManufacturerShopID,
			if(d.id_fabricante is null or d.id_fabricante = \'\',\'none\', d.id_fabricante) as ManufacturerDMID,
			"" as Action
		');
		$this->db->from('shop_shop as s');
		$this->db->join('shop_dmserver as d','s.sku = d.sku','left');
		$data = $this->db->get();
		//var_dump($this->db->last_query());
		return $data->result();
	}

	public function select_match_server_vs_shop() {		
		$this->db->select('
			if(s.product_name is null or s.product_name = \'\',\'none\', s.product_name) as name,
			if(s.model is null or s.model = \'\',\'none\', s.model) as modelo,
			if(s.sku is null or s.sku = \'\',\'none\',s.sku) as sku,
			if(s.precio_ingram is null or s.precio_ingram = \'\',\'0.00\',s.precio_ingram) as ShopPrecio,
			if(d.precio is null or d.precio = \'\',\'0.00\',d.precio) as DMPrecio,
			"none" as IngramPrecio,
			if(s.utilidad_por_producto is null or s.utilidad_por_producto = \'\',\'0.00\',s.utilidad_por_producto) as UtilidadProducto,			
			if(s.utilidad_por_categoria is null or s.utilidad_por_categoria = \'\',\'0.00\',s.utilidad_por_categoria) as UtilidadCategoria,
			if(s.utilidad_por_marca is null or s.utilidad_por_marca = \'\',\'0.00\',s.utilidad_por_marca) as UtilidadMarca,
			if(s.utilidad_por_tienda is null or s.utilidad_por_tienda = \'\',\'0.00\',s.utilidad_por_tienda) as UtilidadTienda,
			if(s.precio_tienda_con_utilidad is null or s.precio_tienda_con_utilidad = \'\',\'0.00\',s.precio_tienda_con_utilidad) as ShopUtilidadPrecio,			
			if(s.precio_tienda_con_utilidad_con_iva is null or s.precio_tienda_con_utilidad_con_iva = \'\',\'0.00\',s.precio_tienda_con_utilidad_con_iva) as ShopUtilidadPrecioIva,
			if(s.stock is null or s.stock = \'\',\'0.00\',s.stock) as ShopStock,
			if(d.disponibilidad is null or d.disponibilidad = \'\',\'0.00\',d.disponibilidad) as DMStock,			
			"none" as IngramStock,
			if(s.category_name is null or s.category_name = \'\',\'none\', s.category_name) as CategoryShop,
			if(d.categoria is null or d.categoria = \'\',\'none\', d.categoria) as CategoryDM,
			if(s.manufacturer_name is null or s.manufacturer_name = \'\',\'none\', s.manufacturer_name) as ManufacturerShop,
			if(d.marca is null or d.marca = \'\',\'none\', d.marca) as ManufacturerDM,
			if(s.category_id is null or s.category_id = \'\',\'none\', s.category_id) as CategoryShopID,
			if(d.id_categoria is null or d.id_categoria = \'\',\'none\', d.id_categoria) as CategoryDMID,
			if(s.manufacturer_id is null or s.manufacturer_id = \'\',\'none\', s.manufacturer_id) as ManufacturerShopID,
			if(d.id_fabricante is null or d.id_fabricante = \'\',\'none\', d.id_fabricante) as ManufacturerDMID,
			"" as Action
		');
		$this->db->from('shop_dmserver as d');
		$this->db->join('shop_shop as s','s.sku = d.sku','left');
		$data = $this->db->get();
		//var_dump($this->db->last_query());
		return $data->result();
	}

	public function select_categorias() {
		$this->db->select('category_id');
		$this->db->from('shop_shop');
		$this->db->where('status',1);
		$this->db->group_by("category_id");
		$data = $this->db->get();
		//var_dump($this->db->last_query());
		return $data->result();
		/* $data = $this->db->query($sql);
		return $data->row(); */
	}

	public function select_marcas() {
		$this->db->select('manufacturer_id');
		$this->db->from('shop_shop');
		$this->db->where('status',1);
		$this->db->group_by("manufacturer_id");
		$data = $this->db->get();
		//var_dump($this->db->last_query());
		return $data->result();
		/* $data = $this->db->query($sql);
		return $data->row(); */
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM userpie_users WHERE user_id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_pegawai($id) {
		$sql = " SELECT pegawai.id AS id, pegawai.nama AS pegawai, pegawai.telp AS telp, kota.nama AS kota, kelamin.nama AS kelamin, posisi.nama AS posisi FROM pegawai, kota, kelamin, posisi WHERE pegawai.id_kelamin = kelamin.id AND pegawai.id_posisi = posisi.id AND pegawai.id_kota = kota.id AND pegawai.id_kota={$id}";

		$data = $this->db->query($sql);

		return $data->result();
	}

	/* public function insert($data) {
		$sql = "INSERT INTO userpie_users VALUES('','" .$data['kota'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	} */

	function encrypt_decrypt($action, $string)
	{
		$output = false;
		
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';
		
		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
		// warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		
		if ($action == 'encrypt')
		{
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else
		{
			if ($action == 'decrypt')
			{
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}
		}
		
		return $output;
	}

	function generateHash($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, 25);
		}
		else
		{
			$salt = substr($salt, 0, 25);
		}
	
		return $salt . sha1($salt . $plainText);
	}

	public function insert($data,$table) {		
		$this->db->insert($table, $data);		
		return $this->db->affected_rows();
	}

	public function insert_batch($data,$table="userpie_users") {
		$this->db->insert_batch($table, $data);		
		return $this->db->affected_rows();
	}
	public function update($data,$where) {	
		$this->db->where($where);
   		$this->db->update('userpie_users',$data); 
		return $this->db->affected_rows();
	}
	public function update_batch($table,$data,$where) {	
		$this->db->where($where);
   		$this->db->update($table,$data); 
		return $this->db->affected_rows();
	}

	public function update_($data) {
		$sql = "UPDATE kota SET nama='" .$data['kota'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function deleteAll($table, $where="") {
		$sql = "DELETE FROM ".$table." ".$where;

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM kota WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete_row($table,$field,$value) {
		$sql = "DELETE FROM ".$table." WHERE ".$field."='" .$value ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama', $nama);
		$data = $this->db->get('kota');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('kota');

		return $data->num_rows();
	}
}

/* End of file M_usersegmentation.php */
/* Location: ./application/models/M_usersegmentation.php */