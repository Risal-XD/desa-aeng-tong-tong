import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;
window.AOS = AOS;

document.addEventListener('alpine:init', () => {
    // Register global Alpine data/components untuk frontend publik di sini.
});

document.addEventListener('DOMContentLoaded', () => {
    window.AOS.init({
        duration: 700,
        once: true,
        offset: 80,
        easing: 'ease-out-cubic',
    });
});

Alpine.start();
