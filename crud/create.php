<?php
	require_once("conexao.php");
	require_once("read.php");
	
	$placa = $_POST['placa'];
	$marca = $_POST['marca'];
	$modelo = $_POST['modelo'];
	$ano_fabricacao = $_POST['anofabricacao'];
	
	try {
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$pdo->beginTransaction();
		
		// Verifica se já existe um veículo com a placa informada
		$veiculo_mesma_placa = retornarVeiculoPorPlaca($placa);
		
		if (!isset($veiculo_mesma_placa)) {
			$statement = $pdo->prepare("INSERT INTO veiculos (placa, marca, modelo, ano_fabricacao) VALUES (?, ?, ?, ?) ");
			
			$statement->bindParam(1, $placa, PDO::PARAM_STR);
			$statement->bindParam(2, $marca, PDO::PARAM_STR);
			$statement->bindParam(3, $modelo, PDO::PARAM_STR);
			$statement->bindParam(4, $ano_fabricacao, PDO::PARAM_INT);
			$statement->execute();
			
			$response["id_veiculo"] = $pdo->lastInsertId();
			$response["sucesso"] = true;
			$response["mensagem"] = "Veículo inserido com sucesso.";
			
			$pdo->commit();
			$pdo = null;
		} else {
			$response["sucesso"] = false;
			$response["mensagem"] = "Não é possível realizar a gravação dos dados.<br><br>Já existe um veículo cadastrado com a placa informada.";
		
			$pdo->rollBack();
			$pdo = null;
		}
 
	} catch (PDOException $e) {
		$response["id_veiculo"] = 0;
		$response["sucesso"] = false;
		$response["mensagem"] = "Ocorreu um erro na gravação de dados do veículo.<br><br>" . $e->getMessage();
		
		$pdo->rollBack();
		$pdo = null;
	}

	echo json_encode($response);
?>