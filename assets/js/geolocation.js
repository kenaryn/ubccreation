'use strict';

const location_options = {
   enableHighAccuracy: true,
   timeOut: 5000,
   maximumAge: 0,
};

const success = function (pos) {
   const crd = pos.coords;

   console.log('Your current location is:');
   console.log(`Latitude: ${crd.latitude}`);
   console.log(`Longitude: ${crd.longitude}`);
   console.log(`Error margin: ${crd.accuracy} meters.`);
};

const printErrorVisitorLocation = function (err) {
   console.warn(`ERROR(${err.code}): ${err.message}`);
};

export const getVisitorCurrentLocation = function () {
   /**
    * Retrieve current visitor's location using Geolocation API.
    */
   navigator.geolocation.getCurrentPosition(success, printErrorVisitorLocation, location_options);
};
