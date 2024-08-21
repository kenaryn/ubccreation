"use strict";
import * as Geolocation from './geolocation.js';

/* Global keyboard shortcuts */   
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
/* Global keyboard shortcuts - END */


/* Events */

// Release the key when released to prevent further awkwardnesses.
document.addEventListener("keyup", (event) => {
  pressedKeys.delete(event.key);
});


/* Visitor's Geolocation */
if (document.readyState === 'loading') {
   document.addEventListener('DOMContentLoaded', Geolocation.getVisitorCurrentLocation())
} else {
   Geolocation.getVisitorCurrentLocation();
}
/* Visitor's Geolocation - END */

const readYardsLocation = async function () {
   try {
      const response = await fetch('./yards.json');
      const locations = await response.json();

      if (response.ok) {
         console.log('successfully fetch the json file');
      } else {
         console.warn('Failed to retrieve JSON data.');
      }
   } catch (error) {
      console.error("Failed to fetch JSON's yard locations.");
   }
};