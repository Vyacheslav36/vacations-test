# Тестовый проект (Отпуска сотрудников)

## Начало

1. [Установите композер](https://getcomposer.org)
2. Выполните `composer install`
3. [Создание базы данных](#создание-базы-данных)
4. [Описание проекта](#описание-проекта)
5. [Запуск проекта](#запуск-проекта)

## Разработчикам
    
### Создание базы данных
1. Создайте локальную базу данных в MySql
2. Создайте файл `.env` внутри проекта
3. Скопируйте содержимое `.env.dist` в `.env`
4. Измените необходимые параметры в `.env`
5. Выполните данные команды
    ```bash
    php console/yii migrate
    php console/yii rbac-migrate
    ```
   
### Запуск приложения
1. Внутри проекта создан файла `server.cmd`
2. Необходимо запустить его командой `php server`
3. После чего сайт станет доступным по адресу `http://localhost:82`

### Описание проекта
В качестве основы для инициализации проекта был взят [starter-kit](#table-of-contents), после чего из него были вырезаны ненужные папки.
В качестве основной СУБД была выбрана MySql.

Цели:
1. Должно быть разделение по ролям (указаны ниже);
2. Должно быть разделение сотрудников по отделам;
3. Должно быть ведение списка отпусков с возможностью их утверждения руководителем отдела;
4. Данные (отделы, пользователи и отпуска) для руководителей должны выводиться с учетом отдела;
5. Данные (отпуска) для сотрудников должны выводиться по принадлежности к текущему сотруднику;
6. Администратор должен видеть всю информацию;
7. От рядовых сотрудников должны быть скрыты кнопки утверждения отпусков;
8. После утверждения отпуска должны быть скрыты все возможности манипуляции с ним (редактирование, удаление, утверждение).

Таблицы
1. department - id, name, settings (json - maxNumberOfVacationDays, maxNumberOfEmployeesOnVacation);
2. user - id, email, username, token и тд;
3. user_profile - user_id, department_id, lastname, firstname, middlename и тд;
4. vacation - id, from_date, to_date, user_id, is_approved (default  = false).

Роли:
1. administrator - Администратор (главная задача заводить отделы и руководителей к ним);
2. manager - Руководитель (главная задача заводить сотрудников и утверждать им отпуска);
3. user - Рядовой сотрудник (главная задача создание отпусков в соответствии настройкам отдела).

Варианты использования
Админ:
- вход в систему под необходимыми данными;
- может создавать/редактировать отделы, руководителей для отделов и сотрудников;
- может манипулировать отпусками (просматривать, создавать, редактировать, удалять и утверждать).

Руководитель:
- имеет доступ ко всем функциям системы;
- вход в систему под необходимыми данными;
- может редактировать только свой отдел и свои данные;
- может создавать/редактировать сотрудников для своего отдела;
- может утверждать, редактировать и просматривать отпуска сотрудников своего отдела.

Рядовой сотрудник:
- вход в систему под необходимыми данными;
- может редактировать свои данные;
- может создавать отпуск с учетом всех настроек для отдела;
- может редактировать отпуск пока он не утвержден руководителем;
- может видеть список своих отпусков;

Дополнительно:
- на форму создания/редактирования отпуска добавлен список забронированных отпусков сотрудников отдела;
- добавлены настройки отделов (максимальное количество сотрудников в отпуске и максимальное количество дней отпуска), создание отпуска осуществляется через проверку данных настроек.
.
.
.
# Yii 2 Starter Kit

<!-- BADGES/ -->

[![Packagist](https://img.shields.io/packagist/v/yii2-starter-kit/yii2-starter-kit.svg)](https://packagist.org/packages/yii2-starter-kit/yii2-starter-kit)
[![Packagist](https://img.shields.io/packagist/dt/yii2-starter-kit/yii2-starter-kit.svg)](https://packagist.org/packages/yii2-starter-kit/yii2-starter-kit)
[![Build Status](https://travis-ci.org/yii2-starter-kit/yii2-starter-kit.svg?branch=master)](https://travis-ci.org/yii2-starter-kit/yii2-starter-kit)

<!-- /BADGES -->

This is Yii2 start application template.

It was created and developing as a fast start for building an advanced sites based on Yii2.

It covers typical use cases for a new project and will help you not to waste your time doing the same work in every project

## Before you start
Please, consider helping project via [contributions](https://github.com/yii2-starter-kit/yii2-starter-kit/issues) or [donations](#donations).

## TABLE OF CONTENTS
- [Demo](#demo)
- [Features](#features)
- [Installation](docs/installation.md)
    - [Manual installation](docs/installation.md#manual-installation)
    - [Docker installation](docs/installation.md#docker-installation)
    - [Vagrant installation](docs/installation.md#vagrant-installation)
- [Components documentation](docs/components.md)
- [Console commands](docs/console.md)
- [Testing](docs/testing.md)
- [FAQ](docs/faq.md)
- [How to contribute?](#how-to-contribute)
- [Have any questions?](#have-any-questions)

## Quickstart
1. [Install composer](https://getcomposer.org)
2. [Install docker](https://docs.docker.com/install/)
3. [Install docker-compose](https://docs.docker.com/compose/install/)
4. Run
    ```bash
    composer create-project yii2-starter-kit/yii2-starter-kit myproject.com --ignore-platform-reqs
    cd myproject.com
    composer run-script docker:build
    ```
5. Go to [http://yii2-starter-kit.localhost](http://yii2-starter-kit.localhost)

## FEATURES
### Admin backend
- Beautiful and open source dashboard theme for backend [AdminLTE 3](https://adminlte.io/themes/v3/)
- Content management components: articles, categories, static pages, editable menu, editable carousels, text blocks
- Settings editor. Application settings form (based on KeyStorage component)
- [File manager](https://github.com/MihailDev/yii2-elfinder)
- Users, RBAC management
- Events timeline
- Logs viewer
- System monitoring

### I18N
- Built-in translations:
    - English
    - Spanish
    - Russian
    - Ukrainian
    - Chinese
    - Vietnamese
    - Polish
    - Portuguese (Brazil)
    - Indonesian (Bahasa)
- Language switcher, built-in behavior to choose locale based on browser preferred language
- Backend translations manager

### Users
- Sign in
- Sign up
- Profile editing(avatar, locale, personal data)
- Optional activation by email
- OAuth authorization
- RBAC with predefined `guest`, `user`, `manager` and `administrator` roles
- RBAC migrations support

### Development
- Ready-to-use Docker-based stack (php, nginx, mysql, mailcatcher)
- .env support
- [Webpack](https://webpack.js.org/) build configuration
- Key-value storage service
- Ready to use REST API module
- [File storage component + file upload widget](https://github.com/trntv/yii2-file-kit)
- On-demand thumbnail creation [trntv/yii2-glide](https://github.com/trntv/yii2-glide)
- Built-in queue component [yiisoft/yii2-queue](https://github.com/yiisoft/yii2-queue)
- Command Bus with queued and async tasks support [trntv/yii2-command-bus](https://github.com/trntv/yii2-command-bus)
- `ExtendedMessageController` with ability to replace source code language and migrate messages between message sources
- [Some useful shortcuts](https://github.com/yii2-starter-kit/yii2-starter-kit/blob/master/common/helpers.php)

### Other
- Useful behaviors (GlobalAccessBehavior, CacheInvalidateBehavior)
- Maintenance mode support ([more](#maintenance-mode))
- [Aceeditor widget](https://github.com/trntv/yii2-aceeditor)
- [Datetimepicker widget](https://github.com/trntv/yii2-bootstrap-datetimepicker),
- [Imperavi Reactor Widget](https://github.com/asofter/yii2-imperavi-redactor),
- [Xhprof Debug panel](https://github.com/trntv/yii2-debug-xhprof)
- Sitemap generator
- Extended IDE autocompletion
- Test-ready
- Docker support and Vagrant support
- Built-in [mailcatcher](http://mailcatcher.me/)
- [Swagger](https://swagger.io/) for API docs.

## DEMO
Demo is hosted by awesome [Digital Ocean](https://m.do.co/c/d7f000191ea8)
- Frontend: [http://yii2-starter-kit.terentev.net](http://yii2-starter-kit.terentev.net)
- Backend: [http://backend.yii2-starter-kit.terentev.net](http://backend.yii2-starter-kit.terentev.net)

`administrator` role account
```
Login: webmaster
Password: webmaster
```

`manager` role account
```
Login: manager
Password: manager
```

`user` role account
```
Login: user
Password: user
```

## How to contribute?
You can contribute in any way you want. Any help appreciated, but most of all i need help with docs (^_^)

## Have any questions?
Mail to [eugene@terentev.net](mailto:eugene@terentev.net) or [victor@vgr.cl](mailto:victor@vgr.cl)

## READ MORE
- [Yii2](https://github.com/yiisoft/yii2/tree/master/docs)
- [Docker](https://docs.docker.com/get-started/)


### NOTE
This template was created mostly for developers NOT for end users.
This is a point where you can start your application, rather than creating it from scratch.
Good luck!

