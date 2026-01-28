# Руководство по локализации и переводам

В этом проекте внедрена система мультиязычности с поддержкой автоматического перевода через Gemini AI.

## 1. Поддерживаемые языки

На данный момент настроены следующие языки:
- **Русский** (`ru`) - основной
- **Английский** (`en`)
- **Корейский** (`ko`)
- **Немецкий** (`de`)
- **Французский** (`fr`)
- **Испанский** (`es`)
- **Польский** (`pl`)
- **Итальянский** (`it`)

Список доступных языков находится в `config/app.php` в ключе `available_locales`.

## 2. Автоматический перевод контента

Для перевода контента (Туры, Посты, Категории и т.д.) используется консольная команда `translate:content`. Она автоматически определяет исходный язык и переводит пустые поля на целевые языки.

### Основные команды

#### Перевод всего контента
```bash
php artisan translate:content
```
Эта команда пройдет по всем настроенным моделям и всем языкам.

#### Перевод конкретной модели
Если нужно перевести только определенный тип данных:
```bash
php artisan translate:content --model=Tour
php artisan translate:content --model=Post
php artisan translate:content --model=Category
php artisan translate:content --model=TourCategory
php artisan translate:content --model=Hotel
```

#### Перевод на конкретные языки
Чтобы ускорить процесс или перевести только на один добавленный язык (например, итальянский):
```bash
php artisan translate:content --langs=it
```
Можно указать несколько языков через запятую:
```bash
php artisan translate:content --langs=de,fr
```

### Примечание для OSPanel
Если глобальная команда `php` недоступна, используйте полный путь к PHP (пример для PHP 8.3):
```bash
c:\OSPanel\modules\php\PHP_8.3\php.exe artisan translate:content --langs=it
```

## 3. Добавление нового языка

Чтобы добавить новый язык (например, Турецкий `tr`):

1.  **Конфигурация**: Добавьте `'tr'` в массив `available_locales` в файле `config/app.php`.
2.  **Файлы**: Создайте файл `lang/tr.json` (можно скопировать `lang/en.json` и перевести базовые ключи).
3.  **Gemini**: Добавьте название языка в файл `app/Livewire/Traits/HasGeminiTranslation.php` в массив `$localeMap`:
    ```php
    'tr' => 'Turkish',
    ```
4.  **Команда**: Добавьте название языка в файл `app/Console/Commands/TranslateContentCommand.php` в методе `getLanguageName`:
    ```php
    'tr' => 'Turkish',
    ```
5.  **Запуск**: Запустите автоперевод:
    ```bash
    php artisan translate:content --langs=tr
    ```
