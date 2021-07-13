<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronWP extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('M_matchpricesshop');
		$this->load->model('M_usersegmentation');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataMatchPricesShop'] 	= $this->M_matchpricesshop->select_all();		

		$data['page'] 		= "Cron WP";
		$data['titulo'] 		= "Cron WP";
		$data['descripcion'] 	= "Cron WP";

		//$data['modal_image'] = show_my_modal('modals/modal_image', 'modalimage', $data);
		
		$this->template->views('cronwp/home', $data);
	}	

	public function map_advance(){
		$result = $this->M_matchpricesshop->select_advance();
		var_dump($result);
		$shop=0;$dm=0;$ingram=0;
		foreach($result as $element){
			if($element->label=="shop"){$shop=($element->total/$element->avance)*100;}
			if($element->label=="dm"){$dm=($element->total/$element->avance)*100;}
			if($element->label=="ingram"){$ingram=($element->total/$element->avance)*100;}
		}
		$advance =array(
			"shop"=>$shop,
			"dm"=>$dm,
			"ingram"=>$ingram
		);
		echo json_encode($advance);
	}

	public function uploadImageShop(){
		ini_set("allow_url_fopen", 1);
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST["data"]);
		//var_dump($result);
		/* var_dump(base_url()."images/".$_REQUEST["data"]["sku"].".jpg");		
		exit; */
		//if ($result > 0) {			
			$urlDMServer = "../images/".$_REQUEST["data"]["sku"].".jpg";
			if(file_exists($urlDMServer)){unlink($urlDMServer);}
			//$result = file_get_contents($_REQUEST["data"]['pImgen']);
			//var_dump($data);
			file_put_contents($urlDMServer, $result);			
			$out['status'] = '';
			$out['msg'] = show_succ_msg('Success', '20px');
		//} else {
			$out['status'] = '';
			$out['msg'] = show_err_msg('Error - Not Uplaod Image!!', '20px');
		//}
		echo json_encode($out);
	}	

	public function rootCategory(){
		//buscar imagen//////////////
		/* <div class="col-xs-2 mobile-product-images hidden-lg hidden-md" data-media-id="hideondesktop">
			<img class="img-responsive" src="https://www.imvendorportal.com/prodpictures/30_94609KG_57798786.jpg" onerror="IM.Common.Utilities.setDefaultImageOnError(this, '/_layouts/images/CSDefaultSite/common/no-image-xl.png');" />
		</div> */
		////////////////////////////
		$requestSKU = $this->uri->segment(3);
		$contentIngram = curl("https://mx.ingrammicro.com/Site/ProductDetail?id=".$requestSKU);
		
		$notResult = strpos($contentIngram, "autorizado a ver SKU");		
		$notResult2 = strpos($contentIngram, "problema para obtener los detalles del producto para el SKU");
		$resultado = $contentIngram;
		$pos = strpos($contentIngram, "<div class=\"col-md-8 col-sm-8 blog-main\">");
		$pos2 = strpos($contentIngram, "</div>",$pos);
		$total = $pos2 - $pos;
		$resultado = substr($contentIngram, $pos, $total);
		if(!$notResult&&!$notResult2){			
			$pos_ = strpos($contentIngram, "<div class=\"Top-Sku-VPN-UPC\">");
			$pos2_ = strpos($contentIngram, "</div>",$pos_);
			$pos3_ = strpos($contentIngram, "</div>",$pos2_+7);
			$total_ = $pos3_ - $pos_;
			$resultado2 = substr($contentIngram, $pos_, $total_);

			$pos_marca = strpos($resultado2, "Por:");
			$pos_marca_ = strpos($resultado2, "VPN:",$pos_marca+4);
			$total_marca = $pos_marca_ - $pos_marca;
			$resultado_marca = '-'.substr($resultado2, $pos_marca+4, $total_marca-4).'-';

			/* <img class="img-responsive" id="imgProductDetails"
			$pos_ = strpos($contentIngram, "<div class=\"Top-Sku-VPN-UPC\">");
			$pos2_ = strpos($contentIngram, "</div>",$pos_);
			$pos3_ = strpos($contentIngram, "</div>",$pos2_+7);
			$total_ = $pos3_ - $pos_;
			$resultado2 = substr($contentIngram, $pos_, $total_); */
		}else{
			/* $resultado=""; */$resultado_marca ="";
		}
		
		//$this->load->model('productos_m');
		/* $this->load->model('categorias_m');
		$this->load->model('marcas_m'); */

		$categorias = json_decode(file_get_contents("categorias.json"));
		$marcas = json_decode(file_get_contents("marcas.json"));
		//$producto = $this->productos_m->getBySku($requestSKU);
		//var_dump($producto);

		$selectCategoria="";
		foreach ($categorias as $categoria) {
			if (strpos(strtolower($resultado), strtolower($categoria->nombre))>-1||strpos(strtolower($categoria->nombre), strtolower($resultado))>-1) {
				$selectCategoria .= "<option selected value=\"".$categoria->id."\">".$categoria->nombre."</option>";
			}else{			
				$selectCategoria .= "<option value=\"".$categoria->id."\">".$categoria->nombre."</option>";			
			}
		}

		$selectMarca="";
		foreach ($marcas as $marca) {
			if($pos_marca>-1&&$pos_marca){
				if (strpos(strtolower($resultado_marca), strtolower($marca->nombre))>-1||strpos(strtolower($marca->nombre), strtolower($resultado_marca))>-1) {
					$selectMarca .= "<option selected value=\"".$marca->id."\">".$marca->nombre."</option>";				
				}else{							
					$selectMarca .= "<option value=\"".$marca->id."\">".$marca->nombre."</option>";		
				}	
			}else{
				$selectMarca .= "<option value=\"".$marca->id."\">".$marca->nombre."</option>";
			}		
		}


		


		$MarcaCategoria = '<div class="form-group col-md-6">                   
								<select id="categoria-ingram" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
								<option selected>Select Categoria Tienda</option>'
								.$selectCategoria.  
								'</select>
								<button type="button" onclick="setValueSelect(\'categoria-ingram\',\'categoria-tienda\')" class="btn btn-primary col-md-12">Set Tienda</button>
								<button type="button" onclick="setValueSelect(\'categoria-ingram\',\'categoria-dm\')" class="btn btn-primary col-md-12">Set DM</button>
							</div>							
							<div class="form-group col-md-6">                          
								<select id="marca-ingram" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
								<option selected>Select Marca Tienda</option>'
								.$selectMarca. 
								'</select>
								<button type="button" onclick="setValueSelect(\'marca-ingram\',\'marca-tienda\')" class="btn btn-primary col-md-12">Set Tienda</button>
								<button type="button" onclick="setValueSelect(\'marca-ingram\',\'marca-dm\')" class="btn btn-primary col-md-12">Set DM</button>
							</div>';

		$ingramResult = '
				<div class="form-group col-md-12">                   
					'.$resultado.'
				</div>
				<div class="form-group col-md-12">                   
					'.$resultado2.'
				</div>
		'.$MarcaCategoria;
		
							
		echo $ingramResult;
	}

	public function saveDM(){
		ini_set("allow_url_fopen", 1);
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		$result = file_get_contents_curl("/api/updatePriceStock",$_REQUEST["data"]);
		var_dump($result);
	}

	public function saveTienda(){
		ini_set("allow_url_fopen", 1);
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		$result = file_get_contents_curl(rtrim(trim($urlshop),"/")."/api-shop.php",$_REQUEST["data"]);
		var_dump($result);
	}

	public function saveTiendaNotPrices(){
		set_time_limit(0);
		ini_set("allow_url_fopen", 1);
		$shop = $this->M_matchpricesshop->select_shop_ingrama();
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		foreach($shop as $element){			
			$data = array(
				"sku"=> $element->sku,
				"ShopPrecio"=> $element->precio,
				"ShopStock"=> $element->disponibilidad,
				"categoriatienda"=> $element->id_categoria,
				"marcatienda"=> $element->id_fabricante,
				"type"=> "saveTienda"
			);
			$result = file_get_contents_curl(rtrim(trim($urlshop),"/")."/api-shop.php",(object)$data);
			$this->M_matchpricesshop->update_batch("shop_shop_ingram",array("update"=>1),array("sku"=>$element->sku));
			//var_dump($result);
			//exit;
		}		
	}	

	public function getPriceStockIngram(){
		echo json_encode(checkPriceStockSKU($this->uri->segment(3)));
	}

	public function getDataExample(){			
		$result = file_get_contents(site_url("M_Data.json"));		
		echo $result;
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
		//$this->load->view('matchpricesshop/list_data', $data);
	}	

	public function getListCategory(){			
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST);		
		$request = json_decode($result);
		$data['datagetListData'] = $request;
		$this->load->view('matchpricesshop/list_category', $data);
	}


	public function getListManufacturer(){			
		$result = file_get_contents_curl(rtrim(trim($_REQUEST['urlshop']),"/")."/api-shop.php",$_REQUEST);		
		$request = json_decode($result);
		$data['datagetListData'] = $request;
		$this->load->view('matchpricesshop/list_manufacturer', $data);
	}	

	public function setRegenerateSeg(){
		ini_set("allow_url_fopen", 1);
		$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
		$data = $this->M_usersegmentation->select_by_site($_REQUEST['urlshop']);
		$dataSegmentation = array(
				"user_id"=>$data->user_id,
				"categorias"=>json_encode($this->M_matchpricesshop->select_categorias()),
				"marcas"=>json_encode($this->M_matchpricesshop->select_marcas())
		);
		/* var_dump($dataSegmentation);
		exit; */
		$result = file_get_contents_curl("/api/Regenerate_Seg",(object)$dataSegmentation);
		//var_dump($result);
	}

	public function Advance($label,$total,$progress){
		$advance_exist = $this->M_matchpricesshop->select_advance($label);
		if($advance_exist){
			$this->M_matchpricesshop->update_batch("map_advance",array("total"=>$total,"avance"=>$progress),array("label"=>$label));
		}else{
			$this->M_matchpricesshop->insert(array("label"=>$label,"total"=>$total,"avance"=>$progress),"map_advance");
		}
	}

	public function getListData(){	
		set_time_limit(0);
		//return;
		if($_REQUEST['server']=='true'){			
			$match_net = $this->M_matchpricesshop->select_match_shop_vs_server(
				(object)array(
								"margediff_shopdm"=>$_REQUEST['datadiffshopvsdm']
							  )
			);
			foreach($match_net as $element){
				/* var_dump($element);
				exit; */
				if(
					$element->match_manufacturer==1&&
					$element->match_category==1&&
					$element->match_prices_shopvsdm==0&&
					$element->shop_active==1				
				){
					//$Ingram = checkPriceStockSKU($element->sku);
					$Ingram = (array)$this->M_matchpricesshop->selectIngram($element->sku);		
					/* var_dump($Ingram);	
					exit; */		
					if(isset($Ingram['precio'])&&!is_null($Ingram['precio'])){			
						$element->IngramCheck = 1;
						$element->IngramPrecio = $Ingram['precio'];
						$element->IngramStock = $Ingram['disponibilidad'];
						/* var_dump($Ingram);
						exit; */
						//$this->M_matchpricesshop->insert(array("sku"=>$element->sku,"precio"=>$element->IngramPrecio,"disponibilidad"=>$element->IngramStock),"shop_shop_ingram");
						/* var_dump($element);
						exit; */
					}				
				}
				$element->match_prices_shopvsingram = (abs((float)$element->ShopPrecio-(float)$element->IngramPrecio)<(int)$_REQUEST['datadiffshopvsingram'])?1:0;				

			}
			echo json_encode($match_net);
			exit;
		}		
		
		$request = array(
			  "numproduct"=>$_REQUEST['numproduct'],
			  "SKU"=>$_REQUEST['SKU'],
			  "NameProduct"=>$_REQUEST['NameProduct'],
			  "Model"=>$_REQUEST['Model'],
			  "filtercategory"=>!isset($_REQUEST['filtercategory'])?'':$_REQUEST['filtercategory'],
			  "filtermanufacturer"=>!isset($_REQUEST['filtermanufacturer'])?'':$_REQUEST['filtermanufacturer'],		
			  "filterImageEmpty"=>$_REQUEST['filterImageEmpty'],
			  "filteractive"=>$_REQUEST['filteractive'],
			  "filterprice"=>$_REQUEST['filterprice'],						
			  "type"=>$_REQUEST['type']
		);
		
		
		if($_REQUEST['datashop']=='true'){
			$urlshop = str_replace("http:","https:",$_REQUEST['urlshop']);
			$result = file_get_contents_curl(rtrim(trim($urlshop),"/")."/api-shop.php",$_REQUEST);			
			//var_dump($result);
			if($result){	
				$arrayData = json_decode($result)->data;
				$this->Advance("shop",count($arrayData),0);
				$this->M_matchpricesshop->deleteAll("shop_shop");	
				$count = 0;
				foreach ($arrayData as $item) {
					$count++;
					//var_dump($item);
					$this->M_matchpricesshop->insert((array)$item,"shop_shop");	
					$this->Advance("shop",count($arrayData),$count);			
				}
				$this->M_matchpricesshop->delete_row("map_advance","label","shop");
			}
		}

		if($_REQUEST['datadm']=='true'){
			$data = $this->M_usersegmentation->select_by_site($_REQUEST['urlshop']);	
			$url = "/api/productos_per_client_precio/".$data->user_id;
			$productos = json_decode(curl($url));
			if($productos){								
				$this->Advance("dm",count($productos),0);
				$count = 0;
				$this->M_matchpricesshop->deleteAll("shop_dmserver");		
				foreach ($productos as $producto) {
					$count++;
					$this->Advance("dm",count($productos),$count);
					$this->M_matchpricesshop->insert((array)$producto,"shop_dmserver");				
				}	
				$this->M_matchpricesshop->delete_row("map_advance","label","dm");	
			}				
		}	

		$match_net = $this->M_matchpricesshop->select_match_shop_vs_server((object)array(
					"margediff_shopdm"=>$_REQUEST['datadiffshopvsdm']
				)
		);

		if($_REQUEST['dataingram']=='true'){
			$this->M_matchpricesshop->deleteAll("shop_shop_ingram");
			$this->Advance("ingram",count($match_net),0);
			$count=0;
			foreach($match_net as $element){
				$count++;
				if(
					$element->match_manufacturer==1&&
					$element->match_category==1&&
					$element->match_prices_shopvsdm==0&&
					$element->shop_active==1				
				){
					$Ingram = checkPriceStockSKU($element->sku);			
					if(isset($Ingram['precio'])&&!is_null($Ingram['precio'])){

						$utilidadValue = (
											((float)$element->UtilidadProducto > 0)?$element->UtilidadProducto:
											(
												((float)$element->UtilidadCategoria > 0)?$element->UtilidadCategoria:
												(
													((float)$element->UtilidadMarca > 0)?$element->UtilidadMarca:
													(
														((float)$element->UtilidadTienda > 0)?$element->UtilidadTienda:1
													)
												)
											)
										);

						$utilidad = $utilidadValue>0?((float)$utilidadValue/100):0;				

						$element->IngramCheck = 1;
						$element->IngramPrecio = $Ingram['precio'];
						$element->IngramStock = $Ingram['disponibilidad'];
						$this->M_matchpricesshop->insert(
											array(
												"sku"=>$element->sku,
												"precioI"=>$element->IngramPrecio,
												"precio"=>((float)$element->IngramPrecio*(1+$utilidad)),
												"disponibilidad"=>$element->IngramStock,
												"id_fabricante"=>$element->ManufacturerShopID,
												"id_categoria"=>$element->CategoryShopID,
												),
												"shop_shop_ingram"
												);
						/* var_dump($element);
						exit; */

					}				
				}
				$this->Advance("ingram",count($match_net),$count);
				$element->match_prices_shopvsingram = (abs((float)$element->ShopPrecio-(float)$element->IngramPrecio)<(int)$_REQUEST['datadiffshopvsingram'])?1:0;				
			}
			$this->M_matchpricesshop->delete_row("map_advance","label","ingram");
		}
		echo json_encode($match_net);
	}	

	public function addMatchPricesShop() {
		
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');
		
		$data = $this->input->post();
		
		if ($this->form_validation->run() == TRUE){		
			$data["password_"] = $this->M_matchpricesshop->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_matchpricesshop->generateHash($data["password"]);			
			$result = $this->M_matchpricesshop->insert($data,"userpie_users");			

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
		$data['dataUserSegmentation'] 	= $this->M_matchpricesshop->select_by_id($id);
		$data['dataUserSegmentation']->password_ = $this->M_matchpricesshop->encrypt_decrypt('decrypt', $data['dataUserSegmentation']->password_);
		
		echo show_my_modal('modals/modal_update_refactor_image_shop', 'update-matchpricesshop', $data);
	}

	public function updateMatchPricesShop() {
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'PassWord', 'trim|required');		
		$this->form_validation->set_rules('namecompany', 'Name Company', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$data["password_"] = $this->M_matchpricesshop->encrypt_decrypt('encrypt', $data["password"]);
			$data["password"] = $this->M_matchpricesshop->generateHash($data["password"]);
			$result = $result = $this->M_matchpricesshop->update($data, array("user_id"=>$data["user_id"]));

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

/* End of file matchpricesshop.php */
/* Location: ./application/controllers/matchpricesshop.php */