<template>
  <div class="file-form fade-in">
    <h1 class="title" style="text-transform: uppercase;">{{ isEditMode ? $t('edit') : $t('add_file') }}</h1>

    <form @submit.prevent="submitForm">
      <div>
        <label for="name">{{ $t('file_name') }}</label>
        <input v-model="fileName" class="inputing" type="text" id="name" :placeholder="$t('input_name')" />
      </div>

      <div
        class="file-drop"
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="handleDrop"
        :class="{ 'file-drop--active': dragging }"
      >
        <input
          type="file"
          ref="fileInput"
          @change="handleFileSelect"
          hidden
        />
        <button type="button" @click="triggerFileInput">{{ $t('upload_file') }}</button>
        <p v-if="file">{{ file.name }}</p>
      </div>

      <p v-if="uploadError" class="error">{{ uploadError }}</p>

      <div v-if="uploadProgress > 0">
        <p>Прогресс: {{ uploadProgress }}%</p>
        <progress :value="uploadProgress" max="100"></progress>
      </div>

      <button class="btn btn-success waves-effect waves-light" type="submit" :disabled="uploadProgress > 0">{{ $t('save') }}</button>
      <button v-if="isEditMode" class="btn btn-danger waves-effect waves-light w-sm" type="button" @click="confirmDelete">{{ $t('delete') }}</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["id"], // Принимаем параметр ID
  data() {
    return {
      fileId: this.id || null, // Используем переданный ID
      fileName: "",
      file: null,
      isEditMode: !!this.id, // Если ID есть, значит режим редактирования
      uploadProgress: 0,
      dragging: false,
      uploadError: null,
    };
  },
  methods: {
    handleDrop(event) {
      this.file = event.dataTransfer.files[0];
      this.dragging = false;
      this.validateFile();
    },
    handleFileSelect(event) {
      this.file = event.target.files[0];
      this.validateFile();
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    validateFile() {
      if (this.file.size > 8 * 1024 * 1024) {
        this.file = null;
        this.uploadError = "Файл превышает максимальный размер 8MB.";
      } else {
        this.uploadError = null;
      }
    },
    submitForm() {
        if (!this.fileName && !this.file) {
    alert("Вы должны указать имя или выбрать файл.");
    return;
  }

  const formData = new FormData();
  formData.append("name", this.fileName || "");
  if (this.file) {
    formData.append("file", this.file);
  }

    // Логируем данные для отладки
  console.log("File ID:", this.fileId); // ID файла
  console.log("File Name:", this.fileName); // Имя файла
  for (let [key, value] of formData.entries()) {
    console.log(`${key}:`, value); // Проверяем содержимое FormData
  }

      const config = {
        onUploadProgress: (event) => {
          this.uploadProgress = Math.round((event.loaded / event.total) * 100);
        },
      };

const request = this.isEditMode
  ? axios.put(`/api/files/${this.fileId}`, formData, config)
  : axios.post(`/api/files`, formData, config);
        

      request
        .then(() => {
                alert("Файл успешно сохранён!");
      this.$router.push("/home");
        })
        .catch((error) => {
          console.error("Ошибка при отправке формы:", error);
          alert("Не удалось загрузить файл. Проверьте подключение или попробуйте снова.");
        });
    },
  },
mounted() {
    if (this.isEditMode) {
      axios.get(`/api/files/${this.fileId}`).then((response) => {
        this.fileName = response.data.name || response.data.original_name;
      }).catch((error) => {
        console.error("Ошибка при загрузке файла:", error);
      });
    }
  },
};
</script>

<style>

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

.file-drop {
  border: 2px dashed #ccc;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s;
  margin: 10px 0;
}


.file-drop--active {
  background-color: #f0f0f0;
}
.error {
  color: red;
  font-size: 14px;
  margin-top: 10px;
}
progress {
  width: 100%;
  height: 10px;
}

.file-form {
    padding: 20px;
    font-family: Arial, sans-serif;
    color: #333;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 8px #0000001a;
      margin: calc(0px + 24px) calc(24px* .75) 60px calc(24px* .75);
}

.title {
        font-size: 20px !important;
    margin-bottom: 20px;
    font-weight: 600;
    color: #343a40;
    font-family: Rubik-Light;
    text-transform: uppercase;
}

label {
    margin-bottom: .5rem;
    font-weight: 700;
    font-family: 'Rubik-Light';
    font-size: 16px;
}

.inputing {
    border: none;
    height: 28px;
    padding-left: 20px;
    background-color: #f3f3f9;
    box-shadow: none;
    border-radius: 30px;
    color: #343a40;
    position: relative;
    margin-left: 10px;
    width: 150px;
}

.file-drop button {
    font-size: 16px;
    font-family: 'Rubik-Light';
}

button.btn.btn-success.waves-effect.waves-light {
    font-size: 14px;
    font-family: 'Rubik-Light';
}

btn btn-danger waves-effect waves-light w-sm {
    margin-left: 10px;
        font-size: 14px;
    font-family: 'Rubik-Light';
}

</style>
