<?php
	function httpsPost($Url, $strRequest)
	{
		// Initialisation
		$ch=curl_init();
		// Set parameters
		curl_setopt($ch, CURLOPT_URL, $Url);
		// Return a variable instead of posting it directly
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// Active the POST method
		curl_setopt($ch, CURLOPT_POST, 1) ;
		// Request
		curl_setopt($ch, CURLOPT_POSTFIELDS, $strRequest);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$headers = array("Content-type: text/xml", "Content-length: " . strlen($strRequest), "Connection: close");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// execute the connexion
		$result = curl_exec($ch);
		// Close it
		curl_close($ch);
		return $result;
	}
	
	function getIngramPrice($sku)
	{	
			$string = '<?xml version="1.0" encoding="ISO-8859-1"?><PNARequest><Version>2.0</Version>';
			$string.= '<TransactionHeader><SenderID>AMEX by Grupo INACOM</SenderID>';
			$string.= '<ReceiverID>INGRAM MICRO</ReceiverID>';
			$string.= '<CountryCode>MX</CountryCode><LoginID>AmExB4gDd2020</LoginID><Password>GrUIn071620</Password>';
			$string.= '<TransactionID>{A0DEA52B-341F-40C3-9C80-77A4A84F9EB7}</TransactionID></TransactionHeader>';
			$string.= '<PNAInformation SKU="'.$sku.'" Quantity="1" ReservedInventory="N"/>';
			$string.= '<ShowDetail>0</ShowDetail></PNARequest>';
			$url = 'https://newport.ingrammicro.com/MUSTANG';
	
			$strRequest = utf8_encode($string);
			$Response = httpsPost($url, $strRequest);
			// validate xml response from pcg
	
			$doc = new DOMDocument();
			$doc->loadXML($Response);
			$pnaResp = "PNAResponse.xml";
			$doc->save("$pnaResp");
	
			// loocking for errors
			$ErrorStatus = $doc->getElementsByTagName("ErrorStatus");
			$ErrorNumber = $ErrorStatus->item(0)->getAttribute("ErrorNumber");
			if(strlen($ErrorNumber)<=0){
				// No errors
				$PriceAndAvailability = $doc->getElementsByTagName( "PriceAndAvailability" );
				  foreach( $PriceAndAvailability as $PriceAndAvailability ){
	
	
					  $Prices = @$PriceAndAvailability->getElementsByTagName( "Price" );
	
					  $Price = @$Prices->item(0)->nodeValue;
	
					  $Parts = $PriceAndAvailability->getElementsByTagName("ManufacturerPartNumber");
	
					  $Branchs = $PriceAndAvailability->getElementsByTagName( "Branch" );
					  $Avails = $PriceAndAvailability->getElementsByTagName( "Availability" );
					  $TotAvail =0;
					  for ($i = 0; $i < $Branchs->length; ++$i) {
							$TotAvail += $Avails->item($i)->nodeValue;
					  }
	
					  $Price = str_replace(",",".",$Price);
					  // Agregamos el margen del producto
					  $FinalPrice = $Price;
	
				  } //for each
			}
			else{
				die($ErrorStatus->item(0)->nodeValue);
			}
			$data = array("precio"=>$Price,"disponibilidad"=>$TotAvail);
	
			return $data;
	
	}
	
	function checkPriceStockSKU($sku){
		$data = getIngramPrice($sku);
		return $data;
	}	

	function sanitize($str)
	{
		return strtolower(strip_tags(trim(($str))));
	}

	function curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function file_get_contents_curl($url,$data){		
		# create a cURL handle
		$ch  = curl_init();
		# set the URL (this could also be passed to curl_init() if desired)
		curl_setopt($ch, CURLOPT_URL, $url);
		# set the HTTP method to POST
		curl_setopt($ch, CURLOPT_POST, true);
		# setting this option to an empty string enables cookie handling
		# but does not load cookies from a file
		curl_setopt($ch, CURLOPT_COOKIEFILE, "");
		# set the values to be sent
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		# return the response body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		# send the request
		$result = curl_exec($ch);
		return $result;
	}

	function create_temp_table_shop($table,$metadata,$datainsert){		
		
	}

	// MSG
	function show_msg($content='', $type='success', $icon='fa-info-circle', $size='14px') {
		if ($content != '') {
			return  '<p class="box-msg">
				      <div class="info-box alert-' .$type .'">
					      <div class="info-box-icon">
					      	<i class="fa ' .$icon .'"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' .$size .'">
				        	' .$content
				      	.'</div>
					  </div>
				    </p>';
		}
	}

	function show_succ_msg($content='', $size='14px') {
		if ($content != '') {
			return   '<p class="box-msg">
				      <div class="info-box alert-success">
					      <div class="info-box-icon">
					      	<i class="fa fa-check-circle"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' .$size .'">
				        	' .$content
				      	.'</div>
					  </div>
				    </p>';
		}
	}

	function show_err_msg($content='', $size='14px') {
		if ($content != '') {
			return   '<p class="box-msg">
				      <div class="info-box alert-error">
					      <div class="info-box-icon">
					      	<i class="fa fa-warning"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' .$size .'">
				        	' .$content
				      	.'</div>
					  </div>
				    </p>';
		}
	}

	// MODAL
	function show_my_modal($content='', $id='', $data='', $size='md') {
		$_ci = &get_instance();

		if ($content != '') {
			$view_content = $_ci->load->view($content, $data, TRUE);

			return '<div class="modal fade" id="' .$id .'" role="dialog">
					  <div class="modal-dialog modal-' .$size .'" role="document">
					    <div class="modal-content">
					        ' .$view_content .'
					    </div>
					  </div>
					</div>';
		}
	}

	function show_my_confirm($id='', $class='', $title='Konfirmasi', $yes = 'Ya', $no = 'Tidak') {
		$_ci = &get_instance();

		if ($id != '') {
			echo   '<div class="modal fade" id="' .$id .'" role="dialog">
					  <div class="modal-dialog modal-md" role="document">
					    <div class="modal-content">
					        <div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
						      <h3 style="display:block; text-align:center;">' .$title .'</h3>
						      
						      <div class="col-md-6">
						        <button class="form-control btn btn-primary ' .$class .'"> <i class="glyphicon glyphicon-ok-sign"></i> ' .$yes .'</button>
						      </div>
						      <div class="col-md-6">
						        <button class="form-control btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> ' .$no .'</button>
						      </div>
						    </div>
					    </div>
					  </div>
					</div>';
		}
	}
?>