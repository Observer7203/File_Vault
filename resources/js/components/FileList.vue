<template>

    <!-- Модальное окно удаления -->
    <div v-if="showModal" class="modal">
      <p>{{ $t('confirm_delete') }}</p>
      <div class="modal-actions">
        <button @click="deleteFile" class="modal-button confirm">{{ $t('delete') }}</button>
        <button @click="closeDeleteModal" class="modal-button cancel">{{ $t('cancel') }}</button>
      </div>
    </div>
  <div class="file-list fade-in">


<div class="searchnbuttons">
    <h1 class="title">{{ $t('catalog') }}</h1>
    <!-- Поле поиска -->
    <div class="search-bar app-search">
    <div class="position-relative">
      <input
        v-model="search"
        @input="updateQuery"
        :placeholder="$t('search_placeholder')"
        type="text"
        class="search-input form-control"
      />
      <span class="bx bx-search-alt"></span>
      </div>
    </div>



    <div class="view-toggle nav nav-pills product-view-nav justify-content-end mt-3 mt-sm-0">
  <button
     :class="['nav-link', { active: viewMode === 'table' }]"
    @click="viewMode = 'table'"
  >
    <i class="bx bx-list-ul align-middle"></i>
  </button>
  <button
   :class="['nav-link', { active: viewMode === 'blocks' }]"
    @click="viewMode = 'blocks'"
  >
    <i class="bx bx-grid-alt align-middle"></i>
  </button>
</div>
</div>


    <!-- Таблица файлов -->
    <div v-if="viewMode === 'table'" class="table-wrapper">
      <table class="file-table">
                <thead>
                <tr>
                    <th>{{ $t('preview_one') }}</th>
                    <th>{{ $t('file_names') }}</th>
                    <th>{{ $t('file_size') }}</th>
                    <th>{{ $t('file_extension') }}</th>
                    <th>{{ $t('actions') }}</th>
                </tr>
                </thead>
                    <tbody>
                    <tr v-for="file in files" :key="file.id">
                        <td>
                        <template v-if="isImage(file)">
                            <img
                            :src="`/storage/${file.path}`"
                            style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;"
                            alt="Превью"
                            />
                        </template>
                        <template v-else-if="isVideo(file)">
                            <i class="mdi mdi-video" style="font-size: 48px; color: #757575;"></i>
                        </template>
                        <template v-else-if="isAudio(file)">
                            <i class="mdi mdi-music" style="font-size: 48px; color: #757575;"></i>
                        </template>
                        <template v-else-if="isPDF(file)">
                            <i class="mdi mdi-file" style="font-size: 48px; color: #e53935;"></i>
                        </template>
                        <template v-else>
                            <i class="mdi mdi-file" style="font-size: 48px; color: #757575;"></i>
                        </template>
                        </td>
                                    <td>{{ file.name || file.originalName }}</td>
                                    <td>{{ (file.size / 1024 / 1024).toFixed(2) }}</td>
                                    <td>{{ file.extension }}</td>
<td class="actions">
  <a v-if="isPDF(file)" :href="`/storage/${file.path}`" target="_blank" class="btn btn-info">
    <i class="bx bx-glasses font-size-16 align-middle me-2"></i>
    <span class="action-text">{{ $t('preview') }}</span>
  </a>
  <a v-else :href="`/storage/${file.path}`" target="_blank" class="btn btn-info">
    <i class="bx bx-glasses font-size-16 align-middle me-2"></i>
    <span class="action-text">{{ $t('preview') }}</span>
  </a>
  <a :href="`/storage/${file.path}`" download class="btn btn-success waves-effect waves-light action-link">
    <i class="bx bx-download font-size-16 align-middle me-2"></i>
    <span class="action-text">{{ $t('download') }}</span>
  </a>
  <button @click="editFile(file.id)" type="button" class="btn btn-warning waves-effect waves-light action-button edit">
    <i class="bx bx-edit font-size-16 align-middle me-2"></i>
    <span class="action-text">{{ $t('edit') }}</span>
  </button>
  <button @click="openDeleteModal(file.id)" type="button" class="btn btn-danger waves-effect waves-light action-button delete">
    <i class="bx bx-trash font-size-16 align-middle me-2"></i>
    <span class="action-text">{{ $t('delete') }}</span>
  </button>
</td>
                    </tr>
                    </tbody>
      </table>
    </div>




    <div v-if="viewMode === 'blocks'" class="file-blocks">
  <div v-for="file in files" :key="file.id" class="file-block">
  <template v-if="isImage(file)">
    <img
      :src="`/storage/${file.path}`"
      style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;"
      alt="Превью"
    />
  </template>
  <template v-else-if="isVideo(file)">
    <i class="mdi mdi-video" style="font-size: 48px; color: #757575;"></i>
  </template>
  <template v-else-if="isAudio(file)">
    <i class="mdi mdi-music" style="font-size: 48px; color: #757575;"></i>
  </template>
  <template v-else-if="isPDF(file)">
    <i class="mdi mdi-file" style="font-size: 48px; color: #e53935;"></i>
  </template>
  <template v-else>
    <i class="mdi mdi-file" style="font-size: 48px; color: #757575;"></i>
  </template>
    <div class="file-info">
      <p><strong>{{ $t('file_names') }}:</strong> {{ file.name || file.originalName }}</p>
      <p><strong>{{ $t('file_size') }}:</strong> {{ (file.size / 1024 / 1024).toFixed(2) }} MB</p>
      <p><strong>{{ $t('file_extension') }}:</strong> {{ file.extension }}</p>
    </div>
    <div class="actions">
            <a v-if="isPDF(file)" :href="`/storage/${file.path}`" target="_blank" class="btn btn-info" style="height: 33px;">
  <i class="bx bx-glasses font-size-16 align-middle me-2"></i>
</a>
                      <a v-else :href="`/storage/${file.path}`" target="_blank" class="btn btn-info" style="height: 33px;"> <i class="bx bx-glasses font-size-16 align-middle me-2"></i>
          </a>
          <a :href="`/storage/${file.path}`" download class="btn btn-success waves-effect waves-light action-link"><i class="bx bx-download font-size-16 align-middle me-2"></i></a>
      <button @click="editFile(file.id)" type="button" class="btn btn-warning waves-effect waves-light action-button edit">
                                                <i class="bx bx-edit font-size-16 align-middle me-2"></i></button>
            <button @click="openDeleteModal(file.id)" type="button" class="btn btn-danger waves-effect waves-light action-button delete">
                                                <i class="bx bx-trash font-size-16 align-middle me-2"></i></button>
    </div>
  </div>
</div>


    <!-- Общее количество записей -->
    <p class="total-info">
      {{ $t('total_files') }}: {{ totalFiles }} ({{ $t('current_page') }}: {{ files.length }})
    </p>

    <!-- Пагинация -->
    <div class="pagination">
      <button
        v-for="page in totalPages"
        :key="page"
        @click="goToPage(page)"
        :class="{ active: page === currentPage }"
        class="pagination-button"
      >
        {{ page }}
      </button>
    </div>


  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      files: [], // Список файлов
      search: "",
      currentPage: 1,
      totalFiles: 0,
      totalPages: 1,
      showModal: false, // Отображение модального окна
      currentFile: null, // Текущий файл для просмотра
      fileToDelete: null, // Файл для удаления
      viewMode: "table", // Режим отображения (таблица или блоки)
    };
  },
  methods: {

    handleResize() {
      if (window.innerWidth < 800) {
        this.viewMode = "blocks"; // Переключаем на блоки
      }
    },
    // Получение списка файлов
    fetchFiles() {
      const params = {
        page: this.currentPage,
        search: this.search,
      };
      axios
        .get("/api/files", { params })
        .then((response) => {
          this.files = response.data.data;
          this.totalFiles = response.data.total;
          this.totalPages = Math.ceil(this.totalFiles / 50);
        })
        .catch((error) => {
          console.error("Ошибка загрузки файлов:", error);
        });
    },

    // Обновление строки запроса
    updateQuery() {
      const query = new URLSearchParams({ search: this.search }).toString();
      this.$router.push(`?${query}`);
      this.fetchFiles();
    },

    // Переключение страниц
    goToPage(page) {
      this.currentPage = page;
      this.fetchFiles();
    },

    // Редактирование файла
    editFile(id) {
      this.$router.push(`/edit/${id}`);
    },

    // Открытие модального окна для удаления
    openDeleteModal(id) {
    console.log("Открытие модального окна для файла с ID:", id);
      this.fileToDelete = id;
      this.showModal = true;
    },



    // Закрытие модального окна
    closeDeleteModal() {
      this.fileToDelete = null;
      this.showModal = false;
    },

  // Удаление файла
  deleteFile() {
    axios
      .delete(`/api/files/${this.fileToDelete}`)
      .then(() => {
        this.fetchFiles(); // Обновляем список файлов
        this.closeDeleteModal();
      })
      .catch((error) => {
        console.error("Ошибка при удалении файла:", error);
        alert("Не удалось удалить файл.");
        this.closeDeleteModal();
      });
  },

    // Открытие файла для просмотра
    viewFile(file) {
      window.open(`/storage/${file.path}`, "_blank"); // Открываем файл напрямую
    },

    // Закрытие модального окна
    closeModal() {
      this.showModal = false;
      this.currentFile = null;
    },

    // Проверка типа файла
    isImage(file) {
      return ["jpg", "jpeg", "png", "gif", "bmp"].includes(
        file.extension.toLowerCase()
      );
    },
    isVideo(file) {
      return ["mp4", "webm", "ogg"].includes(file.extension.toLowerCase());
    },
    isAudio(file) {
      return ["mp3", "wav", "ogg"].includes(file.extension.toLowerCase());
    },
    isPDF(file) {
      return file.extension.toLowerCase() === "pdf";
    },
  },
  mounted() {
    const query = new URLSearchParams(window.location.search);
    this.search = query.get("search") || "";
    this.fetchFiles();
    this.handleResize(); // Проверяем ширину при загрузке
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize); // Убираем слушатель при уничтожении компонента
  },
};
</script>



<style scoped>

@media (max-width: 800px) {
.product-view-nav {
    display: none !important;
}

}

@media (max-width: 500px) {
.search-bar {
    left: 50px;
    position: relative;
}
}

@media (max-width: 1000px) {
.file-blocks {
    justify-content: center;
}
}

@media (max-width: 1200px) {
  .action-text {
    display: none; /* Скрываем текст */
  }

  .action-button i {
    margin: 0 !important;
  }

    .action-link i {
    margin: 0 !important;
  }

  td.actions {
    justify-content: center !important;
}

td:last-child {
    width: fit-content !important;
}

.actions .btn-info i {
   margin: 0 !important;
}
}


.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 1s ease-in-out forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Общие стили */
.file-list {
  padding: 20px;
  font-family: Arial, sans-serif;
  color: #333;
  background: #fff;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: calc(0px + 24px) calc(24px* .75) 60px calc(24px* .75);
}

.title {
    font-size: 20px !important;
  margin-bottom: 20px;
  text-align: center;
      font-weight: 600;
    color: #343a40;
    font-family: 'Rubik-Light';
    text-transform: uppercase;
}

td.actions {
    justify-content: space-around;
}

.search-bar {
  margin-bottom: 20px;
  text-align: center;
}


.form-control {
    border: none;
    height: 38px;
    padding-left: 40px;
    padding-right: 20px;
    background-color: #f3f3f9;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-radius: 30px;
    color: #343a40;
    left: -40px;
    position: relative;
}

.table-wrapper {
  overflow-x: auto;
  margin-bottom: 20px;
  font-family: 'Rubik-Light';
}

.file-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: 'Rubik-Light';
}

.file-table th,
.file-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.file-table th {
  background: #f8f8fb;
  font-weight: bold;
}

p.total-info {
    font-family: 'Rubik-Light';
}

.thumbnail {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 4px;
  border: 1px solid #ddd;
}

.actions {
  display: flex;
  gap: 10px;
}

.action-link {
  color: #007bff;
  text-decoration: none;
}

.action-button {
  padding: 6px 10px;
  font-size: 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.action-button.edit {
    background: #f1b44c;
    color: #fff;
}

.action-button.delete {
  background: #f46a6a;
  color: #fff;
}

.btn-danger:hover {
    color: #fff;
    text-decoration: none;
    background-color: #cf5a5a;
    border-color: #c35555;
}

.btn-danger {
        transition: all .3s ease;
}

/* Пагинация */
.pagination {
  text-align: center;
  justify-content: center;
}

.pagination-button {
  padding: 8px 12px;
  margin: 0 5px;
  border: 1px solid #ccc;
  background: #fff;
  border-radius: 4px;
  cursor: pointer;
}

.pagination-button.active {
    background: #2e9bf3;
    color: #fff;
    border-color: #007bff;
}

/* Модальное окно */
.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}


.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  width: 300px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.modal-actions {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
}


.modal-button {
    padding: 4px 13px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-family: 'Rubik-Light';
}

.modal-button.confirm {
  background: #28a745;
  color: white;
}

.modal-button.cancel {
  background: #6c757d;
  color: white;
}

.view-toggle {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
  gap: 10px;
}


.view-toggle button {
    padding: 10px 15px;
    cursor: pointer;
    width: 40px;
    height: 40px;
    font-size: 18px;
    padding: 0;
    line-height: 36px;
    text-align: center;
    border-radius: 4px;
}

.view-toggle button.active {
      background: #2e9bf3;
  color: white;
  border-color: #007bff;
      transition: all .3s ease;
}


.file-blocks {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
      font-family: 'Rubik-Light';
}


.file-block {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0 2px 4px #0000001a;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    margin-bottom: 20px;
    justify-content: center;
    align-items: center;
    height: 260px;
}

.file-block .btn i {
    margin-right: 0px !important;
}

tr {
    border-bottom: 1px solid #eee;
}


.file-block img.thumbnail {
  display: block;
  width: 100%;
  height: 150px;
  object-fit: cover;
  margin-bottom: 10px;
}

.file-info {
  margin-bottom: 10px;
}

.file-info p {
  margin: 5px 0;
}

.app-search span {
    position: relative;
    z-index: 10;
    font-size: 16px;
    line-height: 38px;
    left: -130px;
    top: -37px;
    color: #74788d;
}

.nav-link:focus, .nav-link:hover {
    color: #4458b8;
    text-decoration: none;
}

.nav-link {
        color: #343a40;
}


.searchnbuttons {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
        flex-wrap: wrap;
}

.btn-warning {
    --bs-btn-color: #fff;
    --bs-btn-bg: #f1b44c;
    --bs-btn-border-color: #f1b44c;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #cd9941;
    --bs-btn-hover-border-color: #c1903d;
    --bs-btn-focus-shadow-rgb: 243, 191, 103;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #c1903d;
    --bs-btn-active-border-color: #b58739;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #f1b44c;
    --bs-btn-disabled-border-color: #f1b44c;
        transition: all .3s ease;
}

.btn-warning:hover {
    color: var(--bs-btn-hover-color);
    text-decoration: none;
    background-color: var(--bs-btn-hover-bg);
    border-color: var(--bs-btn-hover-border-color);
}

.btn-success {
    background-color: #34c38f;
    color: #fff !important;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-success:hover {
    color: #fff;
    text-decoration: none;
    background-color: #2ca67a;
    border-color: #2a9c72;
}

th {
    width: 200px;
}

.file-block {
    width: 270px;
}

td {
    min-height: 126px;
    align-items: center;
}

.waves-effect {
    height: fit-content;
}

.file-table th:last-child,
.file-table td:last-child {
      width: 515px;
}

.position-relative {
    height: 40px;
}

.modal {
    display: block;
    width: auto;
    height: auto;
}

</style>

