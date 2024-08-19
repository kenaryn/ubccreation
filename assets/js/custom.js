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

// import { Carousel } from 'bootstrap';

// const carousel = new bootstrap.Carousel('#carousel');

// document.addEventListener("DOMContentLoaded", () => {
//    if (bootstrap.Carousel) {
//       console.log("Carousel fully loaded and parsed!");
//    }
// });

   
// Keep a track of pressed keys.
let pressedKeys = new Set();
let timer = null;

document.addEventListener("keydown", (event) => {
   let logout_btn = document.getElementById('logout');

   // Populate the object with keys'state.
   pressedKeys.add(event.key);
   
   if (event.defaultPrevented) {
      return;  // Do nothing if event is already processed.
   }

   // Clear any existing timer.
   if (timer) {
      clearTimeout(timer);
   }
   
   // Set a delay of 50ms before executing the callback to avoid triggering a combination of a single key.
   timer = setTimeout(() => {
      switch (true) {
         case pressedKeys.has("Control") && pressedKeys.has("a"):
            window.location = 'http://localhost:80/'
            break;
            
         case pressedKeys.has("Control") && pressedKeys.has("d"):
            if (logout_btn != undefined) {
            window.location = 'http://localhost:80/logout';
         }
            break;
         
         case pressedKeys.has("Control") && pressedKeys.has("h"):
            // TODO: add an help-like pop-up to inform user with available shortcuts.
            break;
            
         default:
            return;
      }
      
      event.preventDefault();
   }, 50);
   },
   true
);

// Release the key when released to prevent further awkwardnesses.
document.addEventListener("keyup", (event) => {
  pressedKeys.delete(event.key);
});
