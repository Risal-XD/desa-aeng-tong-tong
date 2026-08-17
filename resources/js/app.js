import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import { PageFlip } from 'page-flip';

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

    Alpine.data('pinterestMarquee', (photos) => ({
        photos,
        enlarged: null,
        row1: [],
        row2: [],
        init() {
            const base = (photos || []).map((p) => ({
                src: p.image ? '/storage/' + p.image : 'https://images.unsplash.com/photo-1755331039789-7e5680e26e8f?q=80&w=774',
                alt: p.title || 'Galeri Desa',
            }));
            
            // Bagi jadi 2 row
            const half = Math.ceil(base.length / 2);
            const r1 = base.slice(0, half).length ? base.slice(0, half) : base;
            const r2 = base.slice(half).length ? base.slice(half) : base;
            
            // Duplikat secukupnya (min 6-8 item per row) agar track lebar dan loop -50% mulus tanpa glitch/gap
            let list1 = [...r1];
            while (list1.length < 8) list1 = list1.concat(r1);
            let list2 = [...r2];
            while (list2.length < 8) list2 = list2.concat(r2);

            this.row1 = [...list1, ...list1];
            this.row2 = [...list2, ...list2];
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
            this.timer = setInterval(() => this.next(), 2000);
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
                                ticks: { font: { size: 9 }, color: '#737373', maxTicksLimit: 5 },
                            },
                            x: {
                                grid: { color: 'rgba(120, 113, 108, 0.08)' },
                                ticks: { font: { size: 9 }, color: '#525252', maxRotation: 0, minRotation: 0 },
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

    Alpine.data('ebookletFlipbook', (config) => ({
        open: false,
        loading: true,
        error: null,
        totalPages: 0,
        currentPage: 1,
        pageFlip: null,
        scale: 1,
        blobs: [],
        config,

        get workerSrc() {
            return new URL('pdfjs-dist/build/pdf.worker.min.mjs', import.meta.url).toString();
        },

        init() {
            // Viewer hanya terbuka ketika pengguna mengklik buku.
        },

        destroy() {
            this.closeViewer();
        },

        revokeBlobs() {
            this.blobs.forEach((url) => URL.revokeObjectURL(url));
            this.blobs = [];
        },

        nextPage() {
            if (this.pageFlip) this.pageFlip.flipNext('bottom');
        },

        prevPage() {
            if (this.pageFlip) this.pageFlip.flipPrev('top');
        },

        zoomIn() {
            this.scale = Math.min(2, this.scale + 0.2);
            this.applyZoom();
        },

        zoomOut() {
            this.scale = Math.max(0.5, this.scale - 0.2);
            this.applyZoom();
        },

        applyZoom() {
            if (this.pageFlip) {
                const rect = this.pageFlip.getBoundsRect();
                const el = this.$refs.book;
                if (el) {
                    el.style.width = rect.width * this.scale + 'px';
                    el.style.height = rect.height * this.scale + 'px';
                }
            }
        },

        openViewer() {
            this.open = true;
            this.loading = true;
            this.error = null;
            this.totalPages = 0;
            this.currentPage = 1;

            (async () => {
                let pdfjs = null;
                try {
                    pdfjs = await import('pdfjs-dist');
                } catch (err) {
                    this.error = 'Gagal memuat modul pdf.js: ' + (err?.message || err);
                    this.loading = false;
                    console.error(err);
                    return;
                }

                const { GlobalWorkerOptions, getDocument } = pdfjs;
                GlobalWorkerOptions.workerSrc = this.workerSrc;

                let attempt = 0;
                while (attempt < 3) {
                    attempt++;
                    try {
                        const base = new URL(this.config.pdfUrl, window.location.href).href;

                        const pdf = await getDocument({ url: base, rangeChunkSize: 65536 }).promise;

                        const pages = [];
                        for (let i = 1; i <= pdf.numPages; i++) {
                            const page = await pdf.getPage(i);
                            const viewport = page.getViewport({ scale: 4 });
                            if (i === 1) this._viewAspect = viewport.width / viewport.height;
                            const canvas = document.createElement('canvas');
                            canvas.width = Math.floor(viewport.width);
                            canvas.height = Math.floor(viewport.height);
                            const ctx = canvas.getContext('2d');
                            await page.render({ canvasContext: ctx, viewport }).promise;
                            const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/png'));
                            const url = URL.createObjectURL(blob);
                            this.blobs.push(url);
                            pages.push(url);
                            await new Promise((resolve) => setTimeout(resolve, 0));
                        }

                        this.totalPages = pages.length;

                        try {
                            this.$nextTick(() => {
                                const el = this.$refs.book;
                                const stage = el ? el.parentElement : null;
                                const stageW = stage ? Math.max(340, stage.clientWidth - 16) : 900;
                                const stageH = stage ? Math.max(420, stage.clientHeight - 8) : 640;
                                const aspect = this._viewAspect || Math.SQRT1_2;
                                const pageH = Math.min(stageH, 860);
                                const pageW = pageH * aspect;
                                const bookW = Math.min(stageW, pageW * 2);
                                const bookH = (bookW / 2) / aspect;

                                if (el) {
                                    el.style.width = bookW + 'px';
                                    el.style.height = bookH + 'px';
                                }

                                if (!this.pageFlip) {
                                    this.pageFlip = new PageFlip(el, {
                                        width: bookW,
                                        height: bookH,
                                        maxShadowOpacity: 0.5,
                                        showCover: false,
                                        flippingTime: 650,
                                        showPageCorners: true,
                                        mobileScrollSupport: true,
                                        swipeDistance: 25,
                                        clickEventForward: false,
                                    });
                                    this.pageFlip.on('flip', (e) => {
                                        if (this.pageFlip) this.currentPage = this.pageFlip.getCurrentPageIndex() + 1;
                                    });
                                }
                                this.pageFlip.loadFromImages(pages);
                                this.loading = false;
                            });
                            return;
                        } catch (err) {
                            throw new Error('menyiapkan viewer: ' + (err?.message || err));
                        }
                    } catch (err) {
                        console.error('Percobaan ' + attempt + ' gagal:', err);
                        if (attempt >= 3) {
                            this.error = 'Gagal memuat e-booklet: ' + (err?.message || err);
                            this.loading = false;
                        } else {
                            await new Promise((resolve) => setTimeout(resolve, 800));
                        }
                    }
                }
            })();
        },

        closeViewer() {
            this.open = false;
            if (this.pageFlip) {
                this.pageFlip.destroy();
                this.pageFlip = null;
            }
            this.revokeBlobs();
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
