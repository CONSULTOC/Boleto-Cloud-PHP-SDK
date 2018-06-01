<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoCloudBeneficiaryAddress
 *
 * @author goodeath
 */
class BoletoCloudBeneficiaryAddress  implements IRecoverData {
	
	private $data = array();
	
	public function __construct($cep, $uf, $city, $district, $street, $number, $complement){
		$this->data['boleto.beneficiario.endereco.cep'] = $cep;
		$this->data['boleto.beneficiario.endereco.uf'] = $uf;
		$this->data['boleto.beneficiario.endereco.localidade'] = $city;
		$this->data['boleto.beneficiario.endereco.bairro'] = $district;
		$this->data['boleto.beneficiario.endereco.logradouro'] = $street;
		$this->data['boleto.beneficiario.endereco.numero'] = $number;
		$this->data['boleto.beneficiario.endereco.complemento'] = $complement;
	  
	}
	
	public function getData(){
		return $this->data;
	}
	 
}
