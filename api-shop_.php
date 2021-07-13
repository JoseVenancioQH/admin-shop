<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";

function getConnection() {
	$dbhost=DB_HOSTNAME;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

function uploadImage($item){	
		$foto = "image/data/".$item['sku'].".jpg";
		$fototobdd = "data/".$item['sku'].".jpg";					
		$data = file_get_contents($item['pImgen']);  
		if(file_exists($foto )){unlink($foto);}
		file_put_contents($foto, $data);
		$db = getConnection();
		$sql = "UPDATE product SET image = '".$fototobdd."' WHERE product_id = " . $item['product_id'];		
		$stmt = $db->query($sql); 	
		$db = null;
		echo $data;
}

function getImage($datacurl) {
	$limit='';
	$filter=array();
	if(!empty($datacurl["numproduct"])){$limit=" LIMIT ".$datacurl["numproduct"];}
	if($datacurl["filterImageEmpty"]=='true'){$filter[] = "(image = '' or image is null)";}
	$filter[] = "p.status = ".(($datacurl["filteractive"]=='true')?'1':'0');
	if($datacurl["filterprice"]=='true'){$filter[] = "p.price > 0";}
	if(isset($datacurl["NameProduct"])&&!empty($datacurl["NameProduct"])){
		$arrayName = explode(";",$datacurl["NameProduct"]);
		foreach($arrayName as $item){
			if(!empty(trim($item))){
				$filter_name[] = "(REPLACE(upper('".trim($item)."'),\" \",\"\") like concat(\"%\",REPLACE(upper(pd.name),\" \",\"\"),\"%\") or REPLACE(upper(pd.name),\" \",\"\") like concat(\"%\",REPLACE(upper('".trim($item)."'),\" \",\"\"),\"%\"))";
			}
		}
		$filter[] = "(".implode(" Or ",$filter_name).")";
	}
	if(isset($datacurl["SKU"])&&!empty($datacurl["SKU"])){
		$arraySKU = explode(";",$datacurl["SKU"]);
		foreach($arraySKU as $item){
			if(!empty(trim($item))){
				$filter_sku[] = "(REPLACE(upper('".trim($item)."'),\" \",\"\") like concat(\"%\",REPLACE(upper(p.sku),\" \",\"\"),\"%\") or REPLACE(upper(p.sku),\" \",\"\") like concat(\"%\",REPLACE(upper('".trim($item)."'),\" \",\"\"),\"%\"))";
			}
		}
		$filter[] = "(".implode(" Or ",$filter_sku).")";
	}
	if(isset($datacurl["Model"])&&!empty($datacurl["Model"])){
		$arrayModel = explode(";",$datacurl["Model"]);
		foreach($arrayModel as $item){
			if(!empty(trim($item))){
				$filter_model[] = "REPLACE(upper(p.model),\" \",\"\") like concat(\"%\",REPLACE(upper('".trim($item)."'),\" \",\"\"),\"%\")";
			}
		}
		$filter[] = "(".implode(" Or ",$filter_model).")";
	}
	
	$sql = "
			select 
				p.product_id,
				p.image,
				p.sku,
				pd.name,
				p.model,
				null as pImgen		
			from
				product p left join product_description pd on p.product_id = pd.product_id
			where ".implode(" And ",$filter)." 
			order by p.price ".$limit;

	$sqlAll = "
			select 
				p.product_id,
				p.image,
				p.sku,
				pd.name,
				p.model,
				null as pImgen		
			from
				product p left join product_description pd on p.product_id = pd.product_id			
			where ".implode(" And ",$filter)."
			order by p.price
	";

	/* echo  $sql;
	exit; */

	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$stmtAll = $db->query($sqlAll);	
		$products = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;	
		$data = array("count"=>$stmt->rowCount() ,"length"=>$stmtAll->rowCount() ,"data"=>array());
		foreach ($products as $product) {
			$data["data"][] = array(
							"product_id"=>$product->product_id,
							"image"=>$product->image,
							"sku"=>$product->sku,
							"name"=>utf8_encode(trim($product->name)),
							"pImage"=>null
						   );						
		}
		echo json_encode($data);
	} catch(PDOException $e) {
		echo  '{"error":{"text":'. $e->getMessage()."--".$sql.'}}'; 
	} 
}

var_dump($_REQUEST["urlshop"]);
exit;

switch ($_REQUEST["type"]) {	
	case "uploadimage":			
		uploadImage($_REQUEST);	
		break;
	case "getImage":			
		getImage($_REQUEST);	
		break;
    default:
		getImage($_REQUEST);
}

?>