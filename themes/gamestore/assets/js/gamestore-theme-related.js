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

document.querySelector('.header-search').addEventListener('click', function (e) {
	document.querySelector('.popup-games-search-container').style.display = 'block';
});

document.querySelector('#close-search ').addEventListener('click', function (e) {
	document.querySelector('.popup-games-search-container').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function () {
	const searchContainer = document.querySelector('.popup-games-search-container');
	const searchResults = document.querySelector('.popup-search-results');
	const searchInput = document.getElementById('popup-search-input');
	const openButton = document.querySelector('.header-search');
	const closeButton = document.getElementById('close-search');
	const titleElement = document.querySelector('.search-popup-title');

	openButton.addEventListener('click', function () {
			searchContainer.style.display = 'block';
			titleElement.textContent = 'You might be interested';

			showPlaceholders();

			loadDefaultGames();
	});

	closeButton.addEventListener('click', function () {
			searchContainer.style.display = 'none';
			searchResults.innerHTML = '';
	});

	function showPlaceholders() {
			searchResults.innerHTML = '';
			for (let i = 0; i < 12; i++) {
					const placeholder = document.createElement('div');
					placeholder.className = 'game-placeholder';
					searchResults.appendChild(placeholder);
			}
	}

	function renderGames(games) {
			searchResults.innerHTML = '';
			games.forEach(function (game) {
					const gameDiv = document.createElement('div');
					gameDiv.className = 'game-result';

					gameDiv.innerHTML = `
							<a href="${game.link}">
									<div class="game-featured-image">${game.thumbnail}</div>
									<div class="game-meta">
											<div class="game-price">${game.price}</div>
											<h3>${game.title}</h3>
									</div>
							</a>
					`;

					searchResults.appendChild(gameDiv);
			});
	}

	searchInput.addEventListener('input', function(){
    const searchItem = searchInput.value;
    titleElement.textContent = 'Search Results';

    showPlaceholders();
    
    fetch(gamestore_params.ajaxurl, {
      method: "POST",
      header: {
        'Content-Type': "application/x-www-form-urlncoded",
      },
      body: new URLSearchParams({
        action: 'search_games_by_title',
        search: searchItem
      })
    })
    .then(response =>response.json())
    .then(data => {
      if(data.success && data.data.length > 0){
        titleElement.textContent = 'Search Results';
        renderGames(data.data);
      } else {
        titleElement.textContent = 'Nothing was found. You might be interested in';
        showPlaceholders();
        loadDefaultGames();
      }
    })
    .catch(error => console.log('Error fetching latest games', error));
  });

	function loadDefaultGames() {
		fetch(gamestore_params.ajaxurl, {
			method: "POST",
			headers: {
					'Content-Type': "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
					action: 'load_latest_games'
			})
	})
	.then(response => response.json())
	.then(data => {
			if (data.success) {
					renderGames(data.data);
			}
	})
	.catch(error => console.log('Error fetching latest games', error));
	}
});