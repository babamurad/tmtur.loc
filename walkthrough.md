# Уведомления по Email для Контактной Формы - Руководство по Реализации

## Внесенные Изменения

### 1. Обновлен Класс Mailable
**Файл**: [ContactReceived.php](file:///c:/OSPanel/domains/tmtur.loc/app/Mail/ContactReceived.php)

- Удален устаревший метод `build()` во избежание конфликтов с современным Laravel mail API
- Обновлена тема письма на двуязычную: "Новое сообщение с сайта / New Contact Message"
- Теперь используются только методы `envelope()`, `content()` и `attachments()`

### 2. Улучшена Логика Отправки Email
**Файл**: [ContactFormComponent.php](file:///c:/OSPanel/domains/tmtur.loc/app/Livewire/Front/ContactFormComponent.php)

- **Приоритет получателя**: Сначала проверяется `MAIL_TO_ADDRESS`, затем `MAIL_FROM_ADDRESS`
- **Добавлено логирование успеха**: Записывает успешную отправку с информацией о получателе и отправителе
- **Добавлено логирование предупреждений**: Предупреждает, если email получателя не настроен

### 3. Шаблон Email
**Файл**: [contact-received.blade.php](file:///c:/OSPanel/domains/tmtur.loc/resources/views/emails/contact-received.blade.php)

- Шаблон уже создан с русским текстом
- Отображает: Имя, Email, Телефон (опционально), Сообщение

## Шаги Проверки

### 1. Настройка Файла .env

Убедитесь, что в вашем файле `.env` есть эти настройки:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tmtur.loc"
MAIL_FROM_NAME="TM Tour"
MAIL_TO_ADDRESS="admin@example.com"  # Email администратора
```

> [!IMPORTANT]
> Обязательно установите `MAIL_TO_ADDRESS` на email, на который вы хотите получать уведомления с контактной формы.

### 2. Тестирование Контактной Формы

1. Откройте страницу контактов на вашем сайте
2. Заполните форму тестовыми данными:
   - Имя: Тестовый Пользователь
   - Email: test@example.com
   - Телефон: +99312345678
   - Сообщение: Это тестовое сообщение
3. Отправьте форму

### 3. Проверка Логов

Откройте `storage/logs/laravel.log` и найдите:

**Успешная отправка**:
```
Contact email sent to: admin@example.com
```

**Ошибка**:
```
Contact email send error: [текст ошибки]
```

**Получатель не настроен**:
```
Contact form submitted but no recipient email configured in .env
```

### 4. Проверка Почтового Ящика

Проверьте почтовый ящик email-адреса, указанного в `MAIL_TO_ADDRESS`. Вы должны получить письмо с:
- Темой: "Новое сообщение с сайта / New Contact Message"
- Содержимым со всеми данными формы

## Устранение Неполадок

Если письма не отправляются:

1. **Проверьте конфигурацию .env**: Убедитесь, что все настройки MAIL_* указаны правильно
2. **Проверьте логи**: Посмотрите в `storage/logs/laravel.log` на сообщения об ошибках
3. **Протестируйте настройки почты**: Запустите `php artisan tinker` и попробуйте:
   ```php
   Mail::raw('Test', function($msg) { $msg->to('your@email.com')->subject('Test'); });
   ```
4. **Для пользователей Gmail**: Убедитесь, что используете App Password, а не обычный пароль
5. **Проверьте папку спам**: Иногда письма попадают в спам

## Итог

Контактная форма теперь отправляет email-уведомления на настроенный email администратора. Система включает надежную обработку ошибок и логирование для диагностики проблем.