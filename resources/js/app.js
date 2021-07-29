import { createApp } from 'vue';
import Posts from './components/Posts.vue';

import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';

import App from './components/App.vue';

let app = createApp(App);
app.use(ElementPlus);


app.component('Posts', Posts);

app.mount('#app');
