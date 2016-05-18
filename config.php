<?php
//Diretórios
	define('ROOT', dirname(__FILE__));
	define('TEMPLATES', ROOT.'/App/core/views/templates/');

//SITEPATH
	define('PROTOCOL', (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://');
	define('DOMAIN', $_SERVER['HTTP_HOST']);
	define('SITEPATH', PROTOCOL.DOMAIN);

//Debug mode (Para desativar notificações e mensagens de erros mude para false).
	define('DEBUG', true);

// Dados de acesso ao banco de dados.
	define('DB_HOSTNAME', '127.0.0.1');
	define('DB_NAME', 'test');
	define('DB_USER', 'root');
	define('DB_DRIVER', 'mysql');
	define('DB_PASS', '');
	define('DB_CHARSET', 'charset=utf8');