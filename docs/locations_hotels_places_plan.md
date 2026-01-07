# План реализации - Локации, Отели и Достопримечательности

Цель состоит в создании сущностей `Location` (Локация), `Hotel` (Отель) и `Place` (Место/Достопримечательность) с конкретными связями и категориями согласно запросу.

## Требуется проверка пользователем
> [!NOTE]
> Я буду использовать PHP 8.1 Enums для `HotelCategory` и `PlaceType`, что соответствует вашему правилу "Использовать PHP enums".

## Предлагаемые изменения

### База данных и Модели

#### [NEW] [Модель и Миграция Location]
- **Таблица**: `locations`
  - `id`, `name` (строка), `slug` (строка, уникальное), `description` (текст, null), `timestamps`
- **Модель**: `App\Models\Location`
  - Связи: `hotels()`, `places()`

#### [NEW] [Модель и Миграция Hotel]
- **Таблица**: `hotels`
  - `id`, `location_id` (внешний ключ), `name` (строка), `category` (строка/enum), `timestamps`
- **Модель**: `App\Models\Hotel`
  - Enums: `App\Enums\HotelCategory` (Standard, Comfort)
  - Связи: `location()`

#### [NEW] [Модель и Миграция Place]
- **Таблица**: `places`
  - `id`, `location_id` (внешний ключ), `name` (строка), `type` (строка/enum), `cost` (decimal, null), `timestamps`
- **Модель**: `App\Models\Place`
  - Enums: `App\Enums\PlaceType` (Paid - Платные, Free - Бесплатные)
  - Связи: `location()`

### Административная панель (Livewire)

Я создам компоненты управления в `App\Livewire\Admin` и представления в `resources/views/livewire/admin`.

#### [NEW] [Управление Локациями]
- `App\Livewire\Admin\Location\LocationIndexComponent`
- `App\Livewire\Admin\Location\LocationCreateComponent`
- `App\Livewire\Admin\Location\LocationEditComponent`

#### [NEW] [Управление Отелями]
- `App\Livewire\Admin\Hotel\HotelIndexComponent`
- `App\Livewire\Admin\Hotel\HotelCreateComponent`
- `App\Livewire\Admin\Hotel\HotelEditComponent`

#### [NEW] [Управление Достопримечательностями]
- `App\Livewire\Admin\Place\PlaceIndexComponent`
- `App\Livewire\Admin\Place\PlaceCreateComponent`
- `App\Livewire\Admin\Place\PlaceEditComponent`

## План проверки

### Ручная проверка
1.  Запустить миграции.
2.  Открыть админ-панель.
3.  Создать `Location` (Локацию).
4.  Создать `Hotel` (Отель), привязанный к этой локации (категории Стандарт/Комфорт).
5.  Создать `Place` (Достопримечательность), привязанную к этой локации (Платное/Бесплатное).
6.  Проверить записи в базе данных.
