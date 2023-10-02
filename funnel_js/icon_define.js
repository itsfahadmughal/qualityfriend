// Function to create the icon grid


const icons = [
    "fas fa-angry","fas fa-grin","fas fa-flushed","fas fa-dizzy","fas fa-frown","fas fa-grimace","fas fa-grin-beam","fas fa-laugh","fas fa-laugh-wink","fas fa-meh","fas fa-sad-cry","fas fa-sad-tear","fas fa-smile","fas fa-smile-beam","fas fa-surprise","fas fa-guitar","fas fa-drum","fas fa-bowling-ball","fas fa-basketball-ball","fas fa-football-ball","fas fa-volleyball-ball","fas fa-baseball-ball","fas fa-globe-africa","fas fa-globe-americas","fas fa-globe-europe","fas fa-landmark","fas fa-gas-pump","fas fa-battery-full","fas fa-battery-half","fas fa-battery-empty","fas fa-battery-quarter","fas fa-wifi","fas fa-skull","fas fa-ghost","fas fa-robot","fas fa-dragon","fas fa-gem","fas fa-dice","fas fa-chess-knight","fas fa-chess-king","fas fa-chess-pawn","fas fa-chess-queen","fas fa-chess-rook","fas fa-bell","fas fa-bookmark","fas fa-cloud","fas fa-envelope","fas fa-heart","fas fa-key","fas fa-star","fas fa-user","fas fa-wrench","fas fa-camera","fas fa-globe","fas fa-headphones","fas fa-umbrella","fas fa-laptop","fas fa-briefcase","fas fa-calendar","fas fa-certificate","fas fa-coffee","fas fa-fire","fas fa-graduation-cap","fas fa-language","fas fa-music","fas fa-pen","fas fa-suitcase","fas fa-tv","fas fa-lightbulb","fas fa-moon","fas fa-sun","fas fa-rocket","fas fa-train","fas fa-bicycle","fas fa-plane","fas fa-car","fas fa-ship","fas fa-money-bill","fas fa-credit-card","fas fa-coins","fas fa-shopping-cart","fas fa-heartbeat","fas fa-hospital","fas fa-paw","fas fa-snowflake","fas fa-socks","fas fa-swimmer","fas fa-tree","fas fa-umbrella-beach","fas fa-wine-glass","fas fa-hiking","fas fa-mountain","fas fa-campground","fas fa-bug","fas fa-cat","fas fa-space-shuttle","fas fa-motorcycle","fas fa-bell-slash","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-chart-bar","fas fa-chart-pie","fas fa-comments","fas fa-edit","fas fa-file","fas fa-flag","fas fa-gamepad","fas fa-keyboard","fas fa-microphone","fas fa-newspaper","fas fa-palette","fas fa-search","fas fa-video","fas fa-dumbbell","fas fa-golf-ball","fas fa-biohazard","fas fa-flask","fas fa-temperature-low","fas fa-temperature-high","fas fa-mask","fas fa-handshake","fas fa-thumbs-up","fas fa-thumbs-down","fas fa-anchor","fas fa-bolt","fas fa-desktop","fas fa-hammer","fas fa-inbox","fas fa-leaf","fas fa-magic","fas fa-satellite-dish","fas fa-tachometer-alt","fas fa-thumbtack","fas fa-tractor","fas fa-user-secret","fas fa-voicemail","fas fa-wallet","fas fa-yin-yang","fas fa-chess-bishop","fas fa-bomb","fas fa-clock","fas fa-cube","fas fa-database","fas fa-eye","fas fa-film","fas fa-gift","fas fa-hamburger","fas fa-ice-cream","fas fa-map","fas fa-pizza-slice","fas fa-scroll","fas fa-shield-alt","fas fa-trophy","fas fa-university","fas fa-book","fas fa-cog","fas fa-compass","fas fa-paint-brush","fas fa-address-book","fas fa-adjust","fas fa-align-center","fas fa-align-justify","fas fa-align-left","fas fa-align-right","fas fa-archive","fas fa-arrow-alt-circle-down","fas fa-arrow-alt-circle-left","fas fa-arrow-alt-circle-right","fas fa-arrow-alt-circle-up","fas fa-arrow-circle-down","fas fa-arrow-circle-left","fas fa-arrow-circle-right","fas fa-arrow-circle-up","fas fa-home","fas fa-paper-plane","fas fa-phone","fas fa-user-plus","fas fa-user-tie","fas fa-id-card","fas fa-id-badge","fas fa-file-signature","fas fa-pen-alt","fas fa-briefcase-medical","fas fa-clipboard-list","fas fa-clipboard-check","fas fa-money-check","fas fa-chart-line","fas fa-file-invoice-dollar","fas fa-file-alt","fas fa-folder-open","fas fa-comment-alt","fas fa-phone-alt","fas fa-envelope-open-text","fas fa-bullhorn","fas fa-hourglass-start","fas fa-hourglass-end","fas fa-bed","fas fa-bath","fas fa-hot-tub","fas fa-utensils","fas fa-cocktail","fas fa-mug-hot","fas fa-concierge-bell","fas fa-luggage-cart","fas fa-shuttle-van","fas fa-swimming-pool","fas fa-spa","fas fa-passport","fas fa-hotel","fas fa-building","fas fa-map-marked-alt","fas fa-receipt","fas fa-check-double","fas fa-door-open","fas fa-door-closed","fas fa-spray-can","fas fa-broom","fas fa-trash","fas fa-recycle","fas fa-soap","fas fa-toilet-paper","fas fa-sink","fas fa-shower","fas fa-male","fas fa-female","fas fa-cloud-sun","fas fa-cloud-moon","fas fa-cloud-rain","fas fa-cloud-sun-rain","fas fa-cloud-moon-rain","fas fa-cloud-showers-heavy","fas fa-wind","fas fa-smog","fas fa-ring","fas fa-crown","fas fa-dice-d6","fas fa-star-half-alt","fas fa-star-and-crescent","fas fa-blender","fas fa-bread-slice","fas fa-cheese","fas fa-cookie","fas fa-glass-cheers","fas fa-beer","fas fa-wine-bottle","fas fa-hotdog","fas fa-drumstick-bite","fas fa-bone","fas fa-carrot","fas fa-fish","fas fa-egg","fas fa-bacon","fas fa-pepper-hot","fas fa-cross","fas fa-crosshairs","fas fa-plus","fas fa-times","fas fa-times-circle","fas fa-window-close","fas fa-skull-crossbones","fas fa-hand-holding","fas fa-hand-holding-heart","fas fa-hand-holding-usd","fas fa-hand-lizard","fas fa-hand-middle-finger","fas fa-hand-paper","fas fa-hand-peace","fas fa-hand-point-down","fas fa-hand-point-left","fas fa-hand-point-right","fas fa-hand-point-up","fas fa-hand-pointer","fas fa-hand-rock","fas fa-hand-scissors","fas fa-hand-sparkles","fas fa-hand-spock","fas fa-hands","fas fa-hands-helping","fas fa-handshake-alt-slash","fas fa-handshake-slash","fas fa-praying-hands" ,
    "fas fa-music",
    "fas fa-headphones",
    "fas fa-microphone",
    "fas fa-volume-up",
    "fas fa-volume-down",
    "fas fa-play",
    "fas fa-pause",
    "fas fa-stop",
    "fas fa-forward",
    "fas fa-backward",
    "fas fa-random",
    "fas fa-music",
    "fas fa-hourglass",
    "fas fa-stopwatch",
    "fas fa-history",
    "fas fa-calendar-alt",
    "fas fa-hourglass-half",
    "fas fa-business-time",
    "fas fa-user-clock",
    "fas fa-stopwatch-20", 
    "fas fa-tools",
    "fas fa-quote-left",
    "fas  fa-seedling",

    "fas fa-shipping-fast",



];

//Just for icons
function createIconGrid() {
    const leftIconGrid = document.getElementById("leftIconGrid");

    let iconRow = '';
    for (let i = 0; i < icons.length; i++) {
        iconRow += `
<div class="col-md-6">
<i class="${icons[i]}" onclick="changeRightIcon('${icons[i]}')"></i>
</div>
`;
    }

    leftIconGrid.innerHTML = '<div class="row">' + iconRow + '</div>';
}
// Call the function to create the icon grid
createIconGrid();

// Function to filter icons based on search input
function filterIcons() {
    const input = document.getElementById("iconSearch");
    const filter = input.value.trim().toUpperCase();
    const icons = document.querySelectorAll("#leftIconGrid i");

    icons.forEach((icon, index) => {
        const iconName = icon.getAttribute("class");
        const col = icon.parentElement;

        if (iconName.toUpperCase().indexOf(filter) > -1) {
            col.style.display = "inline-block";
        } else {
            col.style.display = "none";
        }
    });
}
// Attach event listener to the search input
const searchInput = document.getElementById("iconSearch");
searchInput.addEventListener("input", filterIcons);

//Just for single 
// Function to create the icon grid
function createIconGrid2() {
    const leftIconGrid = document.querySelector(".leftIconGrid");
    let iconRow = '';
    for (let i = 0; i < icons.length; i++) {
        iconRow += `
<div class="col-md-6">
<i class="${icons[i]}" onclick="changeRightIcon_single('${icons[i]}')"></i>
</div>
`;
    }

    leftIconGrid.innerHTML = '<div class="row">' + iconRow + '</div>';
}
// Call the function to create the icon grid
createIconGrid2();

// Function to filter icons based on search input
function filterIcons2() {
    const input = document.querySelector(".iconSearch");
    const filter = input.value.trim().toUpperCase();
    const icons = document.querySelectorAll(".leftIconGrid i");

    icons.forEach((icon, index) => {
        const iconName = icon.getAttribute("class");
        const col = icon.parentElement;

        if (iconName.toUpperCase().indexOf(filter) > -1) {
            col.style.display = "inline-block";
        } else {
            col.style.display = "none";
        }
    });
}

// Attach event listener to the search input
const searchInput2 = document.querySelector(".iconSearch");
searchInput2.addEventListener("input", filterIcons2);
