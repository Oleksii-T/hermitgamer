import './bootstrap';

// import { createApp } from 'vue';
// createApp(PostContent).mount('#app');

import { createApp } from 'vue/dist/vue.esm-bundler';
import PostContent from './components/Admin/PostContent.vue';
import helpers from './helpers';

const app = createApp({});
app.component('post-content', PostContent);
app.provide('helpers', helpers);
app.mount('#app');
