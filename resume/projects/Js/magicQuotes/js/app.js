import data from "./data.js";

console.log(data);

const say_Quote_btn = document.querySelector('.rotate-button');
const magical_hat = document.querySelector('.magical-hat');
const magical_sound = document.querySelector('.magical-sound');
const magical_quote = document.querySelector('.magical-quote');

say_Quote_btn.addEventListener('click', function () {
  let random_quote = Math.floor(Math.random() * 16);
  console.log(random_quote);
  magical_quote.innerHTML = data[random_quote]["text"];
  magical_sound.play();
  magical_hat.style.transform = 'rotate(18000deg)';
  setInterval(() => {
      magical_hat.style.transform = 'rotate(0deg)';
  },3000)
});
