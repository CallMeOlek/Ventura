console.log('JAVASCRIPT IS WORKING');

var synth = window.speechSynthesis;
synth.cancel();

// Mostra as mensagens de erro, para a hiperligação específicada.
$(".form_button").ready(function() {

  function alertMessage(hyperlink, text, type, icon_name, inputs) { 
    document.querySelectorAll("#alert").forEach(alert => {
      if (window.location.href.indexOf(hyperlink) > -1) {
        $(" #alert").addClass(' ' + type);
        $(" #alert").text(text + " ");
        $(" #alert").append("<i class='" + icon_name +" "+ type +"'></i>");

        let input_type = inputs.split(" ");
        for (let i = 0; i < input_type.length; i++) {
          $(".form_input[name=" + input_type[i] + "]").css({"border": "2px solid #cc4444"});
          $(".form_textarea[name=" + input_type[i] + "]").css({"border": "2px solid #cc4444"});
        }
      }
      alertTab("1", "tab=profedit", alert)
      alertTab("2", "tab=pwd", alert)
    });
  }

  alertMessage("error=none", "Sucesso", "success", "fa fa-check", "");
  alertMessage("?error=emptyinput", "Preencha todos os campos", "error", "fa fa-xmark", "name uid email pwd pwdrepeat story part oldpwd newpwd newpwdrepeat");
  alertMessage("tab=profedit&error=emptyinput", "Preencha todos os campos", "error", "fa fa-xmark", "name email");
  alertMessage("tab=pwd&error=emptyinput", "Preencha todos os campos", "error", "fa fa-xmark", "oldpwd newpwd newpwdrepeat");
  alertMessage("error=wronglogin", "Nome de utilizador ou palavra-passe incorreta", "error", "fa fa-xmark", "uid pwd");
  alertMessage("error=invaliduid", "Escolha um nome de utilizador válido", "error", "fa fa-xmark", "uid");
  alertMessage("error=passwordsdontmatch", "Palavra-passes não coincidem", "error", "fa fa-xmark", "pwd pwdrepeat newpwd newpwdrepeat");
  alertMessage("error=usernametaken", "Nome de utilizador já foi tomado", "error", "fa fa-xmark", "uid");
  alertMessage("error=wrongpwd", "Palavra-passe incorreta", "error", "fa fa-xmark", "oldpwd");
  alertMessage("error=invalidext", "Extensão Inválida", "error", "fa fa-xmark", "");
  alertMessage("error=imagetoolarge", "Imagem demasiado grande", "error", "fa fa-xmark", "");
});

// Ao clicar no botão muda para a página(tab) com o mesmo dado.
function setupTabs(tab_button, page, tab_active, page_active) {
  document.querySelectorAll(tab_button).forEach(button => {
    button.addEventListener("click", () => {
      const tabsBar = button.parentElement;
      const tabsContainer = tabsBar.parentElement;
      const tabNumber = button.dataset.forTab;
      const tabToActivate = tabsContainer.querySelector(page + '[data-tab="' + tabNumber + '"]');

      tabsBar.querySelectorAll(tab_button).forEach(button => {
        button.classList.remove(tab_active);
      });

      tabsContainer.querySelectorAll(page).forEach(tab => {
        tab.classList.remove(page_active);
      });

      button.classList.add(tab_active);
      tabToActivate.classList.add(page_active);
      localStorage.setItem("tab", tabNumber);
    });
  });
}

// Esconde a mensagem de alerta para o form que não foi submetido
function alertTab(tabNumber, link, alert) {  
  const form = alert.parentNode;
  const cont = form.parentNode;
  const parent = cont.parentNode;
  if (window.location.href.indexOf(link) > -1) {
    if (parent.dataset.tab !== tabNumber){
      alert.style.display = "none";
    }
  }
}

document.addEventListener("DOMContentLoaded", () =>{
  setupTabs(".tab_button", ".page", "tab_active", "page_active");

  // Abre o último tab clicado ao voltar a página.
  document.querySelectorAll(".tabs_bar").forEach(container => {
    container.querySelectorAll(".tab_button").forEach(button => {
      tabNumber = localStorage.getItem("tab");
      if (button.dataset.forTab === tabNumber){
        button.click();
      }
    });
  });
});


// Checkboxes com o mesmo valor não podem estar ativos ao mesmo tempo.
$("input:checkbox").on('click', function() {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});


// Mete o textarea completamente extendido automaticamente.
$("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = "auto";
  this.style.height = (this.scrollHeight) + "px";
});


var x, i, j, l, ll, selElmnt, a, b, c;
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
 // Para cada elemento, crie um novo DIV que atuará como o item selecionado:
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  // Para cada elemento, crie um novo DIV que conterá a lista de opções:
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /* Para cada opção no elemento de seleção original,
     crie um novo DIV que funcionará como um item de opção: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* Quando um item é clicado, atualize a caixa de seleção original,
         e o item selecionado: */
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

// Função que fecha todas as caixas de seleção no documento, exceto a caixa selecionada atual
function closeAllSelect(elmnt) {
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
// Se clicar em qualquer lugar fora da caixa de seleção, fecha todas as caixas de seleção:
document.addEventListener("click", closeAllSelect);