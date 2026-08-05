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

    Alpine.data('typewriter', (text, speed = 50, delay = 0) => ({
        displayText: '',
        fullText: text,
        speed,
        delay,
        index: 0,
        init() {
            setTimeout(() => this.type(), this.delay);
        },
        type() {
            if (this.index < this.fullText.length) {
                this.displayText += this.fullText.charAt(this.index);
                this.index++;
                setTimeout(() => this.type(), this.speed);
            }
        },
    }));

    Alpine.data('pageParallax', () => ({
        items: [],
        init() {
            this.items = Array.from(this.$el.querySelectorAll('[data-parallax-speed]'));
            this.onScroll = () => {
                if (this._raf) cancelAnimationFrame(this._raf);
                this._raf = requestAnimationFrame(() => this.apply());
            };
            this.apply();
            window.addEventListener('scroll', this.onScroll, { passive: true });
            window.addEventListener('resize', this.onScroll, { passive: true });
        },
        apply() {
            const vh = window.innerHeight;
            this.items.forEach((el) => {
                const speed = parseFloat(el.dataset.parallaxSpeed) || 0;
                const rect = el.getBoundingClientRect();
                if (rect.top < vh && rect.bottom > 0) {
                    const progress = (vh - rect.top) / (vh + rect.height);
                    const target = (progress - 0.5) * speed;
                    if (Math.abs(target - (el._parallaxOffset || 0)) > 0.5) {
                        el._parallaxOffset = target;
                        el.style.transform = `translateY(${target.toFixed(1)}px)`;
                    }
                }
            });
        },
        destroy() {
            window.removeEventListener('scroll', this.onScroll);
            window.removeEventListener('resize', this.onScroll);
            if (this._raf) cancelAnimationFrame(this._raf);
        },
    }));

    Alpine.data('pinterestGallery', (photos) => ({
        photos,
        enlarged: null,
        items: [],
        init() {
            const aspectRatios = ['aspect-[4/3]', 'aspect-[3/4]', 'aspect-square', 'aspect-[16/10]', 'aspect-[9/12]'];
            const base = (photos || []).map((p, i) => ({
                src: p.image ? '/storage/' + p.image : 'https://images.unsplash.com/photo-1755331039789-7e5680e26e8f?q=80&w=774',
                alt: p.title || 'Galeri Desa',
                aspect: aspectRatios[i % aspectRatios.length],
            }));
            // Jika foto sedikit, duplikat agar grid pinterest ramai & bervariasi
            let list = [...base];
            while (list.length < 12 && list.length > 0) {
                list = list.concat(base.map((it, idx) => ({
                    ...it,
                    aspect: aspectRatios[(list.length + idx) % aspectRatios.length]
                })));
            }
            this.items = list;
        },
        openItem(it) {
            this.enlarged = it;
        },
        closeItem() {
            this.enlarged = null;
        },
    }));

    Alpine.data('fadeSlider', (photos) => ({
        photos,
        current: 0,
        init() {
            this.timer = setInterval(() => this.next(), 4000);
        },
        destroy() {
            clearInterval(this.timer);
        },
        prev() {
            this.current = (this.current + this.photos.length - 1) % this.photos.length;
        },
        next() {
            this.current = (this.current + 1) % this.photos.length;
        },
        go(index) {
            this.current = index;
        },
    }));

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
