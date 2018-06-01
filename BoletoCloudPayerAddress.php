<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoCloudPayerAddress
 *
 * @author goodeath
 */
class BoletoCloudPayerAddress  implements IRecoverData {
	
	private $data = array();
	
	public function __construct($cep, $uf, $city, $district, $street, $number, $complement){
		$this->data['boleto.pagador.endereco.cep'] = $cep;
		$this->data['boleto.pagador.endereco.uf'] = $uf;
		$this->data['boleto.pagador.endereco.localidade'] = $city;
		$this->data['boleto.pagador.endereco.bairro'] = $district;
		$this->data['boleto.pagador.endereco.logradouro'] = $street;
		$this->data['boleto.pagador.endereco.numero'] = $number;
		$this->data['boleto.pagador.endereco.complemento'] = $complement;
	  
	}
	
	public function getData(){
		return $this->data;
	}
	 
}
