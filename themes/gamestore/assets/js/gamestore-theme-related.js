// Получение сохранённого состояния темы из localStorage
let styleMode = localStorage.getItem('styleMode');
const styleToggle = document.querySelector('.header-mode-switcher');

// Функция включения тёмной темы
const enableDarkStyle = () => {
  document.body.classList.add('dark-mode-gamestore');
  localStorage.setItem('styleMode', 'dark'); // Сохранение в localStorage
};

// Функция отключения тёмной темы
const disableDarkStyle = () => {
  document.body.classList.remove('dark-mode-gamestore');
  localStorage.setItem('styleMode', 'light'); // Сохранение в localStorage
};

// Установка начального состояния темы при загрузке страницы
if (styleMode === 'dark') {
  enableDarkStyle();
}

// Добавление обработчика события для переключения темы
if (styleToggle) {
  styleToggle.addEventListener('click', () => {
    styleMode = localStorage.getItem('styleMode'); // Получение текущей темы
    if (styleMode !== 'dark') {
      enableDarkStyle();
    } else {
      disableDarkStyle();
    }
  });
}