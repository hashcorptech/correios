# Busca CEP

Sistema de busca de endereços por CEP, usando o serviço gratuito [SIGEP - Correios](http://www.corporativo.correios.com.br/encomendas/sigepweb/doc/Manual_de_Implementacao_do_Web_Service_SIGEP_WEB.pdf)

## Instalação

Para instalar, basta requerer via composer:

```bash
composer require hedcler/correios
```

## Utilização

Você pode buscar o endereço usando o construtor ou o método `->setCep('12345-678')`:
```php
$endereco = new Cep('01001-000');
```
> Caso informe um CEP inválido ou inexistente, a classe dispara uma _exception_ do tipo `CepInvalidoException`

Feito isso, basta então acessar os _getters_ da classe:
```php
$endereco->cep; // '01001-000'
$endereco->street; // 'Praça da Sé'
$endereco->complement; // 'lado ímpar'
$endereco->neighborhood; // 'Sé'
$endereco->city; // cidade 'São Paulo'
$endereco->state; // estado com 2 letras 'SP'
```

Para sua conveniência, também é possível buscar todos os dados num array associativo:
```php
$endereco->toArray();
```

# Licença

[Este projeto está sob a licença GPL-3.0-or-later](https://spdx.org/licenses/GPL-3.0-or-later.html)
