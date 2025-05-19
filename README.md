## About Laravel

Punch Notification Service is a minimal Laravel-based application designed to send task notifications to users via a Telegram bot. Users can subscribe or unsubscribe through bot commands, and the system automatically delivers updates to users with active tasks.

## Getting Started

Clone the repository:
<pre><code>git clone https://github.com/your-username/punch-test-task.git</code></pre>

Go to project:
<pre><code>cd punch-test-task</code></pre>

<pre><code>composer install</code></pre>
Set up environment variables:



- Copy .env.example to .env.
- Configure your database connection and Telegram bot token (TELEGRAM_BOT_TOKEN).
- Configure your task api (TASK_URL).

Run migrations and seeders:
<pre><code>php artisan migrate --seed</code></pre>

Set up queue worker:
<pre><code>php artisan queue:work</code></pre>

Set Telegram webhook:
- To start receiving updates from your Telegram bot, you need to manually set a webhook using the [Telegram Bot API](https://core.telegram.org/bots/api#setwebhook).
- Replace <YOUR_WEBHOOK_URL> with your deployed application's webhook endpoint (e.g. https://your-domain.com/api/telegram/webhook).

<pre><code>curl -X POST "https://api.telegram.org/bot&lt;YOUR_BOT_TOKEN&gt;/setWebhook" \
     -d "url=&lt;YOUR_WEBHOOK_URL&gt;"</code></pre>

