<?php
namespace App\Lib;

/**
 * <b> Observador </b>
 * Classe abstrata para definir os padrões dos observadores das classes Sujeito
 * @author André Matias
 * @version 0.1
 */
Abstract class Observador
{
    /**
     * Instancia da classe dbTrack
     * @var obj dbTrack 
     */
    protected $database;

    
    /**
     * Método abstrato para obrigar as classes filhas a implementar este método
     * essencial para os observadores.
     * @param Sujeito $dados instancia da classe que esta sendo observada.
     */
    abstract public function Atualizar( Sujeito $dados );

}