import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Swal = Swal;
window.AOS = AOS;
window.Chart = Chart;

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

    Alpine.data('bannerSlider', (banners) => ({
        banners,
        current: 0,
        init() {
            this.timer = setInterval(() => this.next(), 6000);
        },
        destroy() {
            clearInterval(this.timer);
        },
        prev() {
            this.current = (this.current + this.banners.length - 1) % this.banners.length;
        },
        next() {
            this.current = (this.current + 1) % this.banners.length;
        },
    }));

    Alpine.data('galleryLightbox', (items) => ({
        items,
        openIndex: null,
        get current() {
            return this.openIndex === null ? {} : this.items[this.openIndex];
        },
        open(index) {
            this.openIndex = index;
        },
        close() {
            this.openIndex = null;
        },
        prev() {
            this.openIndex = (this.openIndex + this.items.length - 1) % this.items.length;
        },
        next() {
            this.openIndex = (this.openIndex + 1) % this.items.length;
        },
    }));

    Alpine.data('tiltCard', () => ({
        rx: 0,
        ry: 0,
        tilt(e) {
            const rect = this.$el.getBoundingClientRect();
            const x = (e.clientX - rect.left - rect.width / 2) / (rect.width / 2);
            const y = (e.clientY - rect.top - rect.height / 2) / (rect.height / 2);
            this.rx = -y * 12;
            this.ry = x * 12;
        },
        reset() {
            this.rx = 0;
            this.ry = 0;
        },
    }));

    Alpine.data('chartBar', (labels, values, label) => ({
        init() {
            this.$nextTick(() => {
                new Chart(this.$el, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label,
                            data: values,
                            backgroundColor: 'rgba(212, 138, 30, 0.75)',
                            borderRadius: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(120, 113, 108, 0.12)' },
                            },
                            x: {
                                grid: { display: false },
                            },
                        },
                    },
                });
            });
        },
    }));

    Alpine.data('chartDoughnut', (labels, values) => ({
        init() {
            this.$nextTick(() => {
                new Chart(this.$el, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                'rgba(212, 138, 30, 0.85)',
                                'rgba(120, 62, 25, 0.85)',
                                'rgba(80, 120, 90, 0.85)',
                                'rgba(70, 100, 160, 0.85)',
                                'rgba(180, 80, 90, 0.85)',
                            ],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { usePointStyle: true },
                            },
                        },
                    },
                });
            });
        },
    }));
});

document.addEventListener('DOMContentLoaded', () => {
    window.AOS.init({
        duration: 700,
        once: true,
        offset: 80,
        easing: 'ease-out-cubic',
    });

    const flashSuccess = document.querySelector('meta[name="flash-success"]');
    if (flashSuccess && flashSuccess.content) {
        window.Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: flashSuccess.content,
            confirmButtonColor: '#d48a1e',
            timer: 3500,
            timerProgressBar: true,
        });
    }
});

Alpine.start();
