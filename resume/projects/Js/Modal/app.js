// select modal-btn,modal-overlay,close-btn
// listen for click events on modal-btn and close-btn
// when user clicks modal-btn add .open-modal to modal-overlay
// when user clicks close-btn remove .open-modal from modal-overlay

const modal_overlay = document.querySelector('.modal-overlay');

const modal_btn = document.querySelector('.modal-btn');

const close_btn = document.querySelector('.close-btn')

modal_btn.addEventListener('click', () => {
  modal_overlay.classList.toggle('open-modal')
})

close_btn.addEventListener('click', () => {
  modal_overlay.classList.remove('open-modal')
})