<?php
namespace App\Core\Models;

/**
 * Description of results
 *
 * @author André Matias
 */
use App\Lib\Base;
use App\Lib\Sessao;
use App\Lib\User;
use App\Lib\Cliente;
use App\Lib\Origem;
use \App\Lib\Interesse;

class Results extends \App\Lib\Main\MainModel
{
    private $startDate;

    private $endDate;

    private $clienteId;

    private $userId;

    private $interesses;

    private $businessLine;

    private $score;

    private $origem;

    /**
     * Método para retornar todos os dados para o relatório do tipo consolidado
     * @return Array Associativo com todos os dados
     */
    public function consolidado(){
        $sql = "SELECT
        'Prospect' AS visitor,
        ' ' AS description,
        'Others' AS subject,
        session_date AS data,
        type_interest,
        nome AS request,
        email,
        cargo AS function,
        telefone,
        empresa,
        uf AS sbu,
        endereco,
        cep,
        cidade,
        estado,
        pais,
        cnpj,
        source AS origem,
        session_date AS data,
        lead_type AS leadType,
        SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(session_end, session_start)))) AS tempo_de_navegacao,
        COUNT(id_user) as content,
        SUM(default_score) AS score
        FROM tr_base
        JOIN tr_cliente USING(id_cliente)
        JOIN tr_user USING(id_user)
        JOIN tr_session USING (id_user)
        JOIN tr_url using(id_url)
        LEFT JOIN tr_type USING(id_type)
        LEFT JOIN tr_source ON tr_source.id_source = tr_url.id_source
        WHERE tr_cliente.cliente = :cliente
        AND session_date BETWEEN :date_start AND :date_end
        GROUP BY email, MONTH(session_date)
        ORDER BY Score DESC";

        $this->startDate = (filter_input(INPUT_POST, 'date') ? filter_input(INPUT_POST, 'date') : '1990-01-01');
        $this->endDate = (filter_input(INPUT_POST, 'date_end') ? filter_input(INPUT_POST, 'date_end') : date('Y-m-d', time()));

       $conn = parent::getConn();
       $query = $conn->prepare($sql);

       $params = [
            ':cliente' => $_SESSION['cliente'],
            ':date_start' => $this->startDate,
            ':date_end' => $this->endDate,
        ];
       $query->execute($params);
       return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Teste utilizando as classes bases
     */
    public function consolidado2(){
        $base = new Base;
        $sessao = new Sessao;
        $user = new User;
        $cliente = new Cliente;
        $origem = new Origem;
        $interesse = new Interesse;

        $this->clienteId = $cliente->getClienteId($_SESSION['cliente']);
        $this->userId = $user->allUsersFromCliente($this->clienteId);

        $out = [];

        foreach ($this->userId as $id){
            $this->interesses = $interesse->getUserInterest($id['id_user']);
            $this->businessLine = $interesse->getUserBusinessLine($id['id_user']);

            $merge = \array_merge(
                $sessao->navigationTime($id['id_user']),
                $base->allFromUser($id['id_user']),
                $sessao->countContent($id['id_user']),
                array('interesses' => $this->interesses),
                array('businessLine' => $this->businessLine)
            );
            
            $out[] = $merge;
        }
        
        echo "<pre>";
        var_dump($out);
    }
}