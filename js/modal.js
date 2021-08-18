// Abre uma modal com uma mensagem
function OpenModal(pMensagem) {
	$("#modalAlert").modal({backdrop: "static", keyboard: false});
	$("#modalAlert").modal("show");
	$("#msgModalAlert").empty().append("<center><h4>" + pMensagem + "</h4></center><br>");
	$("#msgModalAlert").append("<center><button type='button' class='btn btn-primary' data-bs-dismiss='modal'>OK</button></center>");
}

// Abre uma modal com uma mensagem e confirmação Sim / Não
function OpenModalConfirm(pMensagem, onYes, onNo) {
	var fClose = function () {
		$("#modalConfirm").modal("hide");
	};

	$("#modalConfirm").modal({backdrop: "static", keyboard: false});
	$("#modalConfirm").modal("show");
	$("#msgModalConfirm").empty().append("<h4>" + pMensagem + "</h4>");
	$("#btnSimModalConfirm").unbind().one('click', onYes).one('click', fClose);
	$("#btnNaoModalConfirm").unbind().one("click", onNo).one('click', fClose);
}