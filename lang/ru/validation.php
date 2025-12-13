<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'string' => 'Поле :attribute должно быть строкой.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'boolean' => 'Поле :attribute должно быть логическим значением.',
    'min' => [
        'string' => 'Поле :attribute должно содержать минимум :min символов.',
        'integer' => 'Поле :attribute должно быть не меньше :min.',
        'array' => 'Поле :attribute должно содержать минимум :min элементов.',
    ],
    'max' => [
        'string' => 'Поле :attribute не должно превышать :max символов.',
        'integer' => 'Поле :attribute не должно быть больше :max.',
        'array' => 'Поле :attribute не должно содержать более :max элементов.',
    ],
    'unique' => 'Такое значение поля :attribute уже существует.',
    'in' => 'Выбранное значение для :attribute некорректно.',
    'exists' => 'Выбранное значение для :attribute не существует.',
    'image' => 'Поле :attribute должно быть изображением.',
    'array' => 'Поле :attribute должно быть массивом.',
    'nullable' => 'Поле :attribute может быть пустым.',

    'custom' => [
        'gdpr_consent' => [
            'accepted' => 'Вы должны дать согласие на обработку персональных данных.',
        ],
    ],

    'attributes' => [
        'title' => 'Название тура',
        'slug' => 'URL-идентификатор',
        'short_description' => 'Краткое описание',
        'images' => 'Изображения',
        'images.*' => 'Изображение',
        'is_published' => 'Опубликовано',
        'base_price_cents' => 'Базовая цена (в копейках)',
        'duration_days' => 'Продолжительность (в днях)',
        'itinerary_days.*.day_number' => 'Номер дня маршрута',
        'inclusions.*.type' => 'Тип включения',
        'accommodations.*.nights_count' => 'Количество ночей',
        'category_id' => 'Категории',
        'category_id.*' => 'Категория',
        'trans.*.title' => 'Название (перевод)',
        'trans.*.short_description' => 'Краткое описание (перевод)',
        'itinerary_days.*.trans.*.title' => 'Название дня (перевод)',
        'itinerary_days.*.trans.*.description' => 'Описание дня (перевод)',
        'inclusions.*.trans.*.item' => 'Элемент включения (перевод)',
        'accommodations.*.trans.*.location' => 'Местоположение (перевод)',
        'accommodations.*.trans.*.standard_options' => 'Стандартные опции (перевод)',
        'accommodations.*.trans.*.comfort_options' => 'Комфортные опции (перевод)',
    ],
];