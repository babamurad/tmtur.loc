<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новое сообщение с контактной формы</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        .email-header p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        .email-body {
            padding: 30px 20px;
        }
        .info-section {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 100px;
            display: inline-flex;
            align-items: center;
        }
        .info-label::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: #667eea;
            border-radius: 50%;
            margin-right: 8px;
        }
        .info-value {
            color: #212529;
            flex: 1;
            word-break: break-word;
        }
        .message-section {
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .message-section h3 {
            font-size: 16px;
            color: #495057;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .message-content {
            color: #212529;
            font-size: 15px;
            line-height: 1.7;
            white-space: pre-wrap;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            color: #6c757d;
            font-size: 13px;
            margin: 5px 0;
        }
        .timestamp {
            background-color: #e7f3ff;
            color: #0066cc;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .reply-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 15px;
            transition: transform 0.2s;
        }
        .reply-button:hover {
            transform: translateY(-2px);
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px 15px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📧 Новое сообщение</h1>
            <p>Получено через контактную форму сайта</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="timestamp">
                🕐 {{ now()->format('d.m.Y H:i:s') }}
            </div>

            <!-- Contact Information -->
            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">Имя:</span>
                    <span class="info-value">{{ $data['name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:{{ $data['email'] }}" style="color: #667eea; text-decoration: none;">
                            {{ $data['email'] }}
                        </a>
                    </span>
                </div>
                @if (!empty($data['phone']))
                <div class="info-row">
                    <span class="info-label">Телефон:</span>
                    <span class="info-value">
                        <a href="tel:{{ $data['phone'] }}" style="color: #667eea; text-decoration: none;">
                            {{ $data['phone'] }}
                        </a>
                    </span>
                </div>
                @endif
            </div>

            <!-- Message Content -->
            <div class="message-section">
                <h3>💬 Текст сообщения:</h3>
                <div class="message-content">{!! nl2br(e($data['message'])) !!}</div>
            </div>

            <!-- Quick Reply Button -->
            <center>
                <a href="mailto:{{ $data['email'] }}?subject=Re: Ваше обращение" class="reply-button">
                    Ответить клиенту
                </a>
            </center>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>{{ config('app.name', 'TM Tourism') }}</strong></p>
            <p style="margin-top: 10px;">
                Это автоматическое уведомление с сайта.<br>
                Пожалуйста, ответьте клиенту напрямую по указанному email.
            </p>
        </div>
    </div>
</body>
</html>
