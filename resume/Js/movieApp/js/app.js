const right_arrows = document.querySelectorAll('.arrow-right');
const left_arrows = document.querySelectorAll('.arrow-left');
const imageList = document.querySelectorAll('.movie-list-group');

right_arrows.forEach((right_arrow,i) => {
  const imageNumber = imageList[i].querySelectorAll("img").length;
  let counted = 0;
  right_arrow.addEventListener('click', () => {
    const ratio = Math.floor(window.innerWidth / 400); 
    counted++;
    if (imageNumber - (3 + counted) + (3 - ratio) >= 0) {
      imageList[i].style.transform = `translateX(${imageList[i].computedStyleMap().get('transform')[0].x.value - 320}px)`;
    } else {
      imageList[i].style.transform = 'translateX(0)';
      counted = 0;
    }
  });
});

left_arrows.forEach((left_arrow, i) => {
  const imageNumber = imageList[i].querySelectorAll("img").length;
  let counted = 0;
  left_arrow.addEventListener('click', () => {
    const ratio = Math.floor(window.innerWidth / 400); 
    counted--;
    if (imageNumber - (3 + counted) + (3 - ratio) <= 0) {
      imageList[i].style.transform = `translateX(${imageList[i].computedStyleMap().get('transform')[0].x.value + 320}px)`;
    } else {
      imageList[i].style.transform = 'translateX(0)';
      counted = 0;
    }
  });
});


//light Mode 
const ball = document.querySelector('.toggle-ball');
const lightModeItems = document.querySelectorAll('.navbar,.navbar-logo.active,.navbar-items,.navbar-list-item.active,.navbar-list-item,.profile-text,.caret-down,.toggle,.toggle-ball,.moon,.sidebar,.left-icons,.container,.movie-list-title,.sun');

ball.addEventListener('click', () => {
  lightModeItems.forEach(item => {
    item.classList.toggle('lightMode')
    item.style.transition = 'all 1s ease-in-out';
    if (item.classList.contains('sun') || item.classList.contains('moon')) {
      item.style.transition = '0s';
    }
  })
})