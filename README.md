# Busca CEP

Sistema de busca de endereços por CEP, usando o serviço gratuito [Viacep](https://viacep.com.br)

## Instalação

Para instalar, basta requerer via composer:

```bash
composer require werneckbh/busca-cep
```

## Utilização

Você pode buscar o endereço usando o construtor ou o método `->setCep('12345-678')`:
```php
$endereco = new BuscaCep('01001-000');
// ou
$endereco = new BuscaCep();
$endereco->setCep('01001-000');
```
> Caso informe um CEP inválido ou inexistente, a classe dispara uma *exception* do tipo `CepInvalidoException`

Feito isso, basta então acessar os getter da classe:
```php
$endereco->getCep(); // '01001-000'
$endereco->getLogradouro(); // 'Praça da Sé'
$endereco->getComplemento(); // 'lado ímpar'
$endereco->getBairro(); // 'Sé'
$endereco->getLocalidade(); // cidade 'São Paulo'
$endereco->getUf(); // estado com 2 letras 'SP'
$endereco->getUnidade();
$endereco->getIbge(); // '3550308' 
$endereco->getGia(); // apenas para SP '1004'
```

Para mais informações sobre IBGE e GIA, visite o site [Viacep](https://viacep.com.br)

