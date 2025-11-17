<!DOCTYPE html>
<html>
<head>
    <title>Новое сообщение с контактной формы</title>
</head>
<body>
<h1>Получено новое сообщение</h1>
<p><strong>Имя:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>

@if (!empty($data['phone']))
    <p><strong>Телефон:</strong> {{ $data['phone'] }}</p>
@endif

<p><strong>Сообщение:</strong></p>
<p>{!! nl2br(e($data['message'])) !!}</p>

<hr>
<small>Это автоматическое уведомление. Пожалуйста, не отвечайте на него.</small>
</body>
</html>
