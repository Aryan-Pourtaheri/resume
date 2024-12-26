const spanHoure = document.querySelector('.hour');
const spanMinute = document.querySelector('.minute');
const spanSecond = document.querySelector('.second');
const am_pm = document.querySelector('.time-am-pm');
const catLol = document.querySelector('.catlol');
const party_time_btn = document.querySelector('.btn-Party-Time');
const wake_up_time = document.getElementById('wake-up-time');

function App() {
  setInterval(() => {
      const timeHoure = 23;
      const timeMinute = new Date().getMinutes();
      const timeSecond = new Date().getSeconds();
      spanHoure.innerHTML = timeHoure;
      spanMinute.innerHTML = timeMinute;
      spanSecond.innerHTML = timeSecond;

      if (timeHoure >= 5 && timeHoure <= 10) {
        catLol.src = './images/goodMorning.jpg';
      } else if (timeHoure > 10 && timeHoure <= 14) {
        catLol.src = './images/Good Noon.png';
      } else if (timeHoure > 14 && timeHoure <= 19) {
        catLol.src = './images/Good AfterNoon.png';
      } else {
        catLol.src = './images/Good night.png'
      }

      if (timeHoure >= 12) {
        am_pm.innerHTML = 'PM'
      } else {
        am_pm.innerHTML = 'AM'
        if (wake_up_time.value == '6AM-7AM' && 6 <= timeHoure || 7 >= timeHoure) {
          alert('I think you should wake up');
        } 
      }

      if (timeHoure >= 12) {
      } else {
        if (wake_up_time.value == '6AM-7AM' && timeHoure == 6 && timeMinute == 0) {
          alert('I think you should wake up');
        }else if(wake_up_time.value == '8AM-9PM' && timeHoure == 8 && timeMinute == 0) {
          alert('I think you should wake up');
        } 
      }
  }, 1000)



  
}

export default App;