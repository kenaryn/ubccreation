"use strict";

/* Global keyboard shortcuts */   
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


// HTML nodes
const modal = document.querySelector('.custom-modal');
const overlay = document.querySelector('.overlay');
const btnCloseModal = document.querySelector('.close-modal');
const btnOpenModal = document.querySelector('.show-modal');

const openModal = function () {
   modal.classList.remove('hidden');
   overlay.classList.remove('hidden');
}

const closeModal = function () {
   modal.classList.add('hidden');
   overlay.classList.add('hidden');
}

/* Events */

// Release the key when released to prevent further awkwardnesses.
document.addEventListener("keyup", (event) => {
  pressedKeys.delete(event.key);
});

btnOpenModal.addEventListener('click', openModal, true);
btnCloseModal.addEventListener('click', closeModal, true);
overlay.addEventListener('click', closeModal, true);

document.addEventListener('keydown', (event) => {
   pressedKeys.add(event.key);

   // Do no thing if event already processed.
   if (event.defaultPrevented) {
      return;
   }
   
   if (pressedKeys.has('Escape') && !modal.classList.contains('hidden')) {
      closeModal();
   }

   // Prevent event from being dealt with twice.
   event.preventDefault();
   // event.stopPropagation();
}, true);