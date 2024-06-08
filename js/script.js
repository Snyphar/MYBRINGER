ScrollReveal({
  mobile: false,
}
)

ScrollReveal().reveal('.header', {
  delay: 500,
  reset: false,
  mobile: false,
});

ScrollReveal().reveal('.showcase-content h1', {
  scale: 2,
  duration: 3000,
  mobile: false,
});

ScrollReveal().reveal('.showcase-content', {

  scale: 2,
  duration: 3000,
  delay: 500,
  mobile: false,
});

ScrollReveal().reveal('.showcase-search', {
  duration: 1500,
  delay: 500,
});

ScrollReveal().reveal('.destinations h2', {
  reset: true,
  duration: 1500,
  delay: 500,
  origin: 'left',
  distance: '50px',
});

ScrollReveal().reveal('.destinations-cards', {
  duration: 1500,
});

ScrollReveal().reveal('.section-title', {
  reset: true,
  duration: 1500,
  delay: 500,
  origin: 'left',
  distance: '50px',
});
ScrollReveal().reveal('.hotel-card , #tours, #activities', {
  duration: 1500,
  origin: 'left',
  distance: '50px',
});

ScrollReveal().reveal('.about-content', {
  reset: true,
  duration: 1500,
  origin: 'left',
  distance: '50px',
});
ScrollReveal().reveal('.about-img', {
  reset: true,
  duration: 1500,
  origin: 'right',
  distance: '50px',
});

const swiper = new Swiper('.swiper1', {
  direction: 'horizontal',
  loop: true,
  speed: 600,
  slidesPerView: 6,
  spaceBetween: 10,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    240: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 6,
      spaceBetween: 10,
    },
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  scrollbar: {
    el: '.swiper-scrollbar',
  },
});


// // hotel rxpand collapse fun
// const hotelButton = document.querySelector('.hotel-button');
// const hotelCard = document.querySelectorAll('.off');
// const text = hotelButton.innerText;

hotelButton.addEventListener('click', (e) => {
  e.preventDefault();
  hotelCard.forEach((x) => {
    x.classList.toggle('on');
  });

  if (e.target.innerHTML !== 'less <img src="/Imgs/icons/bleft.png">') {
    e.target.innerHTML = `less <img src="/Imgs/icons/bleft.png" >`;
  } else {
    e.target.innerHTML = `view all <img src="/Imgs/icons/bleft.png" >`;
  }
});



// 
const toogleOn = document.querySelector('.toggleOn');
const toogleClose = document.querySelector('.toggleClose');
const navbar = document.querySelector('.navbar');
const navlists = document.querySelectorAll('.navlist');

toogleOn.addEventListener('click', (e) => {
  e.preventDefault();
  navbar.classList.add('navlistOn');
  toogleClose.classList.add('toggleCloseOn');
  toogleOn.classList.add('toggleOnClose');
});

toogleClose.addEventListener('click', (e) => {
  navbar.classList.remove('navlistOn');
  toogleClose.classList.remove('toggleCloseOn');
  toogleOn.classList.remove('toggleOnClose');
});

console.log('navlists');
navlists.forEach((xy) => {
  xy.addEventListener('click', (x) => {
    navbar.classList.remove('navlistOn');
    toogleClose.classList.remove('toggleCloseOn');
    toogleOn.classList.remove('toggleOnClose');
  });
});

// Add this to your existing script.js file or create a new one
const destinationFilter = document.getElementById('destinationFilter');
const popup = document.getElementById('popup');





function applySelection() {
   // Add logic to handle the selected country and region
   const selectedCountry = document.getElementById('countrySelect').value;
   const selectedRegion = document.getElementById('citySelect').value;
   const selectedType = document.getElementById('destinationType').value;
  console.log("Selected Vlaue: "+selectedCountry+","+selectedRegion+","+ selectedType);
  if(selectedType == '1'){
    console.log("1 select");
    const toCityDiv = document.getElementById('to_city');
    toCityDiv.innerHTML = selectedCountry+","+selectedRegion;
  }
  else if(selectedType == '0'){
    console.log("0 select");
    const fromCityDiv = document.getElementById('from_city');
    fromCityDiv.innerHTML = selectedCountry+","+selectedRegion;
  }
  
   // You can perform further actions with the selected values, such as updating the UI or making an AJAX request.

   // Close the popup after applying the selection
   closePopup();
}
// Function to load JSON file and populate country dropdown
function loadCountries() {
  const countrySelect = document.getElementById('countrySelect');

  // Populate country dropdown
  const option = document.createElement('option');
  option.value = "";
  option.textContent = "--";
  countrySelect.appendChild(option);
  for (const country in countries) {
      const option = document.createElement('option');
      option.value = country;
      option.textContent = country;
      countrySelect.appendChild(option);
  }
}

// Function to update city dropdown based on the selected country
function updateCityDropdown() {
  const countrySelect = document.getElementById('countrySelect');
  const citySelect = document.getElementById('citySelect');
  const selectedCountry = countrySelect.value;

  // Clear existing options
  citySelect.innerHTML = '';

  // Populate city dropdown based on the selected country
  const cities = countries[selectedCountry];
  const option = document.createElement('option');
  option.value = "";
  option.textContent = "--";
  citySelect.appendChild(option);
  if (cities) {
      for (const city of cities) {
          const option = document.createElement('option');
          option.value = city;
          option.textContent = city;
          citySelect.appendChild(option);
      }
  }
}

// Function to open the popup and load countries
function openPopup(destination_type_val) {
  const destinationType = document.getElementById('destinationType');
  destinationType.value = destination_type_val;

  console.log("Destination Type: "+ destination_type_val);
  
  loadCountries();
  document.getElementById('countryPopup').style.display = 'block';
}

function open(destination_type_val) {
  const destinationType = document.getElementById('destinationType');
  destinationType.value = destination_type_val;

  console.log("Destination Type: "+ destination_type_val);
  
  loadCountries();
  document.getElementById('countryPopup').style.display = 'block';
}

// Function to close the popup
function closePopup() {
  document.getElementById('countryPopup').style.display = 'none';
}


function openDate() {
  console.log("date");
  
  //document.getElementById('datePopup').style.display = 'block';
}

// Function to close the popup
function closeDate() {
  document.getElementById('datePopup').style.display = 'none';
}
//$('#pickup_date_range').daterangepicker();

$('#pickup_date_range').daterangepicker({
  autoUpdateInput: false,
  locale: {
      cancelLabel: 'Clear'
  }
});
$('#pickup_date_range').on('apply.daterangepicker', function(ev, picker) {
  $(this).text(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});
$('#pickup_date_range').on('cancel.daterangepicker', function(ev, picker) {
  $(this).text('Choose a Date');
});


$('#destination_date_range').daterangepicker({
  autoUpdateInput: false,
  locale: {
      cancelLabel: 'Clear'
  }
});
$('#destination_date_range').on('apply.daterangepicker', function(ev, picker) {
  $(this).text(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});
$('#destination_date_range').on('cancel.daterangepicker', function(ev, picker) {
  $(this).text('Choose a Date');
});
