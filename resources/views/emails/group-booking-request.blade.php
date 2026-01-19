<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .details {
            margin: 20px 0;
        }

        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Новая заявка на тур</h2>
        </div>

        <div class="details">
            <p><span class="label">Тур:</span> {{ $tourGroup->tour->title }}</p>
            <p><span class="label">Дата выезда:</span> {{ $tourGroup->starts_at->format('d.m.Y') }}</p>
            <p><span class="label">ID группы:</span> {{ $tourGroup->id }}</p>
            <p><span class="label">Количество гостей:</span> {{ $bookingData['guests'] }}</p>

            <hr>

            <h3>Данные клиента</h3>
            <p><span class="label">Имя:</span> {{ $bookingData['name'] }}</p>
            <p><span class="label">Email:</span> <a
                    href="mailto:{{ $bookingData['email'] }}">{{ $bookingData['email'] }}</a></p>
            <p><span class="label">Телефон:</span> {{ $bookingData['phone'] ?? '-' }}</p>

            @if(!empty($bookingData['message']))
                <hr>
                <h3>Сообщение клиента</h3>
                <p>{{ $bookingData['message'] }}</p>
            @endif
        </div>

        <div class="footer">
            <p>Это автоматическое письмо с сайта tmtourism.com</p>
        </div>
    </div>
</body>

</html>