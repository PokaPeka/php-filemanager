<?php
class Config {
    private static array $settings = [];

    public static function set(string $key, mixed $value): void {
        self::$settings[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed {
        return self::$settings[$key] ?? $default;
    }

    public static function all(): array {
        return self::$settings;
    }

    public static function remove(string $key): void {
        if (array_key_exists($key, self::$settings)) {
            unset(self::$settings[$key]);
        }
    }
}

echo "<h2>Задание 3: Класс-хранилище настроек</h2>";

Config::set('app_name', 'MyAwesomeApp');
Config::set('debug_mode', true);
Config::set('max_users', 100);
Config::set('theme', 'dark');

echo "Получение существующего ключа 'app_name': " . Config::get('app_name') . "<br>";
echo "Получение несуществующего ключа 'api_key' с дефолтным значением: " . var_export(Config::get('api_key', 'default_api_key_123'), true) . "<br><br>";

echo "<strong>Все настройки до удаления:</strong><br>";
echo "<pre>" . print_r(Config::all(), true) . "</pre>";

Config::remove('theme');
echo "<strong>Все настройки после удаления 'theme':</strong><br>";
echo "<pre>" . print_r(Config::all(), true) . "</pre>";
?>