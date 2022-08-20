import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import PostContent from './components/Admin/PostContent.vue';
import SummernoteEditor from './parts/SummernoteEditor.vue';
import Swal from 'sweetalert2';
// import SummernoteEditor from 'vue3-summernote-editor';
// import $ from "jquery";
// import CodeEditor from 'simple-code-editor';
// import { VueEditor } from "vue2-editor";
import helpers from './helpers';

// window.$ = window.jQuery = $;

const app = createApp({});
app.component('post-content', PostContent);
// app.component('VueEditor', VueEditor);
// app.component('CodeEditor', CodeEditor);
app.component('SummernoteEditor', SummernoteEditor);
app.provide('helpers', helpers);
app.provide('alert', Swal);
app.mount('#app');
