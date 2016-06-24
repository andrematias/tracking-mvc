<?php
namespace App\Lib;

/**
 * Interface para as classes observadas
 * @author André Matias
 */
Abstract class Sujeito
{
    /**
     * Inclui os observadores em um array list
     * @param \App\Lib\observador $observador instancia para ser notificada
     */
    abstract protected function IncluirObservadores( observador $observador );

    /**
     * Remover observadores do array list
     * @param \App\Lib\observador $observador instancia para ser removida do
     * array list
     */
    abstract protected function RemoverObservadores( observador $observador );

    /**
     * Percorre o array list e notifica cada observador sobre as atualizações
     */
    abstract protected function Notificar();
}