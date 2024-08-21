'use strict';

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