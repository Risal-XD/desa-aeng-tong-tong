import './bootstrap';
import Alpine from 'alpinejs';
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

Alpine.start();
