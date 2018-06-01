<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoCloud
 *
 * @author goodeath
 */
class BoletoCloud {
	
	private $data;
	private $httpCode;
	private $apiUrl = 'https://sandbox.boletocloud.com/api/v1/boletos';
	private $responseHeader = null;
	private $body = null;
	const HTTP_RESPONSE_OK = 201;
	const CODE_BRADESCO = 237;
	const CODE_ITAU = 341;
	const CODE_CAIXA = 104;
	const CODE_BANCOOB = 756;
	
 
	
	public function __construct(BoletoCloudBank $bank, BoletoCloudBeneficiary $beneficiary, BoletoCloudPayer $payer){
		$this->data = $bank->getData() + $beneficiary->getData() + $payer->getData();
 
	}
	
	public function setEmissionDate($date){
		$date = str_replace('/','-',$date);
		$date = date('Y-m-d',strtotime($date));
		$this->data['boleto.emissao'] = $date;
		return $this;
	}
	
	public function setExpireDate($date){
		$date = str_replace('/','-',$date);
		$date = date('Y-m-d',strtotime($date));
		$this->data['boleto.vencimento'] = $date;
		return $this;
	}
	
	public function setDocument($document){
		$this->data['boleto.documento'] = $document;
		return $this;
	}
	
	public function setNumber($number){
		$this->data['boleto.numero'] = $number;
		return $this;
	}
	
	public function setTitle($title){
		$this->data['boleto.titulo'] = $title;
		return $this;
	}
	
	public function setValue($value){
		$this->data['boleto.valor'] = $value;
		return $this;
	}

	  
	public function setIntruction($instruction){
		$this->data['boleto.instrucao'] = array($instruction);
		return $this;
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function getApiUrl(){
		return $this->apiUrl;
	}
	
	private function setHttpCode($code){
		$this->httpCode = $code;
	}
	
	public function getHttpCode(){
		return $this->httpCode;
	}
	
	public function setCurlOptions($ch){
		#Pode responder com o boleto ou mensagem de erro
		$accept_header = 'Accept: application/pdf, application/json';

		#Estou enviando esse formato de dados
		$content_type_header = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		
		$fields = $this->getData();
		$fields_string = '';

	   foreach($fields as $key=>$value) {
		   if(is_array($value)){
			   foreach($value as $v){
				   $fields_string .= urlencode($key).'='.urlencode($v).'&';
			   }
		   }else{
			   $fields_string .= urlencode($key).'='.urlencode($value).'&';	
		   }
	   }

	   $data = rtrim($fields_string, '&');

		$headers = array($accept_header, $content_type_header);
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl());
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_USERPWD, "api-key_vJxqRj_8ZIu7850rCC3R-lDRcedJ40l4KuMlLH-Kjxs=:token"); #API TOKEN
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);# Basic Authorization
		curl_setopt($ch, CURLOPT_HEADER, true);#Define que os headers estarï¿½o na resposta
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); #Para uso com https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); #Para uso com https
	}
	
	public function generate(){
		

		   $ch = curl_init();
		   $this->setCurlOptions($ch);
		   $response = curl_exec($ch);
		   
		   #Principais meta-dados da resposta

		   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		   $this->setHttpCode($httpCode);
		   $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

		   #Fechar processo de comunicaï¿½ï¿½o
		   curl_close($ch);


		   #Separando header e body na resposta

		   $header = substr($response, 0, $header_size);
		   $body = substr($response, $header_size);
		   $header_array = explode("\r\n", $header);
 
		   $this->setResponseHeader($header_array);
		   $this->setBody($body);

	}
	
	public function getBody(){
		return $this->body;
	}
	
	public function setBody($body){
		$this->body = $body;
	}
	
	public function show(){
		$body = $this->getBody();
		if($this->getHttpCode() == BoletoCloud::HTTP_RESPONSE_OK){
		   #Versï¿½o da plataforma: $boleto_cloud_version 
		   #Token do boleto disponibilizado: $boleto_cloud_token
		   #Localizaï¿½ï¿½o do boleto na plataforma: $location
		   #Enviando boleto como resposta:
		   header('Content-type: application/pdf');
		   header('Content-Disposition: inline; filename=arquivo-api-boleto-post-teste.pdf');
		   echo $body; #Visualizaï¿½ï¿½o no navegador
		   exit();
	   }else{
		   #Versï¿½o da plataforma: $boleto_cloud_version 
		   #Cï¿½dgio de erro HTTP: $http_code
		   #Enviando erro como resposta:
		   header('Content-Type: application/json; charset=utf-8');
		   echo $body; #Visualizaï¿½ï¿½o no navegador
		   exit();
	   }
	}
	
	public function save($path,$filename){
		$base = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->request->baseUrl;
		$path = substr($path,-1) == '/' ? $path . $filename : $path . '/' . $filename;
		$url = (substr($path,0,1) == '/') ? $base . $path  : $base . '/' . $path;
		$handle = fopen($url,'w+');
		fwrite($handle, $this->getBody());
		fclose($handle);
		return true;
	}
	
	public function setResponseHeader($header){
		$this->responseHeader = $header;
	}
	
	public function getResponseHeader(){
		if(is_null($this->responseHeader)){
			throw new Exception("Você não pode solicitar os cabeçalhos, antes de realizar a requisição");
		} else {
			return $this->responseHeader;
		}
	}
	
	public function getVersion(){
		$header_array = $this->getResponseHeader();
		$version = '';
		foreach($header_array as $h) {
			if(preg_match('/X-BoletoCloud-Version:/i', $h)) {
				$version = $h;
			}
		}
		return $version;
	}
	
	public function getToken(){
		$header_array = $this->getResponseHeader();
		$token = '';
		foreach($header_array as $h) {
			if(preg_match('/X-BoletoCloud-Token:/i', $h)) {
				$token = $h;
			}
		}
		return $token;
	}
	
	public function getLocation(){
		$header_array = $this->getResponseHeader();
		$location = '';
		foreach($header_array as $h) {
			if(preg_match('/Location:/i', $h)) {
				$location = $h;
			}
		}
		return $location;
	}
}
