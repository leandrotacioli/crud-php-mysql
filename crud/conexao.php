<?php
	define("DATABASE_SERVER", "localhost");
	define("DATABASE_NAME", "crud_php_mysql");
	define("DATABASE_USER", "root");
	define("DATABASE_PASSWORD", "1234");
	
	function verificarConexaoBancoDados() {
		try {
			$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		} catch (PDOException $e) {
			die("Erro na conexão com o banco de dados.<br><br>" . $e->getMessage());
		}
	}
?>