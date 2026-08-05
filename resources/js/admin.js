import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import * as pdfjsLib from 'pdfjs-dist';

import {
    ClassicEditor,
    Alignment,
    AutoLink,
    BlockQuote,
    Bold,
    Essentials,
    Heading,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    List,
    ListProperties,
    MediaEmbed,
    Paragraph,
    RemoveFormat,
    Strikethrough,
    Table,
    TableToolbar,
    TextTransformation,
    Underline,
    Undo,
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

window.Alpine = Alpine;
window.Swal = Swal;
window.Chart = Chart;
window.pdfjsLib = pdfjsLib;

document.addEventListener('alpine:init', () => {
    Alpine.data('card3D', () => ({
        rotateX: 0,
        rotateY: 0,
        handleMove(e) {
            const rect = this.$el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xc = rect.width / 2;
            const yc = rect.height / 2;
            this.rotateX = -((y - yc) / yc) * 10;
            this.rotateY = ((x - xc) / xc) * 10;
        },
        handleLeave() {
            this.rotateX = 0;
            this.rotateY = 0;
        }
    }));
});

pdfjsLib.GlobalWorkerOptions.workerSrc = new URL(
    'pdfjs-dist/build/pdf.worker.min.mjs',
    import.meta.url,
).toString();

window.initCkeditor = (element, config = {}) => {
    return ClassicEditor.create(element, {
        plugins: [
            Alignment,
            AutoLink,
            BlockQuote,
            Bold,
            Essentials,
            Heading,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            Indent,
            IndentBlock,
            Italic,
            Link,
            List,
            ListProperties,
            MediaEmbed,
            Paragraph,
            RemoveFormat,
            Strikethrough,
            Table,
            TableToolbar,
            TextTransformation,
            Underline,
            Undo,
        ],
        toolbar: [
            'undo',
            'redo',
            '|',
            'heading',
            '|',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'removeFormat',
            '|',
            'bulletedList',
            'numberedList',
            '|',
            'alignment',
            'outdent',
            'indent',
            '|',
            'link',
            'blockQuote',
            'insertTable',
            'mediaEmbed',
            '|',
            'imageUpload',
        ],
        image: {
            toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:block', 'imageStyle:alignRight'],
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
        },
        ...config,
    });
};

document.addEventListener('alpine:init', () => {
    // Register global Alpine data/components untuk panel admin di sini.
});

Alpine.plugin(collapse);
Alpine.start();
