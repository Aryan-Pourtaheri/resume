const compass = document.querySelector('.compass');
//300 240
//0 0
document.addEventListener('mousemove', (e) => {
  if ((e.clientX <= 700 && e.clientY <= 300) || (e.clientX >= 700 && e.clientY >= 300)) {
    compass.style.transform = 'rotate(90deg)';
  } else {
    compass.style.transform = 'rotate(0deg)';
  }
})

compass.addEventListener('click', () => {
  compass.style.transform = 'rotate(360deg)';
})

/*
  if ((e.clientX <= 300 && e.clientY <= 240) || (e.clientX >= 300 && e.clientY >= 240)) {
    compass.style.transform = 'rotate(90deg)';
  } else if ((e.clientX >= 300 && e.clientY <= 240) || (e.clientX <= 300 && e.clientY >= 240)) {
    compass.style.transform = 'rotate(0deg)';
  }
/////////////////////////////////////////////////

    if ((e.clientX <= 300 && e.clientY <= 240) || (e.clientX >= 300 && e.clientY >= 240)) {
    compass.style.transform = 'rotate(90deg)';
  } else {
    compass.style.transform = 'rotate(0deg)';
  }
/////////////////////////////////////////////////
  if (e.clientX <= 300 && e.clientY <= 240) {
    compass.style.transform = 'rotate(90deg)';
  } else if (e.clientX >= 300 && e.clientY <= 240) {
    compass.style.transform = 'rotate(180deg)';
  } else if (e.clientX >= 300 && e.clientY >= 240) { 
    compass.style.transform = 'rotate(270deg)';
  } else if (e.clientX <= 300 && e.clientY >= 240) {
    compass.style.transform = 'rotate(360deg)';

  }
*/