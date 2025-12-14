// MENU
function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('menu-hidden');
    menu.classList.toggle('menu-visible');
}

// MODE
document.addEventListener('DOMContentLoaded', () => {
    const btnToggles = document.querySelectorAll('.btn-toggle'); 
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark');
        body.classList.remove('light');
    } else {
        body.classList.add('light');
        body.classList.remove('dark');
    }

    btnToggles.forEach(btn => {
        btn.addEventListener('click', () => {
            if (body.classList.contains('dark')) {
                body.classList.add('light');
                body.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.add('dark');
                body.classList.remove('light');
                localStorage.setItem('theme', 'dark');
            }
        });
    });
});

// ANIMATION
document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.slide-in-left, .slide-in-top, .slide-in-bottom, .slide-in-right');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('slide-in-left')) {
                    entry.target.classList.add('start-animation-left');
                } else if (entry.target.classList.contains('slide-in-top')) {
                    entry.target.classList.add('start-animation-top');
                } else if (entry.target.classList.contains('slide-in-bottom')) {
                    entry.target.classList.add('start-animation-bottom');
                } else if (entry.target.classList.contains('slide-in-right')) {
                    entry.target.classList.add('start-animation-right');
                }
                observer.unobserve(entry.target); 
            }
        });
    }, { threshold: 0.2 });

    elements.forEach(element => observer.observe(element));
});

// CAROUSEL 1
document.body.onload = function () {
    function getImageWidth() {
        return window.innerWidth > 1534 ? 1200 : 800;
    }

    let nbr = 4;
    let p = 0;
    let imgWidth = getImageWidth();
    let container = document.getElementById("container");
    let g = document.getElementById("g");
    let d = document.getElementById("d");

    function updateCarousel() {
        imgWidth = getImageWidth();
        container.style.width = (imgWidth * nbr) + "px";

        document.querySelectorAll(".photo").forEach(photo => {
            photo.style.width = imgWidth + "px";
        });

        updateTransform();
    }

    for (let i = 1; i <= nbr; i++) {
        let div = document.createElement("div");
        div.className = "photo";
        div.style.backgroundImage = `url('img-portfolio/im${i}.png')`;
        div.style.width = imgWidth + "px";
        container.appendChild(div);
    }

    function updateTransform() {
        container.style.transform = `translate(${p * imgWidth}px)`;
        container.style.transition = "all 1s ease";
        afficherMasquer();
    }

    d.onclick = function () {
        if (p > -nbr + 1) p--;
        updateTransform();
    };

    g.onclick = function () {
        if (p < 0) p++;
        updateTransform();
    };

    function afficherMasquer() {
        d.style.visibility = (p === -nbr + 1) ? "hidden" : "visible";
        g.style.visibility = (p === 0) ? "hidden" : "visible";
    }

    window.addEventListener("resize", updateCarousel);

    updateCarousel();
    afficherMasquer();
};

// CAROUSEL 2 ET 3 ET 9 ET 10
document.addEventListener("DOMContentLoaded", function() {
    function initSlider(sliderSelector, nextSelector, prevSelector, dotsSelector) {
        let slider = document.querySelector(sliderSelector + ' .list');
        let items = document.querySelectorAll(sliderSelector + ' .list .item');
        let next = document.querySelector(nextSelector);
        let prev = document.querySelector(prevSelector);
        let dots = document.querySelectorAll(dotsSelector + ' li');

        if (!slider || items.length === 0 || !next || !prev || dots.length === 0) {
            console.error(`Problème avec le slider : ${sliderSelector}`);
            return;
        }

        let active = 0;
        let refreshInterval;

        function startAutoSlide() {
            clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                next.click();
            }, 3000);
        }

        function reloadSlider() {
            let itemWidth = items[0].clientWidth;
            slider.style.transition = 'transform 0.5s ease-in-out';
            slider.style.transform = `translateX(-${active * itemWidth}px)`;

            // Mise à jour des dots
            dots.forEach(dot => dot.classList.remove('active'));
            dots[active].classList.add('active');

            startAutoSlide();
        }

        next.addEventListener("click", function() {
            active = (active + 1) % items.length;
            reloadSlider();
        });

        prev.addEventListener("click", function() {
            active = (active - 1 + items.length) % items.length;
            reloadSlider();
        });

        dots.forEach((dot, index) => {
            dot.addEventListener("click", function() {
                active = index;
                reloadSlider();
            });
        });

        window.addEventListener("resize", reloadSlider);

        startAutoSlide();
    }

    initSlider('.project.second .slider-2', '.project.second #next-2', '.project.second #prev-2', '.project.second .dots');
    initSlider('.project.third .slider', '.project.third #next', '.project.third #prev', '.project.third .dots');
    initSlider('.project.nine .slider', '.project.nine #next', '.project.nine #prev', '.project.nine .dots');
    initSlider('.project.ten .slider', '.project.ten #next', '.project.ten #prev', '.project.ten .dots');
    initSlider('.project.eleven .slider', '.project.eleven #next', '.project.eleven #prev', '.project.eleven .dots');
    initSlider('.project.thirteen .slider', '.project.thirteen #next', '.project.thirteen #prev', '.project.thirteen .dots');
});

// COOKIE
document.addEventListener("DOMContentLoaded", () => {
    const cookieBox = document.querySelector(".wrapper");
    const showCookieBtn = document.getElementById("showCookieBtn");
    const buttons = document.querySelectorAll(".button-cookie");

    const setCookie = (name, value, days) => {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/; SameSite=Lax`;
    };

    const getCookie = (name) => {
        const cookies = document.cookie.split('; ');
        for (let cookie of cookies) {
            let [key, value] = cookie.split('=');
            if (key === name) return value;
        }
        return null;
    };

    const shouldShowCookieBox = () => {
    const cookieStatus = getCookie("cookie-portfolio");
    const lastVisit = parseInt(getCookie("lastVisit"), 10);

    // Si cookie-portfolio existe et vaut "true" ou "false"
    if (cookieStatus !== null) {

        if (!isNaN(lastVisit)) {
            const sevenDays = 7 * 24 * 60 * 60 * 1000;
            if (Date.now() - lastVisit < sevenDays) {
                return false; // Ne pas afficher la popup
            }
        }
    }

    return true; // Par défaut, on affiche
    };

    if (shouldShowCookieBox()) {
        cookieBox.classList.add("show");
    }

    showCookieBtn.addEventListener("click", () => {
        cookieBox.classList.add("show");
        console.log("showCookieBtn:", showCookieBtn);
    });

    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            cookieBox.classList.remove("show");

            if (button.id === "acceptBtn") {
                setCookie("cookie-portfolio", "true", 7);
            } else if (button.id === "declineBtn") {
                setCookie("cookie-portfolio", "false", 7);
            }

            setCookie("lastVisit", Date.now(), 7);
        });
    });

    console.log("Cookies actuels :", document.cookie);
});

// FILTER PROJECTS
    const btnScolaire = document.getElementById('btn-scolaire');
    const btnStage = document.getElementById('btn-stage');
    const btnPersonnel = document.getElementById('btn-personnel');
    const scolaireItems = document.querySelectorAll('.scolaire');
    const stageItems = document.querySelectorAll('.stage');
    const personnelItems = document.querySelectorAll('.personnel');

    // Cacher tous les projets au départ
    scolaireItems.forEach(item => item.style.display = 'none');
    stageItems.forEach(item => item.style.display = 'none');
    personnelItems.forEach(item => item.style.display = 'none');

    btnScolaire.addEventListener('click', () => {
        scolaireItems.forEach(item => item.style.display = 'block');
        stageItems.forEach(item => item.style.display = 'none');
        personnelItems.forEach(item => item.style.display = 'none');
    });

    btnStage.addEventListener('click', () => {
        scolaireItems.forEach(item => item.style.display = 'none');
        stageItems.forEach(item => item.style.display = 'block');
        personnelItems.forEach(item => item.style.display = 'none');
    });

    btnPersonnel.addEventListener('click', () => {
        scolaireItems.forEach(item => item.style.display = 'none');
        stageItems.forEach(item => item.style.display = 'none');
        personnelItems.forEach(item => item.style.display = 'block');
    }
);
