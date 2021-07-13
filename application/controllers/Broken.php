<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broken extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//$this->load->model('M_kota');
		$this->load->model('M_broken');
	}

	public function index() {
        set_time_limit(0);
        $result = $this->M_broken->select_all();        
        foreach($result as $element){      
            if(!empty($element->urlSEO && is_null($element->broken))){ 
                try {
                    $this->getUrlSeo($element);
                } catch (Exception $e) {
                    var_dump($e);
                    // Handle exception
                }
            }
            if(!empty($element->imageProduct && is_null($element->imageProductExist))){ 
                try {
                    $this->getImageProduct($element);
                } catch (Exception $e) {
                    var_dump($e);
                    // Handle exception
                }
            }
            if(!empty($element->imageProduct228 && is_null($element->imageProduct228Exist))){ 
                try {
                    $this->getImageProduct228($element);
                } catch (Exception $e) {
                    var_dump($e);
                    // Handle exception
                }
            }
            if(!empty($element->imageProduct500 && is_null($element->imageProduct500Exist))){ 
                try {
                    $this->getImageProduct500($element);
                } catch (Exception $e) {
                    var_dump($e);
                    // Handle exception
                }
            }
        }
    }	
    
    public function getUrlSeo($element){
        $ban = true;
        $content = file_get_contents($element->urlSEO);                          
        if ($content === false) {
            $ban = false;
        }
        $result = $this->M_broken->update(array("broken"=>$ban), array("Id"=>$element->Id)); 
    }
    public function getImageProduct($element){
        $ban = true;
        $content = file_get_contents($element->imageProduct);                          
        if ($content === false) {
            $ban = false;
        }
        $result = $this->M_broken->update(array("imageProductExist"=>$ban), array("Id"=>$element->Id)); 
    }
    public function getImageProduct228($element){
        $ban = true;
        $content = file_get_contents($element->imageProduct228);                          
        if ($content === false) {
            $ban = false;
        }
        $result = $this->M_broken->update(array("imageProduct228Exist"=>$ban), array("Id"=>$element->Id)); 
    }
    public function getImageProduct500($element){
        $ban = true;
        $content = file_get_contents($element->imageProduct500);                          
        if ($content === false) {
            $ban = false;
        }
        $result = $this->M_broken->update(array("imageProduct500Exist"=>$ban), array("Id"=>$element->Id)); 
    }
}

/* End of file Kota.php */
/* Location: ./application/controllers/Kota.php */