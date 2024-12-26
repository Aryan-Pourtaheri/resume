const note_pad = document.querySelector('.note-pad');
const microphone_btn = document.querySelector('.microphone-btn button');

let btn_active = true;

window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;


const recognition = new SpeechRecognition();
recognition.interimResults = true;

let p = document.createElement("p");
note_pad.appendChild(p);

microphone_btn.addEventListener('click', toggleClick)

function toggleClick() { 
  turnONOFF();
}

function turnONOFF() {
  if (btn_active) {
    btnIsActive();
  } else {
    btnNotActive();
  }
}

function btnIsActive() { 
    microphone_btn.style.animationName = "changeSize";
    microphone_btn.style.animationDuration = "0.8s";
    microphone_btn.style.animationIterationCount = "infinite";
  
    btn_active = false;
    
    recognition.addEventListener("result", handleSpeechResult);
  recognition.addEventListener("end", restartRecognition);
  
  recognition.start();
}

function btnNotActive() {
  microphone_btn.style.animation = "none";
  
  recognition.removeEventListener('end', restartRecognition);
  
  recognition.removeEventListener('result', handleSpeechResult);

  btn_active = true;

  recognition.stop();
}

function restartRecognition() {
  recognition.start();
}

function handleSpeechResult(e) { 
  const transcript = Array.from(e.results)
  .map(result => result[0])
  .map(result => result.transcript)
  .join("");

  p.textContent = transcript;

  if (e.results[0].isFinal) {
    p = document.createElement("p");
    note_pad.appendChild(p);
  }
}