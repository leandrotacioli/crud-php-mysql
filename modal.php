<?php
	require_once "crud/read.php";
	
	try {
		if (isset($_GET["CodVeiculo"])) {
			$veiculo = retornarVeiculo($_GET["CodVeiculo"]);
		} else {
			die(header("HTTP/1.0 400 <br> Informe o código do veículo"));
		}
	} catch (Exception $e) {
		die(header("HTTP/1.0 404 <br> " . $e->getMessage()));
	}
?>

<div id="modalVeiculo" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTitleLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitleLabel"><i class="fa fa-car"></i>&ensp; Dados do Veículo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"/>
			</div>
			<div class="modal-body">
				<form id="FormCadastroVeiculo" role="form">
					<input type="hidden" id="codveiculo" name="codveiculo" value="<?=$veiculo["cod_veiculo"]?>" />
					
					<div class="form-group">
						<label for="placa">Placa:</label>
						<input type="text" class="form-control" id="placa" name="placa" maxlength="10" value="<?=$veiculo["placa"]?>" required>
					</div>
					<div class="form-group">
						<label for="marca">Marca:</label>
						<input type="text" class="form-control" id="marca" name="marca" maxlength="30" value="<?=$veiculo["marca"]?>" required>
					</div>
					<div class="form-group">
						<label for="modelo">Modelo:</label>
						<input type="text" class="form-control" id="modelo" name="modelo" maxlength="30" value="<?=$veiculo["modelo"]?>" required>
					</div>
					<div class="form-group">
						<label for="anofabricacao">Ano de Fabricação:</label>
						<input type="number" class="form-control" id="anofabricacao" name="anofabricacao" maxlength="4" value="<?=$veiculo["ano_fabricacao"]?>" oninput="this.value=this.value.slice(0,this.maxLength)" required>
					</div>
					
					<div class="modal-footer" style="padding-left:0px !important; padding-right:0px !important;">
						<button type="button" class="btn btn-primary" onclick="SalvarVeiculo()">
							<i class="fa fa-save"></i> Salvar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	function SalvarVeiculo() {
		var validacaoCampos = ValidarCampos();
		
		if (validacaoCampos == "") {
			ShowSpinner("Gravando dados do veículo...");
			
			var urlGravacao = "crud/create.php"; // Novo registro
			
			if (document.getElementById("codveiculo").value != 0) {
				urlGravacao = "crud/update.php"; // Alteração de registro já existente
			}
			
			$.ajax({
				url: urlGravacao,
				type: "POST",
				data: $('#FormCadastroVeiculo').serialize(),
				dataType: "json",
				success: function (response) {		
					if (response.sucesso == true) {
						HideSpinner();
						OpenModal(response.mensagem);
						
						$('#modalVeiculo').modal('hide');
						
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
					OpenModal("Ocorreu um erro na gravação dos dados do veículo. Tente novamente.<br>" + response.responseText);
				}
			});
		} else {
			OpenModal("Existem campos obrigatórios não preenchidos: <br>" + validacaoCampos);
		}
	}
	
	function ValidarCampos() {
		var validacaoCampos = "";
		
		if (document.getElementById("placa").value.length == 0) validacaoCampos = validacaoCampos + "<br> - Placa";
		if (document.getElementById("marca").value.length == 0) validacaoCampos = validacaoCampos + "<br> - Marca";
		if (document.getElementById("modelo").value.length == 0) validacaoCampos = validacaoCampos + "<br> - Modelo";
		if (document.getElementById("anofabricacao").value.length == 0) validacaoCampos = validacaoCampos + "<br> - Ano de Fabricação";
		
		return validacaoCampos;
	}
</script>