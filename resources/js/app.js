import './bootstrap';
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import App from "./components/App.vue";
import Splash from "./components/Splash.vue";
import i18n from './i18n';

// Импорт компонентов
import FileList from "./components/FileList.vue";
import FileForm from "./components/FileForm.vue";

// Настройка маршрутов
const routes = [
    { path: "/", component: Splash },
    { path: "/home", component: FileList },
  { path: "/create", component: FileForm }, // Страница создания файла
  { path: "/edit/:id", name: "EditFile", component: FileForm, props: true }, // Страница редактирования файла
];
  

const router = createRouter({
  history: createWebHistory(), // Исторический режим
  routes,
});

// Создание приложения Vue
createApp(App)
  .use(router) // Подключение Vue Router
  .use(i18n)
  .mount("#app");



