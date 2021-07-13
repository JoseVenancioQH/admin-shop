<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_broken extends CI_Model {
	public function select_all() {
		$this->db->select('*');
		$this->db->from('productfail');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM kota WHERE id = '{$id}'";

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

	public function insert($data) {
		$textPassWord = $data["password"];
		$data["password"] = $this->generateHash($data["password"]);
		$data["password_"] = $this->encrypt_decrypt('encrypt', $textPassWord);
		//$data["passwordText"] = $this->encrypt_decrypt('decrypt', $data["password_"]);
		
		$this->db->insert('userpie_users', $data);
		
		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('userpie_users', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data,$where) {	
		$this->db->where($where);
   		$this->db->update('productfail',$data); 
		return $this->db->affected_rows();
	}

	public function update_($data) {
		$sql = "UPDATE kota SET nama='" .$data['kota'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM kota WHERE id='" .$id ."'";

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