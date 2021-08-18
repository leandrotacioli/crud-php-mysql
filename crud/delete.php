<?php
	require_once("conexao.php");
	
	$cod_veiculo = $_POST['CodVeiculo'];
	
	try {
		$pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$pdo->beginTransaction();
		
		$statement = $pdo->prepare("DELETE FROM veiculos WHERE cod_veiculo = ?");
		
		$statement->bindParam(1, $cod_veiculo, PDO::PARAM_INT);
		$statement->execute();
		
		$response["sucesso"] = true;
		$response["mensagem"] = "Veículo excluído com sucesso.";
		
		$pdo->commit();
		$pdo = null;
 
	} catch (PDOException $e) {
		$response["sucesso"] = false;
		$response["mensagem"] = "Ocorreu um erro na exclusão do veículo.<br><br>" . $e->getMessage();
		
		$pdo->rollBack();
		$pdo = null;
	}

	echo json_encode($response);
?>