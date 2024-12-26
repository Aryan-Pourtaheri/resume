const ApiKey = 'cb92d3dfea75ece76489a30d5f7d92df';
const Input_search = document.querySelector('#search')
const Icon_search = document.querySelector('.search-icon')
const weather_data = document.querySelector('.weather-data');
const container = document.querySelector('.container');
const search_bar = document.querySelector('.search-bar');

container.style.height = '100px';
container.style.transition = 'all 0.5s ease-in-out';
container.style.alignItems = 'start';
search_bar.style.height = '50px';
search_bar.style.transition = '0s';
Input_search.style.height = '100%';
Input_search.style.transition = '0s';


Icon_search.addEventListener('click', () => {
  if (Input_search.value === "") {
    container.style.height = '100px';
    search_bar.style.height = '50px';
    Input_search.style.height = '100%';
    weather_data.innerHTML = "";
    dataFound();
  }

  if (Input_search.value !== "") {
    container.style.height = '599px';
    search_bar.style.height = '10%';
    setTimeout(() => {
      dataFound();
    }, 500);
    setTimeout(() => {
      const weather_image = document.querySelector('.weather-image');
      const wind = document.querySelector('.wind');
      const humidity = document.querySelector('.humidity');
      const weather_degree = document.querySelector('.weather-degree');
      weather_image.style.transform = 'translateY(0%)';
      wind.style.transform = 'translateY(0%)';
      humidity.style.transform = 'translateY(0%)';
      weather_degree.style.transform = 'translateY(0%)';
    }, 700);
  }else {
    dataNotFound();
  }
})

function dataFound() {
  if (Input_search.value !== "") {
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${Input_search.value}&units=metric&appid=${ApiKey}`)
    .then(response => response.json())
    .then(data => {
      let weather_image_link = "";
      
      switch (data.weather[0].main) {
        case "Rain":
          weather_image_link = "./images/rain.png";
          break;
        case "Clear":
          weather_image_link = "./images/clear.png";
          break;
        case "Clouds":
          weather_image_link = "./images/cloud.png";
          break;
        case "Snow":
          weather_image_link = "./images/snow.png";
          break;
        case "Mist":
          weather_image_link = "./images/mist.png";
          break;

      
        default:
          break;
      }

      weather_data.innerHTML = (`      
        <img src="${weather_image_link}" class="weather-image" alt="weather-image">

        <p class="weather-degree">0<span>&#8451;</span></p>

        <div class="weather-status">
          <div class="wind">
            <i class="bx bx-wind"></i>
            <div>
              <h3 class="wind-amount">100%</h3>
              <p>Wind speed</p>
            </div>
          </div>
          <div class="humidity">
            <i class="bx bx-water"></i>
            <div>
              <h3 class="humidity-amount">1Km/h</h3>
              <p>humidity</p>
            </div>
          </div>
        </div>
      `);

      document.querySelector('.wind-amount').innerHTML = `${Math.floor(data.wind.speed)}%`;
      document.querySelector('.humidity-amount').innerHTML = `${Math.floor(data.main.humidity)}KM/H`;
      document.querySelector('.weather-degree').innerHTML = `${data.main.temp}<span>&#8451;</span>`;  
    })

    .catch(error => {
      weather_data.innerHTML = '';
      
      const error_text = document.createElement('p');
      error_text.innerText = "Error: 404 invalid city";
      error_text.style.color = 'rgb(225, 58, 58)';
      error_text.style.textShadow = '0px 0px 20px black';
      error_text.style.fontWeight = 'bold'; 

      const img404 = document.createElement('img');
      img404.classList.add('img404');
      img404.src = '../images/404.png';

      weather_data.appendChild(img404);
      weather_data.appendChild(error_text);
    });
  }
}

function dataNotFound() {
  Input_search.setAttribute('placeholder', 'please enter a city')
  Input_search.style.transition = '1s';
  Input_search.classList.add('placeholder-error')
  setTimeout(() => {
    Input_search.classList.remove('placeholder-error')
    Input_search.setAttribute('placeholder', 'enter your location')
  }, 1000);
}