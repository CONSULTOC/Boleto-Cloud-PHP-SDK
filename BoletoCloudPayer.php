<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoCloudPayer
 *
 * @author goodeath
 */
class BoletoCloudPayer implements IRecoverData {
	
	private $data = array();
	
	public function __construct($name, $cprf, $cep, $uf, $city, $district, $street, $number, $complement){
		$this->data['boleto.pagador.nome'] = $name;
		$this->data['boleto.pagador.cprf'] = $cprf;
		$payerAddress = new BoletoCloudPayerAddress($cep, $uf, $city, $district, $street, $number, $complement);
		$this->data += $payerAddress->getData();
	  
	}
	
	public function getData(){
		return $this->data;
	}
	 
}

