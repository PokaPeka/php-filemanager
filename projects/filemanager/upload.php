<?php 
$uploadDir = __DIR__ . '/uploads/'; 

function back(string $param, string $text): void { 
    header('Location: index.php?' . $param . '=' . urlencode($text)); 
    exit; 
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && empty($_FILES) 
    && empty($_POST) 
    && ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) { 
    back('error', 'Размер запроса превышает post_max_size (' . ini_get('post_max_size') . ')'); 
} 

$file = $_FILES['userfile'] ?? null; 

if (!$file) { 
    back('error', 'Файл не был отправлен'); 
} 

$errorMessages = [ 
    UPLOAD_ERR_INI_SIZE   => 'Файл больше upload_max_filesize (' . ini_get('upload_max_filesize') . ')', 
    UPLOAD_ERR_FORM_SIZE  => 'Файл больше ограничения формы', 
    UPLOAD_ERR_PARTIAL    => 'Файл загружен частично', 
    UPLOAD_ERR_NO_FILE    => 'Файл не выбран', 
    UPLOAD_ERR_NO_TMP_DIR => 'Нет временной папки', 
    UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл', 
    UPLOAD_ERR_EXTENSION  => 'Загрузка остановлена расширением PHP', 
]; 

if ($file['error'] !== UPLOAD_ERR_OK) { 
    back('error', $errorMessages[$file['error']] ?? 'Неизвестная ошибка: ' . $file['error']); 
} 

$maxSize = 5 * 1024 * 1024; 
if ($file['size'] > $maxSize) { 
    back('error', 'Файл больше 5 МБ'); 
} 

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'docx', 'xlsx', 'zip']; 
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); 
if (!in_array($ext, $allowed, true)) { 
    back('error', 'Недопустимый тип файла: .' . $ext); 
} 

$name = basename($file['name']); 
$name = preg_replace('/[^\w.\-]/u', '_', $name); 

if (file_exists($uploadDir . $name)) { 
    $name = time() . '_' . $name; 
} 

if (move_uploaded_file($file['tmp_name'], $uploadDir . $name)) { 
    back('msg', 'Файл успешно загружен'); 
} else { 
    back('error', 'Не удалось сохранить файл на сервере'); 
} 