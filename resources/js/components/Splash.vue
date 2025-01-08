<template>
  <div class="splash fade-in">
    <div class="overlay"></div>
    <img src="https://cdn1.kdt.kz/files/sites/20014/files/456.png?_t=1736155547" alt="Логотип" class="logo2">
    <h1 class="title-preview">FILE VAULT</h1>
    <p class="text-preview">storage for all file types</p>
    <router-link to="/home" class="start-button">НАЧАТЬ</router-link>
  </div>
</template>

<script>
export default {
  name: "Splash",
  mounted() {
    // Сообщаем родительскому компоненту, что Splash отображается
    this.$emit("updateSplash", true);
  },
  beforeUnmount() {
    // Сообщаем родительскому компоненту, что Splash скрыт
    this.$emit("updateSplash", false);
  },
};
</script>



<style scoped>

.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 1.5s ease-in-out forwards;
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


.splash {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
    height: 100vh;
}

.logo {
  max-width: 300px;
  margin-bottom: 20px;
}

p {
  font-size: 18px;
  color: #555;
}

.start-button {
padding: 10px 25px;
    font-size: 1rem;
    border: none;
    color: #343a40;
    background-color: #fff;
    cursor: pointer;
    border-radius: 10px;
    box-shadow: 0 5px 15px #88898c;
    transition: .5s;
    font-family: 'Rubik-Light';
    font-weight: 550;
    Z-INDEX: 1;
}

.start-button:hover {
    background-color: #2e9bf3;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 20px 40px #314068;
}

.splash {
    background: url('https://cdn1.kdt.kz/files/sites/20014/files/2147656715.jpg?_t=1736262300') !important;
}

.splash .overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(45deg, #0d1128 0%, #0a5eac 100%);
    opacity: .5;
    Z-INDEX: 1;
}

.horizontal-menu {
    display: none !important;
}

.logo2 {
    width: 250px;
    Z-INDEX: 2;
}

.title-preview {
    font-size: 75px;
    Z-INDEX: 2;
    font-weight: bold;
    color: white;
}

.text-preview {
    Z-INDEX: 2;
    color: white;
    margin-bottom: 20px;
    font-size: 22px;
    text-transform: uppercase;
}

</style>
