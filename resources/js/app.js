import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;
window.AOS = AOS;

document.addEventListener('alpine:init', () => {
    Alpine.store('mobileNav', {
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
    });
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
