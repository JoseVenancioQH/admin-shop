<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefactorImageShop extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('M_refactorimageshop');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataRefactorImageShop'] 	= $this->M_refactorimageshop->select_all();
		//$data['categorys'] 	= file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST["data"]);

		$data['page'] 		= "Rafactor Image Shop";
		$data['titulo'] 		= "Data Refactor Image Shop";
		$data['descripcion'] 	= "Manage Data Refactor Image Shop";

		$url = "/api/categorias";
		$data['categorias']  = json_decode(curl($url));
		//file_put_contents("categorias.json",json_encode($data['categorias']));
		$url = "/api/marcas";
		$data['marcas']  = json_decode(curl($url));

		$data['modal_image'] = show_my_modal('modals/modal_image', 'modalimage', $data);

		$this->template->views('refactorimageshop/home', $data);
	}	

	public function uploadImageShop(){
		ini_set("allow_url_fopen", 1);
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		$result = file_get_contents_curl(rtrim(trim($urlshop),"/")."/api-shop.php",$_REQUEST["data"]);
		//var_dump($result);
		/* var_dump(base_url()."images/".$_REQUEST["data"]["sku"].".jpg");		
		exit; */
		//if ($result > 0) {		
			//////////////////////////////////////////////////////////////////
			//$urlDMServer = "../images/".$_REQUEST["data"]["sku"].".jpg";
			//if(file_exists($urlDMServer)){unlink($urlDMServer);}
			/////////////////////////////////////////////////////////////////

			//$result = file_get_contents($_REQUEST["data"]['pImgen']);
			//var_dump($data);
			//file_put_contents($urlDMServer, $result);	
			$postdata = array("sku"=>$_REQUEST["data"]["sku"],"url"=>$_REQUEST["data"]["pImgen"]);	
			$result = file_get_contents_curl("/api/setImagenesSKU",$postdata);
			
			$out['status'] = $result;
			$out['msg'] = show_succ_msg('Success', '20px');
		//} else {
			/* $out['status'] = '';
			$out['msg'] = show_err_msg('Error - Not Uplaod Image!!', '20px'); */
		//}
		echo json_encode($out);
	}	
	
	public function getCountData(){			
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST["data"]);
		var_dump($result);
		exit;
		$request = json_decode($result);
		$data['urlshop'] = rtrim(trim($_REQUEST['urlshop']),"/")."/";
		$data['datagetListData'] = $request->data;
		$data['datagetListDataLength'] = $request->length;
		$data['datagetListDataCount'] = $request->count;
		echo json_encode($data);
		//$this->load->view('refactorimageshop/list_data', $data);
	}	

	public function getListCategory(){			
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST);		
		$request = json_decode($result);
		$data['datagetListData'] = $request;
		$this->load->view('refactorimageshop/list_category', $data);
	}

	public function getListManufacturer(){			
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST);		
		$request = json_decode($result);
		$data['datagetListData'] = $request;
		$this->load->view('refactorimageshop/list_manufacturer', $data);
	}	

	public function getListData(){		
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		$result = file_get_contents_curl(rtrim(trim($urlshop),"/")."/api-shop.php",$_REQUEST["data"]);	
		//$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST["data"]);
		/* var_dump($result);
		exit; */
		$request = json_decode($result);
		$data['urlshop'] = rtrim(trim($_REQUEST['urlshop']),"/")."/";
		$data['datagetListData'] = $request->data;
		$data['datagetListDataLength'] = $request->length;
		$data['datagetListDataCount'] = $request->count;
		$this->load->view('refactorimageshop/list_data', $data);
	}	

	public function addRefactorImageShop() {
		
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');
		
		$data = $this->input->post();
		
		if ($this->form_validation->run() == TRUE){		
			$data["password_"] = $this->M_refactorimageshop->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_refactorimageshop->generateHash($data["password"]);			
			$result = $this->M_refactorimageshop->insert($data,"userpie_users");			

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

	public function update() {
		$data['userdata'] 	= $this->userdata;
		$id 				= trim($_POST['id']);
		$data['dataUserSegmentation'] 	= $this->M_refactorimageshop->select_by_id($id);
		$data['dataUserSegmentation']->password_ = $this->M_refactorimageshop->encrypt_decrypt('decrypt', $data['dataUserSegmentation']->password_);
		
		echo show_my_modal('modals/modal_update_refactor_image_shop', 'update-refactorimageshop', $data);
	}

	public function updateRefactorImageShop() {
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');		
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$data["password_"] = $this->M_refactorimageshop->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_refactorimageshop->generateHash($data["password"]);
			$result = $result = $this->M_refactorimageshop->update($data, array("user_id"=>$data["user_id"]));

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

/* End of file refactorimageshop.php */
/* Location: ./application/controllers/refactorimageshop.php */