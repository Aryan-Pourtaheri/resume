const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
const weekdays = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];

const giveaway = document.querySelector('.giveaway');
const deadline = document.querySelector('.deadline');
const items = document.querySelectorAll('.deadline-format h4');

let tempDate = new Date();
let tempYear = tempDate.getFullYear();
let tempMonth = tempDate.getMonth();
let tempDay = tempDate.getDate();

// let futureDate = new Date(2023,7,14,20,23,44);
let futureDate = new Date(tempYear, tempMonth, tempDay + 10, 11 ,30 ,)

const year = futureDate.getFullYear();
const hours = futureDate.getHours();
const date = futureDate.getDate();
let month = futureDate.getMonth();
month = months[month];
let weekday = futureDate.getDay();
weekday = weekdays[weekday] 
const minutes = futureDate.getMinutes();

giveaway.textContent = `giveaway ends on ${weekday},${date} ${month} ${year} ${hours}:${minutes}am `;

const futureTime = futureDate.getTime();

function Remaining(){
  const today = new Date().getTime();
  const t = futureDate - today;
  const oneDay = 24 * 60 * 60 * 1000;
  const oneHour = 60 * 60 * 1000;
  const oneMinute = 60 * 1000;
  let days = t / oneDay;
  days = Math.floor(days);
  let Hours = Math.floor((t % oneDay) / oneHour);
  let Minutes = Math.floor((t % Hours) /oneMinute)
  let seconds = Math.floor((t % oneMinute) / 1000)

  function format(item){
    if(item < 10) {
      return item = `0${item}`
    }
    return item
  }

  const values = [days,Hours,Minutes,seconds]
  items.forEach((item , index) => {
    item.innerHTML = format(values[index])
  })

  if(t < 0) {
    clearInterval(countdown)
    deadline.innerHTML = '<h4 class="expired">sorry , this giveaway has expired</h4>'
  }
}

let countdown = setInterval(Remaining, 1000);
Remaining();
