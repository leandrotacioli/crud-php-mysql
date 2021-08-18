<?php
	require_once("conexao.php");
	
	function listarVeiculos() {
		$veiculos = null;
		
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->beginTransaction();
		
        $statement = $pdo->prepare("SELECT * FROM veiculos ORDER BY placa");
        $statement->execute();
		
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$veiculos[] = $row;
		}
		
		$pdo->rollBack();
		$pdo = null;
		
        return $veiculos;
	}
	
	function retornarVeiculo($cod_veiculo) {
		$veiculo = null;
		
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->beginTransaction();
		
        $statement = $pdo->prepare("SELECT * FROM veiculos WHERE cod_veiculo = ?");
		$statement->bindParam(1, $cod_veiculo, PDO::PARAM_INT);
        $statement->execute();
		
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$veiculo = $row;
		}
		
		$pdo->rollBack();
		$pdo = null;
		
        return $veiculo;
	}
	
	function retornarVeiculoPorPlaca($placa) {
        $veiculo = null;
		
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->beginTransaction();
		
        $statement = $pdo->prepare("SELECT * FROM veiculos WHERE placa = ?");
		$statement->bindParam(1, $placa, PDO::PARAM_STR);
        $statement->execute();
		
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$veiculo = $row;
		}
		
		$pdo->rollBack();
		$pdo = null;
		
        return $veiculo;
	}
	
	function retornarVeiculoPorPlacaDiferenteAtual($placa, $cod_veiculo) {
		$veiculo = null;
		
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->beginTransaction();
		
        $statement = $pdo->prepare("SELECT * FROM veiculos WHERE placa = ? AND cod_veiculo != ?");
		$statement->bindParam(1, $placa, PDO::PARAM_STR);
		$statement->bindParam(2, $cod_veiculo, PDO::PARAM_INT);
        $statement->execute();
		
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$veiculo = $row;
		}
		
		$pdo->rollBack();
		$pdo = null;
		
        return $veiculo;
	}
?>