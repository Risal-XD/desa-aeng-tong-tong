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

    Alpine.data('domeGallery', (photos) => ({
        photos,
        seg: 35,
        rotation: { x: 0, y: 0 },
        dragging: false,
        startX: 0,
        startY: 0,
        startRotX: 0,
        startRotY: 0,
        enlarged: null,
        items: [],
        init() {
            const pool = (photos || []).map((p) => ({
                src: p.image ? '/storage/' + p.image : '',
                alt: p.title || 'Galeri Desa',
            }));
            this.items = this.buildItems(pool, this.seg);
            this.attachMove();
        },
        buildItems(pool, seg) {
            const xCols = Array.from({ length: seg }, (_, i) => -37 + i * 2);
            const evenYs = [-4, -2, 0, 2, 4];
            const oddYs = [-3, -1, 1, 3, 5];
            const coords = xCols.flatMap((x, c) => {
                const ys = c % 2 === 0 ? evenYs : oddYs;
                return ys.map((y) => ({ x, y, sizeX: 2, sizeY: 2 }));
            });
            const fill = (src, alt) => {
                if (!src) return 'https://images.unsplash.com/photo-1755331039789-7e5680e26e8f?q=80&w=774';
                return src;
            };
            return coords.map((c, i) => ({
                ...c,
                src: fill(pool[i % pool.length]?.src || '', i),
                alt: pool[i % pool.length]?.alt || 'Galeri Desa',
            }));
        },
        itemTransform(it) {
            const unitY = 360 / this.seg / 2;
            const rotateY = unitY * (it.x + (it.sizeX - 1) / 2);
            const rotateX = unitY * (it.y - (it.sizeY - 1) / 2);
            return `rotateY(${rotateY}deg) rotateX(${rotateX}deg) translateZ(var(--radius))`;
        },
        startDrag(e) {
            this.dragging = true;
            this.startX = e.clientX || e.touches?.[0]?.clientX || 0;
            this.startY = e.clientY || e.touches?.[0]?.clientY || 0;
            this.startRotX = this.rotation.x;
            this.startRotY = this.rotation.y;
        },
        onDrag(e) {
            if (!this.dragging) return;
            const clientX = e.clientX || e.touches?.[0]?.clientX || 0;
            const clientY = e.clientY || e.touches?.[0]?.clientY || 0;
            const dx = clientX - this.startX;
            const dy = clientY - this.startY;
            this.rotation.y = this.startRotY + dx / 15;
            this.rotation.x = Math.max(Math.min(this.startRotX - dy / 15, 15), -15);
            this.applyRotation();
            e.preventDefault && e.preventDefault();
        },
        stopDrag() {
            this.dragging = false;
        },
        applyRotation() {
            const sphere = this.$refs.sphere;
            if (sphere) {
                sphere.style.transform = `translateZ(calc(var(--radius) * -1)) rotateX(${this.rotation.x}deg) rotateY(${this.rotation.y}deg)`;
            }
        },
        attachMove() {
            const onMove = (e) => this.onDrag(e);
            const onUp = () => this.stopDrag();
            this._cleanup = () => {
                window.removeEventListener('mousemove', onMove);
                window.removeEventListener('mouseup', onUp);
                window.removeEventListener('touchmove', onMove);
                window.removeEventListener('touchend', onUp);
            };
            window.addEventListener('mousemove', onMove);
            window.addEventListener('mouseup', onUp);
            window.addEventListener('touchmove', onMove, { passive: false });
            window.addEventListener('touchend', onUp);
        },
        destroy() {
            if (this._cleanup) this._cleanup();
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
