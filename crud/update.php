<?php
	require_once("conexao.php");
	require_once("read.php");
	
	$cod_veiculo = $_POST['codveiculo'];
	$placa = $_POST['placa'];
	$marca = $_POST['marca'];
	$modelo = $_POST['modelo'];
	$ano_fabricacao = $_POST['anofabricacao'];
	
	try {
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$pdo->beginTransaction();
		
		// Verifica se já existe um veículo com a placa informada que é diferente do veículo que estamos atualizando
		$veiculo_mesma_placa = retornarVeiculoPorPlacaDiferenteAtual($placa, $cod_veiculo);
		
		if (!isset($veiculo_mesma_placa)) {
			$statement = $pdo->prepare("UPDATE veiculos 
										SET placa = ?, marca = ?, modelo = ?, ano_fabricacao = ?
										WHERE cod_veiculo = ? ");
			
			$statement->bindParam(1, $placa, PDO::PARAM_STR);
			$statement->bindParam(2, $marca, PDO::PARAM_STR);
			$statement->bindParam(3, $modelo, PDO::PARAM_STR);
			$statement->bindParam(4, $ano_fabricacao, PDO::PARAM_INT);
			$statement->bindParam(5, $cod_veiculo, PDO::PARAM_INT);
			$statement->execute();
			
			$response["sucesso"] = true;
			$response["mensagem"] = "Veículo alterado com sucesso.";
			
			$pdo->commit();
			$pdo = null;
		} else {
			$response["sucesso"] = false;
			$response["mensagem"] = "Não é possível realizar a gravação dos dados.<br><br>Já existe um veículo cadastrado com a placa informada.";
		
			$pdo->rollBack();
			$pdo = null;
		}
 
	} catch (PDOException $e) {
		$response["sucesso"] = false;
		$response["mensagem"] = "Ocorreu um erro na alteração dos dados do veículo.<br><br>" . $e->getMessage();
		
		$pdo->rollBack();
		$pdo = null;
	}

	echo json_encode($response);
?>