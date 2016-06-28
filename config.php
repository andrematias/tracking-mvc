<?php
//Diretórios
	define('ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
	define('TEMPLATES', ROOT.'/app/core/views/templates/');

//SITEPATH
	define('PROTOCOL', (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://');
	define('DOMAIN', $_SERVER['HTTP_HOST']);
	define('SITEPATH', PROTOCOL.DOMAIN);

	define('PUBLIC_PATH', SITEPATH.'/public/');

//Debug mode (Para desativar notificações e mensagens de erros mude para false).
	define('DEBUG', true);

// Dados de acesso ao banco de dados.
	define('DB_HOSTNAME', '127.0.0.1');
	define('DB_NAME', 'track_enter');
	define('DB_USER', 'root');
	define('DB_DRIVER', 'mysql');
	define('DB_PASS', '0406');
	define('DB_CHARSET', 'charset=utf8');