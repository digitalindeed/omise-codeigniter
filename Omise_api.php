<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*
* Omise charge api class 
* Thanupong B. Parnthongthanaphan
* OPTOK co.,ltd
*
*/
class Omise_api {
	var $_api_url = 'https://api.omise.co/';
	var $pkey, $skey;
	public function __construct()
	{

	}
	public function init($publish_key, $secret_key){
		$this->pkey = $publish_key;
		$this->skey = $secret_key;
	}
	public function create($card_token, $amount, $description = null, $capture = true, $currency = 'thb'/*, $return_uri = null*/){
		$post = array(
					'amount' 	=> $amount,
					'card'		=> $card_token,
					'currency'	=> $currency,
					'capture'	=> $capture,
				);
		if($description != null){
			$post['description'] = $description;
		}
		/*if($return_uri != null){
			$post['return_uri'] = $return_uri;
		}*/
		return $this->_exeCurl('charges', $post);
	}
	public function capture($charge_id){
		$capture_path = 'charges/'.$charge_id."/capture";
		return $this->_exeCurl($capture_path);
	}
	private function _exeCurl($command = 'charges', $post_array = array()){
		//prepare url
		$gurl = $this->_api_url.$command;

		//prepare post value
		$qst = http_build_query($post_array);

		//header
	        $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg'; 
	        $headers[] = 'Connection: Keep-Alive';
	        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'; 
	
	        //init
	        $process = curl_init($gurl); 
	
	        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($process, CURLOPT_HEADER, 0);
	        curl_setopt($process, CURLOPT_ENCODING , 'gzip');
	        curl_setopt($process, CURLOPT_TIMEOUT, 30);
	        curl_setopt($process, CURLOPT_POSTFIELDS, $qst);
	        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($process, CURLOPT_POST, 1);
	        curl_setopt($process, CURLOPT_USERPWD, $this->skey.":");
	        try{
	            $return = curl_exec($process);
	        }catch (Exception $e){
	            echo " error : ".$e->getMessage();
	        }
	        curl_close($process);
	        return json_decode($return);
	}
}
