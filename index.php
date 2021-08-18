<?php
	require_once "crud/conexao.php";
	require_once "crud/read.php";
	
	verificarConexaoBancoDados();
	
	$veiculos = listarVeiculos();
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>CRUD - PHP + MySQL</title>
		
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/spinner.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
		<script src="js/modal.js"></script>
		<script src="js/spinner.js"></script>
	</head>
	<body>
		<h1 class="center">CRUD - PHP + MySQL</h1>
		<h3 class="center">Cadastro de Veículos</h3>
		<br />
		<button type="button" class="btn btn-primary float-end" title="Adicionar veículo" onclick="GerenciarVeiculo(0)">
			<i class="fa fa-plus"></i>&nbsp;&nbsp;Adicionar veículo
		</button>
		<br /><br />
		<table class="table table-bordered table-striped">
			<thead>
				<tr class="table-primary">
					<th style="width: 15% !important;">Placa</th>
					<th style="width: 30% !important;">Marca</th>
					<th style="width: 30% !important;">Modelo</th>
					<th style="width: 15% !important;">Ano de Fabricação</th>
					<th style="width: 10% !important;">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if (isset($veiculos)) {
						foreach($veiculos as $veiculo) {
							?>
							<tr>
								<td><?=$veiculo["placa"]?></td>
								<td><?=$veiculo["marca"]?></td>
								<td><?=$veiculo["modelo"]?></td>
								<td><?=$veiculo["ano_fabricacao"]?></td>
								<td class="center">
									<button type="button" class="btn btn-warning btn-acao" title="Alterar dados do veículo" onclick="GerenciarVeiculo('<?=$veiculo["cod_veiculo"]?>')"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger btn-acao" title="Excluir veículo" onclick="ExcluirVeiculo('<?=$veiculo["cod_veiculo"]?>')"><i class="fa fa-remove"></i></button>
								</td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr>
							<td class="center" colspan="5">Não há veículos cadastrados.</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		
		<div id="overlay" style="display:none;">
            <div class="spinner"></div>
            <br />
            <h4><label id="spinnerMessage">Carregando...</label></h4>
        </div>
		
		<div id="divModalVeiculo"></div>
		
		<div id="modalAlert" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-body" id="msgModalAlert"></div>
                </div>
            </div>
        </div>

        <div id="modalConfirm" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-body" id="msgModalConfirm"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSimModalConfirm"><i class="fa fa-check"></i> Sim</button>
                        <button type="button" class="btn btn-danger" id="btnNaoModalConfirm"><i class="fa fa-times"></i> Não</button>
                    </div>
                </div>
            </div>
        </div>
		
		<script>
			function GerenciarVeiculo(CodVeiculo) {
				$.ajax({
					url: "modal.php",
					type: "GET",
					data: { "CodVeiculo": CodVeiculo },
					dataType: "html",
					success: function (response) {		
						$('#divModalVeiculo').html(response);
						$("#modalVeiculo").modal({backdrop: "static", keyboard: false});
						$("#modalVeiculo").modal("show");
					},
					error: function (response) {
						OpenModal("Ocorreu um erro no gerenciamento de dados do veículo. Tente novamente.<br>" + response.statusText);
					}
				});
			}
			
			function ExcluirVeiculo(CodVeiculo) {
				OpenModalConfirm("Confirma exclusão do veículo?",
					function () {
						ShowSpinner('Excluindo veículo...');
						
						$.ajax({
							url: "crud/delete.php",
							type: "POST",
							data: { "CodVeiculo": CodVeiculo },
							dataType: "json",
							success: function (response) {
								if (response.sucesso == true) {
									HideSpinner();
									OpenModal(response.mensagem);
									
									$('#modalAlert').on('hidden.bs.modal', function (e) {
										ShowSpinner('Carregando veículos...');
										window.location.href = "index.php";
									})
								} else {
									HideSpinner();
									OpenModal(response.mensagem);
								}
							},
							error: function (response) {
								HideSpinner();
								OpenModal("Ocorreu um erro na exclusão do veículo. Tente novamente.<br>" + response.statusText);
							}
						});
					},
					null
				);
			}
		</script>
	</body>
</html>