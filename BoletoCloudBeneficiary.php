<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoBeneficiary
 *
 * @author goodeath
 */
class BoletoCloudBeneficiary implements IRecoverData {
	
	private $data = array();
	
	public function __construct($name, $cprf, $cep, $uf, $city, $district, $street, $number, $complement){
		$this->data['boleto.beneficiario.nome'] = $name;
		$this->data['boleto.beneficiario.cprf'] = $cprf;
		$address = new BoletoCloudBeneficiaryAddress($cep, $uf, $city, $district, $street, $number, $complement);
		$this->data = $this->getData() + $address->getData();
	}
	
	public function getData(){
		return $this->data;
	}
	 
}
