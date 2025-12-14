// Sélection des éléments du DOM
const container = document.querySelector('.container');
const search = document.querySelector('.search-box button');
const weatherBox = document.querySelector('.weather-box');
const weatherDetails = document.querySelector('.weather-details');
const error404 = document.querySelector('.not-found');
const cityHide = document.querySelector('.city-hide');

// Événement au clic sur le bouton de recherche
search.addEventListener('click', () => {
    const APIKey = 'a5f64511e2117ff9d4efdcbd15a95c1a'; // Clé API OpenWeather
    const city = document.querySelector('.search-box input').value; // Récupère la ville saisie

    if (city === '') return; // Si aucun nom de ville n'est saisi, on ne fait rien

    // Appel à l'API météo
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${APIKey}`)
        .then(response => response.json())
        .then(json => {

            // Si la ville n’est pas trouvée
            if(json.cod == '404') {
                cityHide.textContent = city; // Affiche le nom de la ville en erreur
                container.style.height = '400px'; // Réduit la hauteur du container
                weatherBox.classList.remove('active'); // Cache les données météo
                weatherDetails.classList.remove('active');
                error404.classList.add('active'); // Affiche l’erreur 404
                return;
            }

            // Sélection des éléments d'affichage météo
            const image = document.querySelector('.weather-box img');
            const temperature = document.querySelector('.weather-box .temperature');
            const humidity = document.querySelector('.weather-details .humidity span');
            const wind = document.querySelector('.weather-details .wind span');
            const description = document.querySelector('.weather-box .description');

            // Si la même ville est recherchée, on ne fait rien
            if(cityHide.textContent == city) {
                return;
            } else {
                cityHide.textContent = city; // Met à jour la ville actuelle

                // Affiche la boîte météo avec animation
                container.style.height = '555px';
                container.classList.add('active');
                weatherBox.classList.add('active');
                weatherDetails.classList.add('active');
                error404.classList.remove('active'); // Cache l’erreur si affichée

                // Retire l'animation après 2.5s
                setTimeout(() => {
                    container.classList.remove('active');
                }, 2500);

                // Change l’image selon le type de météo
                switch (json.weather[0].main) {
                    case 'Clear':
                        image.src = 'images/clear.png';
                        break;
                    case 'Rain':
                        image.src = 'images/rain.png';
                        break;
                    case 'Clouds':
                        image.src = 'images/cloud.png';
                        break;
                    case 'Snow':
                        image.src = 'images/snow.png';
                        break;
                    case 'Mist':
                    case 'Haze':
                        image.src = 'images/mist.png';
                        break;
                    default:
                        image.src = 'images/cloud.png';
                }

                // Met à jour les valeurs météo
                temperature.innerHTML = `${parseInt(json.main.temp)}<span>°C</span>`;
                description.innerHTML = json.weather[0].description;
                humidity.innerHTML = `${json.main.humidity}%`;
                wind.innerHTML = `${parseInt(json.wind.speed)}Km/h`;

                // Récupère les éléments à cloner
                const infoWeather = document.querySelector('.info-weather');
                const infoWind = document.querySelector('.info-wind');
                const infoHumidity = document.querySelector('.info-humidity');

                // Clone les éléments météo pour animation
                const elCloneInfoWeather = infoWeather.cloneNode(true);
                const elCloneInfoWind = infoWind.cloneNode(true);
                const elCloneInfoHumidity = infoHumidity.cloneNode(true);

                // Attribue des ID et classes aux clones
                elCloneInfoWeather.id = 'clone-info-weather';
                elCloneInfoWeather.classList.add('active-clone');

                elCloneInfoWind.id = 'clone-info-wind';
                elCloneInfoWind.classList.add('active-clone');

                elCloneInfoHumidity.id = 'clone-info-humidity';
                elCloneInfoHumidity.classList.add('active-clone');

                // Ajoute les clones juste après les originaux (après une courte pause pour synchronisation visuelle)
                setTimeout(() => {
                    infoWeather.insertAdjacentElement("afterend", elCloneInfoWeather);
                    infoHumidity.insertAdjacentElement("afterend", elCloneInfoHumidity);
                    infoWind.insertAdjacentElement("afterend", elCloneInfoWind);
                }, 2200);

                // Récupère tous les anciens clones encore affichés
                const cloneInfoWeather = document.querySelectorAll('.info-weather.active-clone');
                const totalCloneInfoWeather = cloneInfoWeather.length;
                const cloneInfoWeatherFirst = cloneInfoWeather[0];

                const cloneInfoWind = document.querySelectorAll('.info-wind.active-clone');
                const totalCloneInfoWind = cloneInfoWind.length;
                const cloneInfoWindFirst = cloneInfoWind[0];

                const cloneInfoHumidity = document.querySelectorAll('.info-humidity.active-clone');
                const totalCloneInfoHumidity = cloneInfoHumidity.length;
                const cloneInfoHumidityFirst = cloneInfoHumidity[0];

                // Si des clones existent, on les retire après avoir supprimé la classe d’animation
                if(totalCloneInfoWeather > 0) {
                    cloneInfoHumidityFirst.classList.remove('active-clone');
                    cloneInfoWindFirst.classList.remove('active-clone');
                    cloneInfoWeatherFirst.classList.remove('active-clone');

                    setTimeout(() => {
                        cloneInfoWeatherFirst.remove();
                        cloneInfoWindFirst.remove();
                        cloneInfoHumidityFirst.remove();
                    }, 2200);
                }
            }
        });
});
