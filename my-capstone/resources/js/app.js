import './bootstrap';

import Alpine from 'alpinejs';
import flatpickr from "flatpickr";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect/index.js";

console.log("app.js loaded");
console.log("flatpickr object:", flatpickr);
console.log("monthSelectPlugin imported:", monthSelectPlugin);

window.Alpine = Alpine;

Alpine.start();

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
