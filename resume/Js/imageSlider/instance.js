function initSlider() {
  const sliderButtons = document.querySelectorAll('.slider-button');
  const imageList = document.querySelector('.image-list');
  const sliderScrollBar = document.querySelector('.slider-scrollbar');
  const scrollThumb = document.querySelector('.scrollbar-thumb');
  const sliderMaxWidth = imageList.scrollWidth - imageList.clientWidth;

  
  scrollThumb.addEventListener('mousedown', (e) => {
    const startX = e.clientX;
    const thumbPosition = scrollThumb.offsetLeft;

    const handleMouseMove = (e) => {
      const deltaX = e.clientX - startX;
      const newThumbPosition = thumbPosition + deltaX;
      const maxThumbPosition = sliderScrollBar.getBoundingClientRect().width - scrollThumb.offsetLeft;

      const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
      const scrollPosition = (boundedPosition / maxThumbPosition) * sliderMaxWidth;

      imageList.scrollLeft = scrollPosition;

      scrollThumb.style.left = `${boundedPosition}px`;
    }

    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);

    function handleMouseUp(){
      document.removeEventListener('mousemove', handleMouseMove);
      document.removeEventListener('mouseup', handleMouseUp);
    }
  });

  sliderButtons.forEach(button => {
    button.addEventListener('click', () => {
      const direction = button.id == 'prev-slide' ? -1 : 1;
      const scrollAmount = imageList.clientWidth * direction;
      imageList.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    })
  });

  const handleSliderButton = () => {
    sliderButtons[0].style.display = imageList.scrollLeft <= 0 ? 'none' : 'block';
    sliderButtons[1].style.display = imageList.scrollLeft >= sliderMaxWidth ? 'none' : 'block';
  }

  const updateScrollThumbPosition = () => {
    const scrollPositoin = imageList.scrollLeft;
    const thumbPlace = (scrollPositoin / sliderMaxWidth) * (sliderScrollBar.clientWidth - scrollThumb.offsetWidth);
    scrollThumb.style.left = `${thumbPlace}px`;
  }

  imageList.addEventListener('scroll', () => {
    handleSliderButton();
    updateScrollThumbPosition();
  })
}

window.addEventListener('load', initSlider);