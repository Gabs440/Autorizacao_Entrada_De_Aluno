//VALIDAR O RM
function validateForm() {
  var input = document.getElementsByName("RM")[0].value;
  if (isNaN(input) || input.length != 5) {
    alert("O seu RM não é válido.");
    return false;
  }
  return true;
}



//CASO TENHA ALGUM OUTRO MOTIVO PARA O ATRASO PODERÁ PREENCHER O CAMPO
function showHideInput() {
  var select = document.getElementsByName("motivo")[0];
  var outroInput = document.getElementById("outro_motivo");
  if (select.value == "Outro") {
    outroInput.style.display = "inline-block";
    outroInput.required = true;
    outroInput.addEventListener("input", function() {
      select.value = outroInput.value;
      select.required = false;
    });
  } else {
    outroInput.style.display = "none";
    outroInput.required = false;
  }
}



//VAI VALIDAR SE TODOS OS CAMPOS ESTÃO PREENCHIDOS
function validateFields() {
  var rmInput = document.getElementsByName("RM")[0];
  var nomeInput = document.getElementsByName("nomealuno")[0];
  var serieInput = document.getElementsByName("serie")[0];
  var cursoInput = document.getElementsByName("curso")[0];

  if (rmInput.value == "" || nomeInput.value == "" || serieInput.value == "" || cursoInput.value == "") {
    alert("Por favor, preencha todos os campos.");
    return false;
  }

  return true;
}



/*VAI PEGAR A MENSAGEM DE INSERÇÃO DA TABELA PARA EXIBIR NA PRÓPRIA TELA DO INDEX, 
SEM PRECISAR ABRIR UMA OUTRA TELA PHP PARA EXIBIR O REGISTRO*/
function enviarFormulario(event) {
  event.preventDefault();
  if (validateForm() && validateFields()) {
    var formulario = document.getElementById("form-registro");
    var dados = new FormData(formulario);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/inserir.php");
    xhr.responseType = "json";
    xhr.onload = function() {
      if (xhr.status === 200) {
        var divMensagem = document.getElementById("mensagem");
        divMensagem.querySelector("p").innerHTML = xhr.response.mensagem;
        divMensagem.style.display = "block";
      } else {
        alert("Erro ao enviar o formulário.");
      }
    };
    xhr.send(dados);
  }
}
document.addEventListener('DOMContentLoaded', function() {
  document.querySelector(".popup-content").querySelector(".close-button").addEventListener("click", function() {
    document.getElementById("mensagem").style.display = "none";
  });
});


function limparFiltro(elemento){
  elemento.value = "";
}
