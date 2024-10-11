const apiKey="80367e6db25947a3afb32adc5c50eb44"
const apiUrl="https://api.openweathermap.org/data/2.5/weather?units=metric&q=";
const cityName=document.querySelector('.city')
const temp=document.querySelector('.temp')
const humidity=document.querySelector(".humidity")
const wind=document.querySelector(".wind")
const searchBox=document.querySelector('.search input')
const searchBtn=document.querySelector('.search button')
const weatherIcon=document.querySelector('.weather-icon')
const weather=document.querySelector('.weather')
const error=document.querySelector('.error')

async function checkWeather(city){
    const response=await fetch(apiUrl +city+ `&appid=${apiKey}`)
    if(response.status == 404){
        error.style.display='block'
        weather.style.display='none'
    }else{
        let data=await response.json();
        console.log(data)
        cityName.innerHTML=data.name;
        temp.innerHTML=Math.round(data.main.temp)+` °c`;
        humidity.innerHTML=data.main.humidity+` %`;
        wind.innerHTML=data.wind.speed+` km/h`;
            
        if(data.weather[0].main=="Clouds"){
                weatherIcon.src="img/clouds.png"
            }
        else if(data.weather[0].main=="Clear"){
                weatherIcon.src="img/clear.png"
            }
        else if(data.weather[0].main=="Rain"){
                weatherIcon.src="img/rain.png"
            }
        else if(data.weather[0].main=="Drizzle"){
                weatherIcon.src="img/drizzle.png"
            }
        else if(data.weather[0].main=="Mist"){
                weatherIcon.src="img/mist.png"
            }
        else if(data.weather[0].main=="Snow"){
                weatherIcon.src="img/snow.png.png"
            }
            
        weather.style.display="block"
        error.style.display="none"  

    }

}

searchBtn.addEventListener('click',()=>{
checkWeather(searchBox.value)
})