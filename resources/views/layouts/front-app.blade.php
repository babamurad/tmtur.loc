<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Туркменистан - Земля Огня и Тайн | Врата Ада Дарваза</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.05);
        }

        .cta-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1508514177221-188e1e464282?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .gallery-item {
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.03);
            z-index: 10;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
<!-- Header -->
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-fire text-2xl text-red-600 mr-2"></i>
            <span class="text-xl font-bold text-gray-800">TurkmenTravel</span>
        </div>
        <nav class="hidden md:flex space-x-8">
            <a href="#home" class="text-gray-800 hover:text-red-600 font-medium">Главная</a>
            <a href="#about" class="text-gray-800 hover:text-red-600 font-medium">О Туркменистане</a>
            <a href="#tours" class="text-gray-800 hover:text-red-600 font-medium">Туры</a>
            <a href="#darwaza" class="text-gray-800 hover:text-red-600 font-medium">Дарваза</a>
            <a href="#contact" class="text-gray-800 hover:text-red-600 font-medium">Контакты</a>
        </nav>
        <div class="md:hidden">
            <button id="menu-toggle" class="text-gray-800 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white py-2 px-4 shadow-lg">
        <a href="#home" class="block py-2 text-gray-800 hover:text-red-600">Главная</a>
        <a href="#about" class="block py-2 text-gray-800 hover:text-red-600">О Туркменистане</a>
        <a href="#tours" class="block py-2 text-gray-800 hover:text-red-600">Туры</a>
        <a href="#darwaza" class="block py-2 text-gray-800 hover:text-red-600">Дарваза</a>
        <a href="#contact" class="block py-2 text-gray-800 hover:text-red-600">Контакты</a>
    </div>
</header>

<!-- Hero Section -->
<section id="home" class="hero min-h-screen flex items-center justify-center text-white">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-pulse">Откройте для себя Туркменистан</h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Земля древних цивилизаций, загадочных пустынь и легендарных "Врат Ада" в Дарваза</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#tours" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">Выбрать тур</a>
            <a href="#darwaza" class="bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">Узнать о Дарваза</a>
        </div>
    </div>
</section>



<!-- About Turkmenistan -->
<section id="about" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Туркменистан - страна контрастов</h2>
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-lg text-gray-700 mb-6">Туркменистан - это уникальная страна, где древние традиции встречаются с современностью, а бескрайние пустыни соседствуют с роскошными мраморными городами.</p>
                <p class="text-lg text-gray-700 mb-6">Страна обладает богатым культурным наследием, уходящим корнями в глубину веков, когда через эти земли проходил Великий Шелковый путь.</p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-700">Более 300 солнечных дней в году</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-700">Уникальные природные достопримечательности</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-700">Гостеприимные местные жители</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-700">Богатая история и культура</span>
                    </li>
                </ul>
                <a href="#contact" class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-full transition duration-300">Связаться с нами</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Почему стоит выбрать Туркменистан?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-fire text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Врата Ада</h3>
                <p class="text-gray-700">Уникальное природное явление - газовый кратер Дарваза, горящий непрерывно более 50 лет. Это зрелище, которое вы никогда не забудете.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-archway text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Древние города</h3>
                <p class="text-gray-700">Посетите руины древнего Мерва, включенного в список Всемирного наследия ЮНЕСКО, и другие исторические памятники Великого Шелкового пути.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-horse text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Ахалтекинские кони</h3>
                <p class="text-gray-700">Узнайте о легендарных ахалтекинских скакунах, которых называют "небесными конями" за их грацию и выносливость.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-umbrella-beach text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Каспийское море</h3>
                <p class="text-gray-700">Отдохните на побережье Каспийского моря в современном курортном городе Аваза с его прекрасными пляжами и отелями.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-utensils text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Национальная кухня</h3>
                <p class="text-gray-700">Попробуйте настоящий туркменский плов, манты, шашлык и другие блюда, приготовленные по древним рецептам.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-spa text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Лечебные источники</h3>
                <p class="text-gray-700">Посетите знаменитые лечебные источники и грязи, известные своими целебными свойствами еще с древних времен.</p>
            </div>
        </div>
    </div>
</section>

<!-- Darvaza Section -->
<section id="darwaza" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Дарваза - Врата Ада</h2>
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-1">
                <p class="text-lg text-gray-700 mb-6">Газовый кратер Дарваза, известный как "Врата Ада", - это одно из самых загадочных и впечатляющих мест на планете. Расположенный в сердце пустыни Каракумы, этот горящий кратер диаметром около 70 метров и глубиной 20 метров непрерывно пылает уже более 50 лет.</p>
                <p class="text-lg text-gray-700 mb-6">По легенде, кратер образовался в 1971 году, когда советские геологи бурили разведочную скважину и случайно попали в подземную каверну с природным газом. Чтобы избежать распространения газа, его подожгли, рассчитывая, что огонь потухнет через несколько недель. Однако кратер горит до сих пор.</p>
                <p class="text-lg text-gray-700 mb-8">Ночью зрелище особенно впечатляющее - языки пламени вздымаются на высоту до 10-15 метров, освещая окрестности пустыни зловещим светом. Это уникальное явление привлекает туристов со всего мира.</p>
                <a href="#tours" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-full transition duration-300">Забронировать тур к Вратам Ада</a>
            </div>
            <div class="order-1 md:order-2">
                <div class="relative overflow-hidden rounded-lg shadow-xl">
                    <img src="https://images.unsplash.com/photo-1508514177221-188e1e464282?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Дарваза - Врата Ада" class="w-full h-auto">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-bold">"Это нужно увидеть своими глазами!"</h3>
                        <p>- Марк, путешественник из Германии</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tours -->
<section id="tours" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Наши популярные туры</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-xl">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Тур к Вратам Ада" class="w-full h-64 object-cover">
                    <div class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 font-bold">ХИТ</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Тур к Вратам Ада</h3>
                    <p class="text-gray-700 mb-4">2 дня / 1 ночь. Незабываемое путешествие к газовому кратеру Дарваза с ночевкой в пустыне.</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-gray-600 line-through">$450</span>
                            <span class="text-red-600 font-bold text-xl ml-2">$399</span>
                        </div>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <a href="#contact" class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center font-bold py-2 px-4 rounded transition duration-300">Забронировать</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-xl">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Тур по древним городам" class="w-full h-64 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Древние города Туркменистана</h3>
                    <p class="text-gray-700 mb-4">5 дней / 4 ночи. Тур по историческим местам: Мерв, Куня-Ургенч, Ниса.</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-red-600 font-bold text-xl">$750</span>
                        </div>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <a href="#contact" class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center font-bold py-2 px-4 rounded transition duration-300">Забронировать</a>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-xl">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Комбинированный тур" class="w-full h-64 object-cover">
                    <div class="absolute top-0 right-0 bg-green-600 text-white px-3 py-1 font-bold">НОВИНКА</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Все сокровища Туркменистана</h3>
                    <p class="text-gray-700 mb-4">8 дней / 7 ночей. Комбинированный тур: Дарваза, Ашхабад, Мерв, Аваза.</p>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-red-600 font-bold text-xl">$1200</span>
                        </div>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    <a href="#contact" class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center font-bold py-2 px-4 rounded transition duration-300">Забронировать</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="#contact" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300">Хочу индивидуальный тур</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Отзывы наших клиентов</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="testimonial-card bg-gray-100 p-6 rounded-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-600 flex items-center justify-center text-white font-bold mr-4">АК</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Анна К.</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">"Врата Ада превзошли все мои ожидания! Ночью это выглядит просто нереально. Тур был организован на высшем уровне, гиды очень профессиональные. Обязательно вернусь снова!"</p>
            </div>
            <div class="testimonial-card bg-gray-100 p-6 rounded-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-600 flex items-center justify-center text-white font-bold mr-4">ИП</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Иван П.</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">"Путешествие в Туркменистан стало одним из самых ярких впечатлений в моей жизни. Особенно запомнился контраст между современным Ашхабадом и древним Мервом. Спасибо за отличную организацию!"</p>
            </div>
            <div class="testimonial-card bg-gray-100 p-6 rounded-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-600 flex items-center justify-center text-white font-bold mr-4">МС</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Мария С.</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">"Отдых в Авазе был просто сказочным! Чистые пляжи, ласковое море и отличный сервис. А экскурсия к Вратам Ада добавила адреналина в наш спокойный отдых. Рекомендую всем!"</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Туркменистан в фотографиях</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
            <div class="gallery-item overflow-hidden rounded-lg shadow-md">
                <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Туркменистан" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы к незабываемому приключению?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Оставьте заявку прямо сейчас, и мы подберем для вас идеальный тур по Туркменистану!</p>
        <div class="max-w-md mx-auto bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-6">
            <form id="cta-form" class="space-y-4">
                <div>
                    <input type="text" placeholder="Ваше имя" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div>
                    <input type="email" placeholder="Ваш email" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div>
                    <input type="tel" placeholder="Ваш телефон" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div>
                    <select class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                        <option value="">Выберите интересующий тур</option>
                        <option value="darwaza">Тур к Вратам Ада</option>
                        <option value="ancient">Древние города Туркменистана</option>
                        <option value="all">Все сокровища Туркменистана</option>
                        <option value="custom">Индивидуальный тур</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">Отправить заявку</button>
            </form>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Часто задаваемые вопросы</h2>
        <div class="max-w-3xl mx-auto space-y-4">
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-300 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Нужна ли виза для посещения Туркменистана?</span>
                    <i class="fas fa-chevron-down text-red-600 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer p-4 bg-white hidden">
                    <p class="text-gray-700">Для большинства иностранных граждан требуется виза для въезда в Туркменистан. Мы можем помочь вам с оформлением всех необходимых документов и приглашения для получения визы.</p>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-300 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Когда лучше всего посещать Дарваза?</span>
                    <i class="fas fa-chevron-down text-red-600 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer p-4 bg-white hidden">
                    <p class="text-gray-700">Лучшее время для посещения Врат Ада - с марта по май и с сентября по ноябрь, когда температура наиболее комфортная. Летом в пустыне может быть очень жарко (до +50°C), а зимой - холодно по ночам.</p>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-300 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Безопасно ли посещение Врат Ада?</span>
                    <i class="fas fa-chevron-down text-red-600 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer p-4 bg-white hidden">
                    <p class="text-gray-700">Да, посещение абсолютно безопасно при соблюдении правил, которые вам объяснит гид. Главное - не подходить слишком близко к краю кратера и следовать указаниям сопровождающего.</p>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-300 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Что взять с собой в тур к Вратам Ада?</span>
                    <i class="fas fa-chevron-down text-red-600 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer p-4 bg-white hidden">
                    <p class="text-gray-700">Рекомендуем взять: удобную обувь, теплую одежду (ночью в пустыне холодно), головной убор, солнцезащитные очки, крем от солнца, фотоаппарат, запас воды. Мы предоставляем палатки и питание.</p>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-300 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Есть ли возрастные ограничения для туров?</span>
                    <i class="fas fa-chevron-down text-red-600 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer p-4 bg-white hidden">
                    <p class="text-gray-700">Для стандартных туров возрастных ограничений нет, но для посещения Дарваза мы не рекомендуем брать детей младше 10 лет из-за особенностей маршрута. Пожилым людям следует оценить свои физические возможности.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Свяжитесь с нами</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <form class="space-y-4">
                    <div>
                        <input type="text" placeholder="Ваше имя" class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>
                    <div>
                        <input type="email" placeholder="Ваш email" class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>
                    <div>
                        <input type="tel" placeholder="Ваш телефон" class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>
                    <div>
                        <textarea placeholder="Ваше сообщение" rows="5" class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">Отправить сообщение</button>
                </form>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Наши контакты</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-red-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Адрес:</h4>
                            <p class="text-gray-700">г. Ашхабад, проспект Махтумкули, 123</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-phone-alt text-red-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Телефон:</h4>
                            <p class="text-gray-700">+993 12 34 56 78</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-red-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Email:</h4>
                            <p class="text-gray-700">info@turkmentravel.com</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-clock text-red-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Часы работы:</h4>
                            <p class="text-gray-700">Пн-Пт: 9:00 - 18:00<br>Сб: 10:00 - 15:00<br>Вс: выходной</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h4 class="font-bold text-gray-800 mb-3">Мы в социальных сетях:</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gray-900 text-white rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-400 hover:bg-blue-500 text-white rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 hover:bg-pink-700 text-white rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-fire text-2xl text-red-600 mr-2"></i>
                    <span class="text-xl font-bold">TurkmenTravel</span>
                </div>
                <p class="text-gray-400">Ваш надежный гид по удивительному Туркменистану. Мы открываем для вас самые захватывающие места этой загадочной страны.</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Быстрые ссылки</h4>
                <ul class="space-y-2">
                    <li><a href="#home" class="text-gray-400 hover:text-white transition duration-300">Главная</a></li>
                    <li><a href="#about" class="text-gray-400 hover:text-white transition duration-300">О Туркменистане</a></li>
                    <li><a href="#tours" class="text-gray-400 hover:text-white transition duration-300">Туры</a></li>
                    <li><a href="#darwaza" class="text-gray-400 hover:text-white transition duration-300">Дарваза</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-white transition duration-300">Контакты</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Наши туры</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Тур к Вратам Ада</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Древние города</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Все сокровища Туркменистана</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Отдых в Авазе</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Индивидуальные туры</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Подписаться на рассылку</h4>
                <p class="text-gray-400 mb-4">Будьте в курсе наших новых предложений и акций.</p>
                <form class="flex">
                    <input type="email" placeholder="Ваш email" class="px-4 py-2 rounded-l-lg focus:outline-none text-gray-800 w-full">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-r-lg transition duration-300">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
            <p>&copy; 2023 TurkmenTravel. Все права защищены.</p>
        </div>
    </div>
</footer>

<script>
    // Mobile menu toggle
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // FAQ accordion
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');

            // Toggle answer visibility
            answer.classList.toggle('hidden');

            // Rotate icon
            icon.classList.toggle('rotate-180');

            // Close other answers
            document.querySelectorAll('.faq-question').forEach(otherButton => {
                if (otherButton !== button) {
                    otherButton.nextElementSibling.classList.add('hidden');
                    otherButton.querySelector('i').classList.remove('rotate-180');
                }
            });
        });
    });

    // Form submission
    document.getElementById('cta-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время.');
        this.reset();
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                if (!document.getElementById('mobile-menu').classList.contains('hidden')) {
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            }
        });
    });
</script>
</body>
</html>
