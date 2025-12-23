# Руководство по SEO и Деплою

В этом проекте используется пакет `artesaos/seotools` для управления мета-тегами (Title, Description, OpenGraph, Twitter Cards, JSON-LD).

## Конфигурация
- Файл конфигурации: `config/seotools.php`
- Основной макет: `resources/views/layouts/front-app.blade.php` (содержит `{!! SEO::generate() !!}`)

## Как использовать

### В контроллерах (Controller)

```php
use Artesaos\SEOTools\Facades\SEOTools;

public function show($id)
{
    $tour = Tour::find($id);

    // Установка заголовка
    SEOTools::setTitle($tour->name);
    
    // Установка описания
    SEOTools::setDescription($tour->short_description);
    
    // Установка канонического URL
    SEOTools::opengraph()->setUrl(route('tours.show', $id));
    
    // Добавление OpenGraph свойств
    SEOTools::opengraph()->addProperty('type', 'article');
    SEOTools::opengraph()->addImage($tour->main_image_url);
    
    return view('tours.show', compact('tour'));
}
```

### В компонентах Livewire

Вы можете использовать фасад внутри метода `mount` или `render`.

```php
use Artesaos\SEOTools\Facades\SEOTools;

public function render()
{
    SEOTools::setTitle($this->post->title);
    SEOTools::setDescription($this->post->excerpt);
    SEOTools::opengraph()->setUrl(route('blog.show', $this->post->slug));
    
    if ($this->post->image) {
        SEOTools::opengraph()->addImage(asset('storage/' . $this->post->image));
    }

    return view('livewire.front.post-show');
}
```

## Инструкция по Деплою (Deploy)

При обновлении на продакшене выполните следующие шаги:

1.  **Обновите код**:
    ```bash
    git pull origin main
    ```

2.  **Установите зависимости** (установит `artesaos/seotools`):
    ```bash
    composer install --no-dev --optimize-autoloader
    ```

3.  **Обновите кэш конфигурации**:
    ```bash
    php artisan config:cache
    ```

4.  **Очистите кэш представлений**:
    ```bash
    php artisan view:clear
    ```
