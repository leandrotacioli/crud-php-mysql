function ShowSpinner(pMessage) {
    document.getElementById("overlay").style.display = "block";
    document.getElementById('spinnerMessage').innerHTML = pMessage;
}

function HideSpinner() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById('spinnerMessage').innerHTML = "";
}