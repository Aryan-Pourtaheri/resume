const country = document.querySelector('.country');
const city = document.querySelector('.city');

function showLocation() {
  const success = (location) => {
    const latitude = location.coords.latitude;
    const longitude = location.coords.longitude;
    const geoApiUrl = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`;
    fetch(geoApiUrl)
      .then(res => res.json())
      .then(data => {
        country.textContent = data.countryName;
        city.textContent = data.city;
        
      })
  }

  const error = () => { 
    locations.textContent = 'Access has been denied'
  }

  navigator.geolocation.getCurrentPosition(success,error)
}

compass.addEventListener('click', showLocation);