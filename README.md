# TaskManager Laravel Package

A team-based Task Management system for Laravel with roles, notifications, localization, and config publishing.

## 🚀 Features
- Team-based task management (Admin, Manager, Member)
- Role & permission support (Spatie)
- Notification system
- Localization (Arabic & English)
- Config publishing
- Migration publishing
- View publishing
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
]
```
Then run:
```bash
composer require alaa/task-manager:dev-main
```

### 2. Publish package resources
```bash
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-config
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-lang
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-views
php artisan vendor:publish --provider="Alaa\\TaskManager\\Providers\\TaskManagerServiceProvider" --tag=taskmanager-migrations
```

## 🛠 Usage
- All task and notification routes are auto-registered.
- Use models:
```php
use Alaa\TaskManager\Models\Task;
use Alaa\TaskManager\Models\Notification;
```
- Use translations:
```php
__('taskmanager.roles.admin')
__('taskmanager.success_messages.task.created')
```
- Update config in `config/taskmanager.php` after publishing.
- Update translations in `resources/lang/vendor/taskmanager/ar/taskmanager.php` or `en/taskmanager.php`.

## 📝 Customization
- You can override views by editing the published files in `resources/views/vendor/taskmanager/`.
- You can override config and lang files as needed.

## 🧑‍💻 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## 📄 License
[MIT](LICENSE)

## 📬 Contact
For questions or support, contact: your-email@example.com 