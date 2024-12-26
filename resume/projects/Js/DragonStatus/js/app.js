const body = document.querySelector('body'),
  toggle = document.querySelector('.sleeping-toggle'),
  img = document.querySelector('.dragon-image'),
  status_btn = document.querySelector('.status-btn'),
  status_table = document.querySelector('.status-table'),
  status_value = document.querySelector('.status-value');

let
  table_level = document.querySelector('.status-value.level'),
  table_health = document.querySelector('.status-value.health'),
  table_power = document.querySelector('.status-value.power');

let table_open = true;

let level;
let health;
let power;

table_level.innerHTML = level;
table_health.innerHTML = health;
table_power.innerHTML = power;

let getMode = localStorage.getItem("mode")
if (getMode && getMode === 'active') {
  toggle.classList.add('active');
  img.src = './image/dragon.jpg'
  level = 100;
  health = 5000;
  power = 500
  table_level.innerHTML = level;
  table_health.innerHTML = health;
  table_power.innerHTML = power;
} else if (getMode === 'notActive') { 
  img.src = './image/sleeping dragon.jpg'
  level = 100;
  health = 100;
  power = 10;
  table_level.innerHTML = level;
  table_health.innerHTML = health;
  table_power.innerHTML = power;  
}

toggle.addEventListener('click', () => {
  toggle.classList.toggle('active');

  if (!toggle.classList.contains('active')){
    localStorage.setItem("mode", "notActive")
  } else {
    localStorage.setItem("mode", "active")
  }

  if (toggle.classList.contains('active')) {
    img.src = './image/dragon.jpg'
    level = 100;
    health = 5000;
    power = 500
    table_level.innerHTML = level;
    table_health.innerHTML = health;
    table_power.innerHTML = power;

  } else {
      img.src = './image/sleeping dragon.jpg'
      level = 100;
      health = 100;
      power = 10;
      table_level.innerHTML = level;
      table_health.innerHTML = health;
      table_power.innerHTML = power;  
  }
  

})

status_btn.addEventListener('click', () => { 
  if (table_open) {
    table_open = false;
    status_table.style.display = 'block';
  } else {
    table_open = true;
    status_table.style.display = 'none';
  }
})