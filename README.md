# TaskManager Laravel Package

A team-based Task Management system for Laravel with roles, notifications, localization, config, seeders, and full publishing support.

## 🚀 Features
- Team-based task management (Admin, Manager, Member)
- Role & permission support (Spatie)
- Notification system
- Localization (Arabic & English)
- Config, migration, view, lang, and seeder publishing
- Easy integration in any Laravel 12+ project

## 📦 Installation

### 1. Add the package (local path example)
In your main `composer.json`:
```json
"repositories": [
  {
    "type": "path",
    "url": "packages/Alaa/TaskManager"
  }
],
"require": {
  "alaa/taskmanager": "dev-main"
}
```
Then run:
```bash
composer require alaa/taskmanager:dev-main
```

### 2. Publish package resources
```bash
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-config
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-lang
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-views
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-migrations
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-seeders
```

## 🛠 Usage
- All task, team, and notification routes are auto-registered.
- Use models:
```php
use Alaa\TaskManager\Models\Task;
use Alaa\TaskManager\Models\Team;
use Alaa\TaskManager\Models\Notification;
```
- Use translations:
```php
__('taskmanager.roles.admin')
__('taskmanager.success_messages.task.created')
```
- Update config in `config/taskmanager.php` after publishing.
- Update translations in `resources/lang/vendor/taskmanager/ar/` or `en/`.
- Run seeders if needed:
```bash
php artisan db:seed --class="\\Database\\Seeders\\DemoDataSeeder"
```

## 📝 Customization
- You can override views by editing the published files in `resources/views/vendor/taskmanager/`.
- You can override config and lang files as needed.
- You can extend/override models and controllers as per Laravel conventions.

## 🧑‍💻 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## 🌍 Publishing to GitHub/Packagist
- Make sure your composer.json and README are up to date.
- Push the package to your GitHub repository.
- For Packagist, submit your GitHub repo URL.

## 📄 License
[MIT](LICENSE)

## 📬 Contact
For questions or support, open an issue on GitHub or contact the maintainer. 