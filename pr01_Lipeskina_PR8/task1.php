<?php
class User {
    public function __construct(
        private string $login,
        private string $password,
        private string $email
    ) {
        echo "Объект создан: пользователь <strong>{$this->login}</strong><br>";
    }

    public function showInfo(): void {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0; background: #f9f9f9;'>";
        echo "Логин: {$this->login}<br>";
        echo "Пароль: ****<br>"; 
        echo "Email: {$this->email}<br>";
        echo "</div>";
    }

    public function __destruct() {
        echo "Пользователь <strong>{$this->login}</strong> удалён из системы.<br>";
    }
}

echo "<h2>Задание 1: Класс «Пользователь»</h2>";

$user1 = new User("ivan_petrov", "superSecret123", "ivan@example.com");
$user2 = new User("anna_smith", "qwerty000", "anna@example.com");

echo "<hr><h3>Информация о пользователях:</h3>";
$user1->showInfo();
$user2->showInfo();

echo "<hr><h3>Демонстрация работы деструктора через unset():</h3>";
echo "Вызываем unset(\$user1)...<br>";
unset($user1); 

echo "<br>Конец скрипта. Оставшиеся объекты будут уничтожены автоматически:<br>";
?>