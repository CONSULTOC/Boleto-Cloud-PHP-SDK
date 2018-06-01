 # Boleto Cloud PHP SDK

 
 #### -- Introduction
 This is a wrapper to [BoletoCloud](boletocloud.cloud) Api.
 
 #### -- Usage
 
 I haven't use composer yet, but, you can import all classes from this repository, no matter how. After this, you need to create some objects:
 
 * Beneficiary:
 * Bank
 * Payer
  
 ##### Beneficiary
 
 ```php
new BoletoCloudBeneficiary($name, $cprf, $cep, $uf, $city, $district, $street, $number, $complement);
 ```
#####  Bank
 
 ```php
new BoletoCloudBank($bankCode, $agency, $number, $wallet);
 ```
 ##### Payer
 
```php
new BoletoCloudPayer($name, $cprf, $cep, $uf, $city, $district, $street, $number, $complement);
 ```
 
  #### -- Bank Code
  
  Acctualy, BoletoCloud only supports the following banks:
```php
  BoletoCloud::CODE_BRADESCO = 237;
  BoletoCloud::CODE_ITAU = 341;
  BoletoCloud::CODE_CAIXA = 104;
  BoletoCloud::CODE_BANCOOB = 756;
```
  
#### -- Contributing

Do you wanna contribute? Just make your improvements, and send to me. Please make a useful description about your changes.