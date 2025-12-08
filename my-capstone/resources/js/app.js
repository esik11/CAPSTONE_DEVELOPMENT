import './bootstrap';

// Alpine is automatically loaded by Livewire v3
// Do not manually import or start Alpine here

import flatpickr from "flatpickr";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect/index.js";

console.log("app.js loaded");
console.log("flatpickr object:", flatpickr);
console.log("monthSelectPlugin imported:", monthSelectPlugin);

// Conditionally import doctor appointments functionality only on doctor pages
if (document.getElementById('doctor-calendar') || document.getElementById('doctor-appointments-list')) {
    import('./doctor-appointments.js').then(module => {
        console.log('Doctor appointments module loaded');
    }).catch(err => {
        console.error('Error loading doctor appointments module:', err);
    });
}

window.initializeFlatpickr = () => {
    flatpickr(".flatpickr", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "1900-01-01",
        enableTime: false,
    });

    flatpickr(".flatpickr-year", {
        dateFormat: "Y",
        altFormat: "Y",
        maxDate: new Date().getFullYear().toString(),
        minDate: "1900",
        enableTime: false,
    });
};

document.addEventListener('DOMContentLoaded', function() {
    window.initializeFlatpickr();
});
