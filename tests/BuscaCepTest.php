<?php

use PHPUnit\Framework\TestCase;
use Werneckbh\BuscaCep\BuscaCep;
use Werneckbh\BuscaCep\Exceptions\CepInvalidoException;

class BuscaCepTest extends TestCase
{
    /**
     * @test
     */
    public function testIfCepIsInvalidInConstructor()
    {
        try {
            new BuscaCep('invalid cep');
        } catch (CepInvalidoException $ex) {
            $this->assertTrue($ex->getMessage() === 'O cep informado é inválido.');
        }
    }

    /**
     * @test
     */
    public function testIfCepWasNotFoundInConstructor()
    {
        try {
            $buscador = new BuscaCep('99999-999');
        } catch (CepInvalidoException $ex) {
            $this->assertTrue($ex->getMessage() === 'O cep informado não foi encontrado.');
        }
    }

    /**
     * @test
     */
    public function testIfCepIsInvalid()
    {
        try {
            $buscador = new BuscaCep();
            $buscador->setCep('invalid cep');
        } catch (CepInvalidoException $ex) {
            $this->assertTrue($ex->getMessage() === 'O cep informado é inválido.');
        }
    }

    /**
     * @test
     */
    public function testIfCepWasNotFound()
    {
        try {
            $buscador = new BuscaCep();
            $buscador->setCep('99999-999');
        } catch (CepInvalidoException $ex) {
            $this->assertTrue($ex->getMessage() === 'O cep informado não foi encontrado.');
        }
    }

    /**
     * @test
     */
    public function testIfReturnsArray()
    {
        $this->assertTrue(is_array((new BuscaCep())->toArray()));
    }

    /**
     * @test
     */
    public function testValidCep()
    {
        $buscador = new BuscaCep('01001000');
        $this->assertTrue($buscador->getLogradouro() === 'Praça da Sé');
        $this->assertTrue($buscador->getBairro() === 'Sé');
        $this->assertTrue($buscador->getLocalidade() === 'São Paulo');
        $this->assertTrue($buscador->getUf() === 'SP');
    }
}