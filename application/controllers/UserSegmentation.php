<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSegmentation extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('M_usersegmentation');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataUserSegmentation'] 	= $this->M_usersegmentation->select_all();

		$data['page'] 		= "User Segmentation";
		$data['titulo'] 		= "Data User Segmentation";
		$data['descripcion'] 	= "Manage Data User Segmentation";

		$data['modal_user_segmentation'] = show_my_modal('modals/modal_user_segmentation', 'usersegmentation', $data);

		$this->template->views('usersegmentation/home', $data);
	}

	

	public function getListData() {
		$data['datagetListData'] = $this->M_usersegmentation->select_all();
		$this->load->view('usersegmentation/list_data', $data);
	}

	public function addUserSegmentation() {
		
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');
		
		$data = $this->input->post();
		
		if ($this->form_validation->run() == TRUE){		
			$data["password_"] = $this->M_usersegmentation->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_usersegmentation->generateHash($data["password"]);		
			$data["username_clean"] = addslashes(sanitize($data["username"]));	
			$data["group_id"] = 1;		
			$data["active"] = 1;
			$userExist = $this->M_usersegmentation->select_by_name($data["username_clean"]);
			if(!$userExist){
				$result = $this->M_usersegmentation->insert($data,"userpie_users");			

				if ($result > 0) {
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Success', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Success - Not Change!!', '20px');
				}
			}
			else{
				$out['status'] = '';
				$out['msg'] = show_err_msg('Error - User Name, Segmentation - Found!!', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update() {
		$data['userdata'] 	= $this->userdata;
		$id 				= trim($_POST['id']);
		$data['dataUserSegmentation'] 	= $this->M_usersegmentation->select_by_id($id);
		$data['dataUserSegmentation']->password_ = $this->M_usersegmentation->encrypt_decrypt('decrypt', $data['dataUserSegmentation']->password_);
		
		echo show_my_modal('modals/modal_update_user_segmentation', 'update-usersegmentation', $data);
	}

	public function updateUserSegmentation() {
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');		
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$data["password_"] = $this->M_usersegmentation->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_usersegmentation->generateHash($data["password"]);
			$result = $result = $this->M_usersegmentation->update($data, array("user_id"=>$data["user_id"]));

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Success', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Success - Not Change!!', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_kota->delete($id);
		
		if ($result > 0) {
			echo show_succ_msg('Data Kota Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Kota Gagal dihapus', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['kota'] = $this->M_kota->select_by_id($id);
		$data['jumlahKota'] = $this->M_kota->total_rows();
		$data['dataKota'] = $this->M_kota->select_by_pegawai($id);

		echo show_my_modal('modals/modal_detail_kota', 'detail-kota', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_kota->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "ID"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "Nama Kota");

		$rowCount = 2;
		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Kota.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Kota.xlsx', NULL);
	}

	public function import() {
		$this->form_validation->set_rules('excel', 'File', 'trim|required');

		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File harus diisi');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('excel')){
				$error = array('error' => $this->upload->display_errors());
			}
			else{
				$data = $this->upload->data();
				
				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');

				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

				$inputFileName = './assets/excel/' .$data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$check = $this->M_kota->check_nama($value['B']);

						if ($check != 1) {
							$resultData[$index]['nama'] = ucwords($value['B']);
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_kota->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Kota Berhasil diimport ke database'));
						redirect('Kota');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Kota Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Kota');
				}

			}
		}
	}
}

/* End of file UserSegmentation.php */
/* Location: ./application/controllers/UserSegmentation.php */