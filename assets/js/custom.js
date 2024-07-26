"use strict";

// let slideIndex = 1;
// showSlides(slideIndex);

// function plusSlides(n) {
//   showSlides((slideIndex += n));
// }

// function currentSlide(n) {
//   showSlides((slideIndex = n));
// }

// function showSlides(n) {
//   let i;
//   let d = document;
//   let slides = d.getElementsByClassName("mySlides");
//   let dots = d.getElementsByClassName("demo");
//   let captionText = d.getElementById("caption");

//   if (n > slides.length) slideIndex = 1;
//   if (n < 1) slideIndex = slides.length;

//   for (i = 0; i < slides.length; i++) {
//     slides[i].style.display = "none";
//   }

//   for (i = 0; i < dots.length; i++) {
//     dots[i].className = dots[i].className.replace(" active", "");
//   }

//   slides[slideIndex - 1].style.display = "block";
//   dots[slideIndex - 1].className += " active";
//   captionText.innerHTML = dots[slideIndex - 1].alt;
// }

import { Carousel } from 'bootstrap';

const carousel = new bootstrap.Carousel('#carousel');

document.addEventListener("DOMContentLoaded", () => {
   if (bootstrap.Carousel) {
      console.log("Carousel fully loaded and parsed!");
   }
});