<?php

/**
* 
*/

namespace App\Core\Views;

use App\Lib\Main\MainView;

class Relatorios extends MainView
{
	public $pageTitle;
	
	public function consolidado($resultDataConsolidado)
	{
		$this->pageTitle = 'Trakcing::Relatório Consolidado';

		echo parent::getDefaultHeader($this->pageTitle);
		echo parent::getDefaultNav();
		echo parent::getDefaultSidebar();
		echo parent::getDefaultPeriod();
                
		$content = file_get_contents(TEMPLATES.'/relatorio_consolidado.tpl');

                //Montando as linhas da tabela com os dados do Model
                $contentResult = null;
                foreach ($resultDataConsolidado as $result) {
                    $contentResult .= '<tr>'."\n"
                    .'<td>'.$result['session_date'].'</td>'."\n"
                    .'<td>'.$result['visitor'].'</td>'."\n"
		    .'<td>'.$result['subject'].'</td>'."\n"
		    .'<td>'.$result['description'].'</td>'."\n"
                    .'<td>'.$result['nome'].'</td>'."\n"
                    .'<td>'.$result['email'].'</td>'."\n"
                    .'<td>'.$result['cargo'].'</td>'."\n"
                    .'<td>'.$result['telefone'].'</td>'."\n"
                    .'<td>'.$result['empresa'].'</td>'."\n"
                    .'<td>'.$result['uf'].'</td>'."\n"
                    .'<td>'.$result['endereco'].'</td>'."\n"
                    .'<td>'.$result['cep'].'</td>'."\n"
                    .'<td>'.$result['cidade'].'</td>'."\n"
                    .'<td>'.$result['estado'].'</td>'."\n"
                    .'<td>'.$result['pais'].'</td>'."\n"
                    .'<td>'.$result['cnpj'].'</td>'."\n"
                    .'<td>'.$result['origem'].'</td>'."\n"
                    .'<td>'.$result['content'].'</td>'."\n"
                    .'<td>'.$result['tempo_de_navegacao'].'</td>'."\n"
                    .'<td>'.$result['lead_type'].'</td>'."\n"
                    .'<td>'.$result['score'].'</td>'."\n"
                    .'</tr>'."\n";
                }

                $tagsContent = array(
                    '%%USER_CONTENT_DATA%%',
                    '%%CLIENTE%%'
                );

                $contentData = array(
                    $contentResult,
                    $_SESSION['cliente']
                );


		$content = str_replace($tagsContent, $contentData, $content);

                parent::showMessages();
		echo $content;
		echo parent::getDefaultFooter();
	}

	public function detalhado()
	{
		$this->pageTitle = 'Trakcing::Relatório Detalhado';

		echo parent::getDefaultHeader($this->pageTitle);
		echo parent::getDefaultNav();
		echo parent::getDefaultSidebar();
                echo parent::getDefaultPeriod();
                
		$content = file_get_contents(TEMPLATES.'/relatorio_detalhado.tpl');
		
		echo $content;

		echo parent::getDefaultFooter();
	}
}