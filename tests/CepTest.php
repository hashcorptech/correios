<?php

use PHPUnit\Framework\TestCase;
use Correios\Cep;
use Correios\Exceptions\InvalidCepException;

class CepTest extends TestCase
{
    /**
     * @test
     */
    public function testCepNotFound()
    {
        try {
            $cep = new Cep('99999-999');
        } catch (InvalidCepException $ex) {
            $this->assertTrue($ex->getMessage() === 'CEP NAO ENCONTRADO');
        }
    }

    /**
     * @test
     */
    public function testReturnsArray()
    {
        $this->assertTrue(is_array((new Cep())->toArray()));
    }

    /**
     * @test
     */
    public function testValidCep()
    {
        $cep = new Cep('01001000');
        $this->assertTrue($cep->street === 'Praça da Sé');
        $this->assertTrue($cep->neighborhood === 'Sé');
        $this->assertTrue($cep->city === 'São Paulo');
        $this->assertTrue($cep->state === 'SP');
    }
}