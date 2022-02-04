
//banner carousel

var slideIndex = 1;
var timer = null;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  clearTimeout(timer);
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  clearTimeout(timer);
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n==undefined){n = ++slideIndex}
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  // slideIndex++;
  // if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  timer = setTimeout(showSlides, 4000);
}




//sponsor slideshow

// var sIndex = 0;
// sponsorCarousel();

// function sponsorCarousel() {
//   var contador;
//   var sSlides = document.getElementsByClassName("slideSponsor");
//   for (contador = 0; contador < sSlides.length; contador++) {
//     sSlides[contador].style.display = "none";  
//   }
//   sIndex++;
//   if (sIndex > sSlides.length) {sIndex = 1}    
//   sSlides[sIndex-1].style.display = "block";  
//   setTimeout(sponsorCarousel, 2000); // Change image every 2 seconds
// }