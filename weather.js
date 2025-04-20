const apikey = "09b5b249087ba046c98e390d3575a2a8";
const city_search = document.getElementById("city_search");
const searched_city = document.getElementById("searched_city");
const button = document.getElementById("searchButton");
const temperature = document.getElementById("weather_temperature");
const image = document.getElementById("img");
const main_condition = document.getElementById("main_condition");
const condition = document.getElementById("condition");
const date = document.getElementById("date");
const humidity = document.getElementById("weather_humidity");
const wind_direction = document.getElementById("wind_direction");
const wind = document.getElementById("weather_wind");
const pressure = document.getElementById("weather_pressure");

// Function to fetch and display weather data
async function SearchWeatherBycityName(searchterm) {
    let data;
    const city = searchterm.toLowerCase(); // Ensure city name is consistent for localStorage

    if (navigator.onLine) {
        try {
            // Fetch weather data from API
            const response = await fetch(`http://sangamweather.free.nf/weather/cc.php?q=${searchterm}`);
            data = await response.json();
            // Save data to localStorage
            localStorage.setItem(city, JSON.stringify(data));
        } catch (error) {
            alert("SORRY DEAR CITY NAME NOT FOUND");
        }
    } else {
            data = JSON.parse(localStorage.getItem(city));
            if (!data){
                alert("since,you are offline data is not found in localstorage")
            }
    }
 //updating required data to the webpage by using .innerText
searched_city.innerText = data[0].city;
main_condition.innerText = data[0].main_condition;
temperature.innerText = data[0].temperature + "°C";
date.innerText = "Date: " + data[0].dt;
humidity.innerText = data[0].humidity + "%";
const code = data[0].icon;
const imageUrl = `https://openweathermap.org/img/wn/${code}@2x.png`;
image.setAttribute("src", imageUrl);
condition.innerText = data[0].condition_details;
wind.innerText = data[0].wind + "m/s";
wind_direction.innerText = data[0].windD + "°,";
pressure.innerText = data[0].pressure + "hPa";
}


// Event listener for loading default city weather
window.addEventListener("load", () => {
    SearchWeatherBycityName("Maidstone");
});

// Event listener for search button click
button.addEventListener('click', function(event) {
    event.preventDefault();
    SearchWeatherBycityName(city_search.value);
});
