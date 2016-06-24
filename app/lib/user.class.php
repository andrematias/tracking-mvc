<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib;

/**
 * Description of user
 *
 * @author Enterprise
 */
class User extends Observador
{
    /**
     * Identificação única para um usuário
     * @var int
     */
    protected $userId;
    public $pais;

    public function __construct()
    {
        if (is_null($this->database)) {
            $this->database = new DbTrack();
        }
    }

    public function Atualizar(Sujeito $dados)
    {
        $this->pais = $dados->pais;
    }

    /**
     * Configura um id para um usuário
     * @param string $userHash Hash única do usuário
     */
    public function SetUserId($userHash)
    {
        $id = $this->database->Select(
            'tr_user',
            array('id_user'),
            'WHERE user = ?',
            array($userHash)
        );

        if ($id) {
            $this->userId = (int) $id[0]['id_user'];
            return true;
        } else {
            return false;
        }
    }
}