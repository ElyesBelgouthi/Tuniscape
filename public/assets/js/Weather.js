const apiKey = "a5ccb57c995d92ff1acfc9bcd2125e6a";
const marquee = document.querySelector("#marquee");

const regions = fetch("/region")
  .then((response) => response.json())
  .then((data) => {
    const regions = data.map((region) => {
      const { name, latitude, longitude } = region;
      return { name, latitude, longitude };
    });
    console.log(regions);
    return regions; // add this line to return the regions array
  });

const weatherIcon = (weather) => {
  switch (weather) {
    case "Thunderstorm":
      return `<i class="fa-solid fa-cloud-bolt"></i>`;
    case "Drizzle":
      return `<i class="fa-solid fa-cloud-rain"></i>`;
    case "Rain":
      return `<i class="fa-solid fa-cloud-showers-heavy"></i>`;
    case "Snow":
      return `<i class="fa-solid fa-snowflake"></i>`;
    case "Mist":
    case "Smoke":
    case "Haze":
    case "Dust":
    case "Fog":
    case "Sand":
    case "Ash":
      return `<i class="fa-solid fa-smog"></i>`;
    case "Squall":
    case "Tornado":
      return `<i class="fa-solid fa-tornado"></i>`;
    case "Clear":
      return `<i class="fa-solid fa-sun"></i>`;
    case "Clouds":
      return `<i class="fa-solid fa-cloud"></i>`;
    default:
      return ``;
  }
};

const getWeatherData = (lat, lon) => {
  const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;
  // Make the API request using the Fetch API
  return fetch(url)
    .then((response) => response.json())
    .then((data) => {
      const temperature = data.main.temp;
      const weather = data.weather[0].main;
      return { temperature, weather };
    })
    .catch((error) => console.log("error while loading weather information"));
};
let marqueeText = "Live Weather Forecast";
const getWeatherDataForAllCities = (regions) => {
  const promises = regions.map((region) =>
    getWeatherData(region.latitude, region.longitude)
  );
  Promise.all(promises)
    .then((results) => {
      results.forEach((result, index) => {
        const { temperature, weather } = result;
        marqueeText += `| ${regions[index].name}: ${parseInt(
          temperature
        )} °C, ${weatherIcon(weather)}       `;
      });
      marquee.innerHTML = `${marqueeText}`;
    })
    .catch((error) => console.log("error while loading the marquee"));
};

regions.then(getWeatherDataForAllCities);
