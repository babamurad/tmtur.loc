# Руководство по SEO и Деплою

В этом проекте используется пакет `artesaos/seotools` для управления мета-тегами (Title, Description, OpenGraph, Twitter Cards, JSON-LD), а также кастомная система `SeoMeta` для управления мета-данными через базу данных.

## Конфигурация
- Файл конфигурации: `config/seotools.php`
- Основной макет: `resources/views/layouts/front-app.blade.php` (содержит `{!! SEO::generate() !!}`)

## Как работает SEO

SEO-теги формируются по следующему приоритету:
1.  **Кастомные данные из БД** (таблица `seo_metas`), если они заданы для конкретной записи.
2.  **Данные самой модели** (название тура, краткое описание, главное изображение).
3.  **Дефолтные значения** из `config/seotools.php`.

### 1. Использование в Livewire компонентах (Рекомендуемый способ)
В компоненте `ToursShow` (и аналогичных) логика следующая:

```php
public function render()
{
    // Загружаем связь seo
    $seo = $this->tour->loadMissing('seo')->seo;

    if ($seo) {
        // Если есть запись в seo_metas, берем оттуда
        $title = $seo->title ?: $this->tour->tr('title');
        $description = $seo->description ?: $this->tour->tr('short_description');
        $image = $seo->og_image ? asset('storage/' . $seo->og_image) : $this->tour->first_media_url;
    } else {
        // Иначе используем поля модели
        $title = $this->tour->tr('title');
        $description = $this->tour->tr('short_description');
        $image = $this->tour->first_media_url;
    }

    // Применяем через фасад
    \Artesaos\SEOTools\Facades\SEOTools::setTitle($title);
    \Artesaos\SEOTools\Facades\SEOTools::setDescription($description);
    \Artesaos\SEOTools\Facades\SEOTools::opengraph()->addImage($image);
    
    return view('livewire.front.tours-show');
}
```

### 2. Подключение к новым моделям
Чтобы добавить SEO-возможности к новой модели (например, `Post`):

1.  Добавьте трейт `HasSeo` в модель:
    ```php
    use App\Traits\HasSeo;

    class Post extends Model
    {
        use HasSeo;
    }
    ```
2.  В коде просмотра записи (Controller или Livewire) добавьте логику проверки `$post->seo`.

### 3. Ручное управление (Для статических страниц)
В контроллерах или простых компонентах можно задавать теги вручную:

```php
use Artesaos\SEOTools\Facades\SEOTools;

public function contact()
{
    SEOTools::setTitle('Контакты');
    SEOTools::setDescription('Свяжитесь с нами по телефону...');
    return view('contact');
}
```

## Инструкция по Деплою (Deploy)

При обновлении на продакшене выполните следующие шаги:

1.  **Обновите код**:
    ```bash
    git pull origin main
    ```

2.  **Миграции** (если были изменения в `seo_metas`):
    ```bash
    php artisan migrate
    ```

3.  **Установите зависимости**:
    ```bash
    composer install --no-dev --optimize-autoloader
    ```

4.  **Очистите кэш**:
    ```bash
    php artisan config:cache
    php artisan view:clear
    ```
