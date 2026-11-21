<?php
$uploadDir = __DIR__ . '/uploads/';
$name = basename($_GET['file'] ?? '');
$path = $uploadDir . $name;

if ($name !== '' && is_file($path)) {
    unlink($path);
}

header('Location: index.php');
exit; 