# Request api
Краткое описание проекта - на проекте используются формы наследуемые от абстрактного класса. Сделано это для удобства и избежания sql иньекций при запросах. Поэтому передаваемые в формах значения будут обозначаться объектами, заострил внимание на этом моменте для понимания стуктуры форм задокументированных в swagger.
https://plnkr.co/edit/lHBwzkeWB0sl7DQD?open=lib%2Fscript.js - ссылка на песочницу с документацией по методам api (swagger). В документацию не включались методы авторизации, регистрации и тд (методы работы сервиса). Также не включались методы получения форм

## Installation

```bash
git clone git@github.com:NicolayNicolay/requests_api.git requests_api.local
cd requests_api.local
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
php artisan storage:link
```

```bash
npm install
```

```bash
npm run build
```

For development mode, use the command

```bash
npm run dev
```

