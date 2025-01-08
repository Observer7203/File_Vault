import { createRouter, createWebHistory } from "vue-router";
import FileList from "./components/FileList.vue";
import FileForm from "./components/FileForm.vue";


const routes = [
    { path: "/", component: FileList }, // Главная страница
    { path: "/create", component: FileForm }, // Страница создания файла
    { path: "/edit/:id", name: "EditFile", component: FileForm, props: true }, // Страница редактирования файла
  ];


const router = createRouter({
  history: createWebHistory(), // Используй "history" для работы с URL без хэша
  routes,
});

export default router;
