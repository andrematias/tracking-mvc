<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib;

/**
 * Description of cliente
 *
 * @author Enterprise
 */
class Cliente extends Observador
{
    /**
     * Identificação única para um cliente
     * @var int
     */
    protected $clienteId;

    /**
     * Nome do cliente cadastrado para o rastreamento
     * @var string
     */
    public $cliente;


    public function __construct()
    {
        if (is_null($this->database)) {
            $this->database = new DbTrack();
        }
    }

    public function Atualizar(Sujeito $dados)
    {
        $this->cliente = $dados->cliente;
    }
}