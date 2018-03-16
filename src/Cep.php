<?php

namespace Correios;

use SoapClient;
use Correios\Exceptions\InvalidCepException;

class Cep
{
    private $wsdl;

    protected $cep;
    protected $street;
    protected $complement;
    protected $neighborhood;
    protected $city;
    protected $state;
    protected $timespend;

    public function __construct(string $cep = '')
    {
        $this->wsdl = new SoapClient(dirname(__FILE__).'/Wsdl/AtendeCliente.xml', ['trace' => 1]);

        if (strlen($cep) > 0) {
            $this->cep = preg_replace('/\D/', '', $cep);
            $this->search();
        }
    }

    private function getData()
    {
        $init = microtime(true);
        
        try{
            $data = $this->wsdl->consultaCEP(['cep' => $this->cep]);
        } catch (\SoapFault $e) {
            throw new InvalidCepException($e->getMessage(), 1);
        }

        $this->time = microtime(true) - $init;

        return $data->return;
    }

    protected function search()
    {
        $data = $this->getData();

        if (! isset($data)) {
            throw new InvalidCepException('O cep informado não foi encontrado.');
        }

        $this->street = $data->end;
        $this->complement = sprintf('%s %s', $data->complemento, $data->complemento2);
        $this->city = $data->cidade;
        $this->neighborhood = $data->bairro;
        $this->state = $data->uf;
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {

            return $this->{$key};

        }

        return false;
    }

    public function toArray() : array
    {
        return [
            'cep' => $this->cep,
            'street' => $this->street,
            'complement' => $this->complement,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'state' => $this->state,
            'timespend' => number_format($this->timespend, 2) . ' sec',
        ];
    }
}