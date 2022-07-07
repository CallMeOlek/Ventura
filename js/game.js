// Variaveis
const targets = document.querySelectorAll('.parent');
const buttons = document.querySelectorAll('button');
const voiceList = document.querySelector('#voiceList');
const voiceBtn = document.querySelector('#voiceBtn');
const body = document.getElementById('#body');
var synth = window.speechSynthesis;
var voices = [];


synth.cancel();
PopulateVoices();

if(speechSynthesis !== undefined){
  speechSynthesis.onvoiceschanged = PopulateVoices;
}

// Botão de pausar e resumir a voz
$(voiceBtn).click(function() {
  if (this.dataset.isPaused === "false"){
    this.value = "Resumir";
    this.dataset.isPaused = "true";
    synth.pause();
  }else if (this.dataset.isPaused === "true") {
    this.value = "Pausar";
    this.dataset.isPaused = "false";
    synth.resume();
  }
});

// Continuação do jogo
targets.forEach(function(target) {

  buttons.forEach(function(button) {
    if (button.innerHTML === "" || button.dataset.next === '0') {
      button.style.display = "none";
    }

    button.addEventListener("click", () => {
      const options = button.parentNode;
      const innerContainer = options.parentNode;
      const container = innerContainer.parentNode;
      const parent = container.parentNode;
      const msgContainer = parent.lastElementChild;
      const msg = msgContainer.firstElementChild;

      const targetStory = target.querySelector(".story");
      if (typeof(targetStory) !== undefined || targetStory !== null) {
        var newStoryText = markText(targetStory.textContent,"**","b");
        targetStory.innerHTML = newStoryText;
      }

      if (target.dataset.value == button.dataset.next){
        msgContainer.style.display = "flex";
        msg.innerHTML = button.innerHTML;

        insertAfter(target, parent.parentNode.lastElementChild);
        const targetOptions = target.querySelector(".options");
        const targetMsg = target.querySelector(".action");
        targetOptions.style.display = "flex";
        targetMsg.style.display = "none";
        speakText(newStoryText);
        
        options.style.display = "none";
        target.style.display = "flex";

        $(targetStory).each(function () {
          this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
        });

        target.scrollIntoView({behavior:"smooth"});
      }
    });
  });
});

// Função para ter menos confusão.
function insertAfter(newNode, existingNode) {
  existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
}

// Muda os identificadores do texto pela tag correspondente.
function markText(text, identifier, htmltag){
  var array = text.split(identifier);
  var previous = "";
  var previous_i;
  for (i = 0; i < array.length; i++) {
      if (i % 2)
      {
          //odd number
      }
      else if (i!=0)
      {
          previous_i = eval(i-1);
          array[previous_i] = "<"+htmltag+">"+previous+"</"+htmltag+">";
      }
      previous = array[i];
  }
  var newtext = "";
  for (i = 0; i < array.length; i++) {
      newtext += array[i];
  }
  return newtext;
}

// Função que mostra o texto letra por letra
function showText(target, message, index, interval) {   
  if (index < message.length) {
    $(target).append(message[index++]);
    setTimeout(function () { showText(target, message, index, interval); }, interval);
  }
}

// Fala o texto
function speakText(txtInput) {
  synth.cancel();
  if (synth.paused === false) {
    var toSpeak = new SpeechSynthesisUtterance(txtInput);
    var selectedVoiceName = voiceList.selectedOptions[0].getAttribute('data-name');
    voices.forEach((voice)=>{
      if(voice.name === selectedVoiceName){
        toSpeak.voice = voice;
      }
    });
    synth.speak(toSpeak);
  }
}

// Carrega todas as vozez na lista.
function PopulateVoices(){
  voices = synth.getVoices();
  var selectedIndex = voiceList.selectedIndex < 0 ? 0 : voiceList.selectedIndex;
  voiceList.innerHTML = '';
  voices.forEach((voice)=>{
    var listItem = document.createElement('option');
    listItem.textContent = voice.name;
    listItem.setAttribute('data-lang', voice.lang);
    listItem.setAttribute('data-name', voice.name);
    voiceList.appendChild(listItem);
  });

  voiceList.selectedIndex = selectedIndex;
}