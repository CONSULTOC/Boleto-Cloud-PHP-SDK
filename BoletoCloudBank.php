<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bank
 *
 * @author goodeath
 */
class BoletoCloudBank implements IRecoverData {
	//put your code here
	private $data = array();
	
	public function __construct($bankCode, $agency, $number, $wallet){
		$this->data['boleto.conta.banco'] = $bankCode;
		$this->data['boleto.conta.agencia'] = $agency;
		$this->data['boleto.conta.numero'] = $number;
		$this->data['boleto.conta.carteira'] = $wallet;
	}
	
	public function getData(){
		return $this->data;
	}
}
