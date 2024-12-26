const picture = document.querySelector('.circle');
const refresher = document.querySelector('.refresh-page');
const container = document.querySelector('.container');
let spaceW = 0;
let spaceH = 0;
currentPadding = Number(picture.style.padding);
currentPadding = 10;

function set_position() {
  spaceW = container.clientWidth - picture.clientWidth;
  spaceH = container.clientHeight - picture.clientHeight;
}

function random_position() {
  picture.style.top = Math.round(Math.random() * spaceH) + 'px';
  picture.style.left = Math.round(Math.random() * spaceW) + 'px';
}

refresher.addEventListener('click', random_position);

window.addEventListener('load', () => {
  set_position();
  random_position();
});

picture.addEventListener('mouseover', () => {
  const increment = 5;
  let Newpadding = currentPadding + increment;
  picture.style.padding = Newpadding + 'px';
});

picture.addEventListener('mouseout', () => {
  let Newpadding = currentPadding;
  picture.style.padding = Newpadding + 'px';
});

picture.addEventListener('click', () => {
  set_position();
  random_position();
})