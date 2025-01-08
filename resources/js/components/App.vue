<template>
  <div id="app">
    <!-- Навигация -->
    
    <header id="page-topbar" class="fade-in" v-show="!isSplashVisible" :class="{ 'fixed-position': menuType === 'vertical' }" :style="menuType === 'horizontal' ? { position: 'relative', zIndex: 50000 } : {}">
      <div class="navbar-header">
                          <div class="d-flex">

        <nav :class="['horizontal-menu', menuType === 'horizontal' ? '' : 'hidden']">
        <div class="logotype"><img class="logo" src="https://cdn1.kdt.kz/files/sites/20014/files/456.png?_t=1736155547" /><h6 class="title2"> FILE VAULT </h6></div>
         <div class="menu-items"> <router-link to="/home"> <i class="bx bx-collection me-2"></i> {{ $t('catalog_small') }} </router-link>
          <router-link to="/create"> <i class="bx bx-file me-2"></i> {{ $t('add_file') }}</router-link>
          </div>
<div class="dropdown d-inline-block" style="display: flex !important;" v-if="!isMobile">

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-globe" style="font-size: 19px;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button
                                v-for="locale in locales"
                                :key="locale"
                                @click="changeLanguage(locale)"
                                :class="[ 'dropdown-item', 'notify-item', 'language', { active: $i18n.locale === locale }]"
                                >{{ localeNames[locale] }}</button>
                            </div>
                        </div>

<button
  type="button"
  class="btn header-item noti-icon right-bar-toggle waves-effect"
  @click="toggleMenu">
    <span class="hor_menu">{{ $t('hor_menu') }}</span> <i class="bx bx-cog bx-spin" style="margin-left: 10px;"></i>
</button>

                        </div>


                        <div class="dropdown d-inline-block" style="display: flex !important;" v-else>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-globe" style="font-size: 19px;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button
                                v-for="locale in locales"
                                :key="locale"
                                @click="changeLanguage(locale)"
                                :class="[ 'dropdown-item', 'notify-item', 'language', { active: $i18n.locale === locale }]"
                                >{{ localeNames[locale] }}</button>
                            </div>
                        </div>

<button
  type="button"
  class="btn header-item noti-icon right-bar-toggle waves-effect"
  @click="toggleMenu">
    <i class="bx bx-menu" style="font-size: 24px;"></i>
</button>

                        </div>
        </nav>


        <nav :class="['vertical-menu', 'metismenu', 'list-unstyled', menuType === 'vertical' ? '' : 'hidden']" id="sidebar-menu">
        <div class="logotype"><img class="logo" src="https://cdn1.kdt.kz/files/sites/20014/files/456.png?_t=1736155547" /><h6 class="title2"> FILE VAULT </h6></div>

                                    <li class="menu-title" key="t-menu" style="text-transform: uppercase;">{{ $t('menu') }}</li>
          <router-link to="/home"> <i class="bx bx-collection me-2"></i> {{ $t('catalog_small') }}</router-link>
          <router-link to="/create"> <i class="bx bx-file me-2"></i> {{ $t('add_file') }}</router-link>
                                  <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect" @click="toggleMenu">
                                <i class="bx bx-cog bx-spin" style="margin-right: 10px;"></i> {{ $t('ver_menu') }}
                            </button>
                        </div>

                           <li>
    <a href="javascript:void(0);" class="has-arrow waves-effect" style=" align-items: center; display: flex; justify-content: center;" @click="toggleSubMenu">
      <i class="bx bx-globe me-2" style="font-size: 19px;"></i>
      <span key="t-dashboards">{{ $t('language') }}</span>
      <i :class="['bx', isSubMenuOpen ? 'bx-chevron-up' : 'bx-chevron-down']" style="margin-left: auto;"></i>
    </a>
    <ul class="sub-menu" :class="{ open: isSubMenuOpen }" aria-expanded="false">
      <li>
        <a v-for="locale in locales"
           :key="locale"
           @click="changeLanguage(locale)"
           :class="{ active: $i18n.locale === locale }">
          {{ localeNames[locale] }}
        </a>
      </li>
    </ul>
  </li>
        
        </nav>
        
        </div>
      </div> <!-- Закрывающий тег для navbar-header -->
    </header>

        <div :class="['content', menuType === 'vertical' ? 'shifted' : '']">
    <!-- Основной контент -->
    <router-view @updateSplash="checkSplash"></router-view>
        </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
              isSubMenuOpen: false, // Состояние подменю
      menuType: "horizontal", // Тип меню по умолчанию
      isSplashVisible: false, // Видимость Splash
            locales: ['en', 'ru', 'kk'], // Доступные языки
      localeNames: {
        en: 'English',
        ru: 'Русский',
        kk: 'Қазақша',
        isMobile: false, // Флаг для определения мобильного вида
      },
    };
  },
  methods: {
        toggleSubMenu() {
      this.isSubMenuOpen = !this.isSubMenuOpen; // Переключение состояния подменю
    },
    // Переключение типа меню
    toggleMenu() {
      this.menuType = this.menuType === "horizontal" ? "vertical" : "horizontal";
    },
        handleResize() {
      this.isMobile = window.innerWidth < 800; // Устанавливаем флаг для мобильного вида
    },
    // Обновление состояния Splash
    checkSplash(isVisible) {
      this.isSplashVisible = isVisible;
    },
    changeLanguage(locale) {
      this.$i18n.locale = locale; // Устанавливаем выбранный язык
    },
  },
  mounted() {
    // Проверяем ширину экрана при загрузке
    this.handleResize();

    // Добавляем слушатель изменения размера экрана
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    // Удаляем слушатель изменения размера экрана
    window.removeEventListener("resize", this.handleResize);
  },
};
</script>







<style scoped>

@media (min-width: 1200px) {
    body[data-layout=horizontal] .container-fluid, body[data-layout=horizontal] .navbar-header {
        max-width: 100%;
    }
}

.navbar-header {
margin: 0 !important;
}

.d-flex {
    width: 100%;
}

.btn .bx-menu {
  font-size: 24px;
  margin: 0;
}

@media (max-width: 500px) {
.hor_menu {
    display: none;
}

.content.shifted {
    margin-left: 0 !important;
}
}


@media (max-width: 800px) {

.menu-items {
    display: none;
}
}

li.menu-title {
    color: #6a7187;
    font-size: 16px;
}

.vertical-menu li {
    display: flex;
    flex-direction: column;
}

.vertical-menu a {
    width: 140px;
}

.sub-menu {
  display: none;
  list-style: none;
  margin-left: 20px;
  padding: 10px 0;
  transition: all 0.3s ease;
}

.sub-menu.open {
  display: block;
}


.fixed-position {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
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


/* Стили для переключателя */
.menu-toggle {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
  gap: 10px;
}

.menu-toggle button {
  padding: 10px 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background: #f4f4f4;
  cursor: pointer;
  font-size: 14px;
}

.menu-toggle button.active {
  background: #007bff;
  color: white;
  border-color: #007bff;
}

/* Горизонтальное меню */
.horizontal-menu {
  display: flex;
  gap: 20px;
  background: #007bff;
  padding: 10px;
    opacity: 1;
  transform: translateY(0);
  visibility: visible;
      transition: all 1s ease;
      width: 100%;
}





.horizontal-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 15px;
        padding-right: 20px;
}

/* Боковое меню */
.vertical-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 210px;
  height: 100vh;
  background: #333;
      padding: 35px 10px 20px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding-top: 50px;
      opacity: 1;
  transform: translateX(0);
  visibility: visible;
      transition: all 1s ease;
}




.vertical-menu a {
  display: block;
  color: white;
  text-decoration: none;
  font-size: 15px;
    margin-bottom: 10px;
    left: -5px;
    position: relative;
}


.vertical-menu .logotype {
    font-size: 25px;
    margin-bottom: 10px;
    align-items: center;
    left: -5px;
    position: relative;
    padding-left: 0px;
}

.vertical-menu .logo {
    margin-bottom: 3px;
}

.content {
  margin-left: 0;
  transition: margin-left 0.3s ease; /* Плавный переход */
}



/* Контент при боковом меню */
.content.shifted {
    margin-left: 210px;
    height: 100%;
    position: relative;
}



.horizontal-menu + .content {
  margin-left: 0; /* Убираем отступ, если меню горизонтальное */
}

/* Стили навигации */
nav {
  display: flex;
  gap: 20px;
  padding: 10px;
  background-color: #f5f5f5;
    transition: all 0.3s ease; /* Плавный переход для всех свойств */
}




/* Скрытие горизонтального меню */
.horizontal-menu.hidden {
  opacity: 0;
  transform: translateY(-20px);
  visibility: hidden;
      transition: all 1s ease;
}



/* Скрытие бокового меню */
.vertical-menu.hidden {
  opacity: 0;
  transform: translateX(-20px);
  visibility: hidden;
      transition: all 1s ease;
}





nav a {
  text-decoration: none;
      color: #e9ecef;
}




nav a:hover {
        color: #45abfe;
    transition: all 0.3s ease;
}
.waves-effect:hover {
    color: #45abfe;
    transition: all .3s ease;
}

@font-face {
  font-family: 'Rubik-Light'; 
  src: url('https://cdn1.kdt.kz/files/sites/20014/files/Fonts/Rubik-Light.otf') format('opentype'); 
  font-style: normal; 
          font-display: swap;
  font-weight: normal; 
} 

@font-face {
  font-family: 'comfortaa'; 
  src: url('https://cdn1.kdt.kz/files/sites/20014/files/Fonts/comfortaa.otf') format('opentype'); 
  font-style: normal; 
          font-display: swap;
  font-weight: normal; 
} 


@font-face {
  font-family: 'LeagueSpartan'; 
  src: url('https://cdn1.kdt.kz/files/sites/20014/files/LeagueSpartan-VariableFont_wght.otf') format('opentype'); 
  font-style: normal; 
          font-display: swap;
  font-weight: normal; 
} 


@font-face {
  font-family: 'Sanchez-Regular'; 
  src: url('https://cdn1.kdt.kz/files/sites/20014/files/Sanchez-Regular.otf') format('opentype'); 
  font-style: normal; 
          font-display: swap;
  font-weight: normal; 
} 




nav {
    background-color: #2a3042 !important;   
font-family: 'Rubik-Light';
    padding: 0;
    align-items: center;
    justify-content: center;
    height: 50px;
}

.title2 {
        display: flex;
    position: relative;
    color: white;
    margin: 0;
    font-weight: 600;
    font-size: 18px;
}

.horizontal-menu .title2 {
        font-size: 15px;
}

.horizontal-menu .logo {
        width: 25px;
}

.logo {
    width: 33px;
        margin-right: 6px;
}

.logotype {
    display: flex;
    align-items: center;
    padding-left: 15px;
}

.waves-effect {
        align-items: center;
    display: flex;
        color: white;
            font-size: 14px;
}

.waves-effect i {
    font-size: 19px;
}

.horizontal-menu {
    justify-content: space-between;
}

.menu-items {
    left: 40px;
    position: relative;
}



.language-switcher {
  display: flex;
  gap: 10px;
  justify-content: center;
  margin: 20px 0;
}

.language-switcher button {
  padding: 10px 20px;
  border: none;
  background-color: #f0f0f0;
  cursor: pointer;
  border-radius: 5px;
  font-size: 14px;
}

.language-switcher button.active {
  background-color: #2e9bf3;
  color: white;
}

</style>

