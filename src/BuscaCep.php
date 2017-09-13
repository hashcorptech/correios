<?php

namespace Werneckbh\BuscaCep;

use Werneckbh\BuscaCep\Exceptions\CepInvalidoException;

/**
 * Class BuscaCep
 *
 * @author Bruno Vaula Werneck
 * @package Werneckbh\BuscaCep
 */
class BuscaCep
{
    protected $cep;
    protected $logradouro;
    protected $complemento;
    protected $bairro;
    protected $localidade;
    protected $uf;
    protected $unidade;
    protected $ibge;
    protected $gia;
    protected $tempoDePesquisa;

    /**
     * BuscaCep constructor.
     *
     * @param string $cep
     */
    public function __construct(string $cep = '')
    {
        if (strlen($cep) > 0) {
            $this->setCep($cep);
        }
    }

    /**
     * Validates ZIP code.
     *
     * @param string $cep
     * @throws CepInvalidoException
     */
    protected function validateCep(string $cep)
    {
        if ($this->isInvalidCep($cep)) {
            throw new CepInvalidoException('O cep informado é inválido.');
        }
    }

    /**
     * Returns true if ZIP is invalid.
     *
     * @param string $cep
     * @return bool
     */
    protected function isInvalidCep(string $cep) : bool
    {
        if (preg_match('/^[0-9]{5}-{0,1}[0-9]{3}$/', trim($cep)) !== 1) {
            return true;
        }

        return false;
    }

    /**
     * Get Data from Viacep
     *
     * @return mixed
     */
    protected function getData()
    {
        $init = microtime(true);
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_HTTPGET, true);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($handler, CURLOPT_URL, "https://viacep.com.br/ws/{$this->cep}/json/");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handler);
        curl_close($handler);
        $end = microtime(true);
        $this->tempoDePesquisa = $end - $init;

        return json_decode($result, true);
    }

    /**
     * Populates CEP fields
     *
     * @throws CepInvalidoException
     */
    protected function populateFields()
    {
        $data = $this->getData();

        if (isset($data['erro'])) {
            throw new CepInvalidoException('O cep informado não foi encontrado.');
        }

        $this->cep = $data['cep'];
        $this->logradouro = $data['logradouro'];
        $this->complemento = $data['complemento'];
        $this->bairro = $data['bairro'];
        $this->localidade = $data['localidade'];
        $this->uf = $data['uf'];
        $this->unidade = $data['unidade'];
        $this->ibge = $data['ibge'];
        $this->gia = $data['gia'];
    }

    /**
     * @param string $cep
     * @return BuscaCep
     * @throws CepInvalidoException
     */
    public function setCep(string $cep) : BuscaCep
    {
        $this->validateCep($cep);
        $this->cep = $cep;
        $this->populateFields();

        return $this;
    }

    /**
     * Get ZIP code.
     *
     * @return string
     */
    public function getCep() : string
    {
        return $this->cep;
    }

    /**
     * Get Street address.
     *
     * @return string
     */
    public function getLogradouro() : string
    {
        return $this->logradouro;
    }

    /**
     * Get Extra address.
     *
     * @return string
     */
    public function getComplemento() : string
    {
        return $this->complemento;
    }

    /**
     * Get Neighborhood.
     *
     * @return string
     */
    public function getBairro() : string
    {
        return $this->bairro;
    }

    /**
     * Get City.
     *
     * @return string
     */
    public function getLocalidade() : string
    {
        return $this->localidade;
    }

    /**
     * Get State Abbreviation.
     *
     * @return string
     */
    public function getUf() : string
    {
        return $this->uf;
    }

    /**
     * Get Unity.
     *
     * @return string
     */
    public function getUnidade() : string
    {
        return $this->unidade;
    }

    /**
     * Get IBGE.
     *
     * @return string
     */
    public function getIbge() : string
    {
        return $this->ibge;
    }

    /**
     * Get GIA.
     *
     * @return string
     */
    public function getGia() : string
    {
        return $this->gia;
    }

    /**
     * Get Benchmark.
     *
     * @return float
     */
    public function getTempoDePesquisa() : float
    {
        return $this->tempoDePesquisa;
    }

    /**
     * Get Associative array with results, if any
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'localidade' => $this->localidade,
            'uf' => $this->uf,
            'unidade' => $this->unidade,
            'ibge' => $this->ibge,
            'gia' => $this->gia,
            'tempo_de_pesquisa' => number_format($this->tempoDePesquisa, 2) . ' segundos',
        ];
    }
}