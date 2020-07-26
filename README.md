# Ретраслятор стены сообществ ВКонтакте в Телеграм канал

[![PHP Version](https://img.shields.io/badge/php%20version-%3E%3D%205.4-8892BF)]()
[![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-1f425f)]()

---

### Требования
* Телеграм бот (создать можно с помощью *BotFather*)
* Доступ к сообществу *"Работа с API"*
* ВЕБ-хост с PHP 5.6 и выше
* PHP модуль: cURL

---

### Установка

Скачиваем репозиторий и закидываем в какой-нибуть ВЕБ-хостинг с PHP 5.6 и выше и с модулю cURL.

Всё...

---

### Настройка

В `relay.php` на строке 16 меняем сторку:
```php
if(!isset($request["secret"]) || $request["secret"] !== "YourSecretCode") {
```
где *YourSecretCode* надо заменить на секретный ключ доступа:

[![Screenshot 1](https://i.imgur.com/nLs4wHs.png)](https://i.imgur.com/nLs4wHs.png)

В `relay.php` на строке 22, 25, 28 меняем сторку:
```php
// Код подтверждения Callback API
define("CONFIRM_CODE", "1a2b3c4d");

// Токен Телеграм бота
define("BOT_TOKEN", "1234567890:AaBbCcDdEeFf1234567890-AaBbCcDdEeFf");

// Имя канала или Чат ID для отправки сообщение
define("CHAT_ID", "@yourchannelname");
```
1. На код подтверждения Callback API
2. На токен Телеграм бота
3. На имя канала

Переходим в вкладку *"Типы событий"* и спустимся до галочки *"Записи на стене: Добавление"* и ставим галочку:

[![Screenshot 2](https://i.imgur.com/34dYqPi.png)](https://i.imgur.com/34dYqPi.png)

---

### Настройка бота в Телеграме

Когда мы создали бота, можно его пригласить в канал:

[![Screenshot 4](https://i.imgur.com/OY1Nt4q.png)](https://i.imgur.com/OY1Nt4q.png)

[![Screenshot 5](https://i.imgur.com/jKAmfsz.png)](https://i.imgur.com/jKAmfsz.png)

[![Screenshot 6](https://i.imgur.com/0WlBfTU.png)](https://i.imgur.com/0WlBfTU.png)

---

# Good luck!
