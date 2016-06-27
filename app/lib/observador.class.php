<?php
namespace App\Lib;

use App\Lib\DbTrack;

/**
 * <b> Observador </b>
 * Classe abstrata para definir os padrões dos observadores das classes Sujeito
 * @author André Matias
 * @version 0.1
 */
Abstract class Observador extends DbTrack
{
   
    /**
     * Método abstrato para obrigar as classes filhas a implementar este método
     * essencial para os observadores.
     * @param Sujeito $dados instancia da classe que esta sendo observada.
     */
    abstract public function Atualizar( Sujeito $dados );
    
}