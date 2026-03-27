<?php
/**
 * Database connection helper
 * Sử dụng getDB() từ helpers/database.php
 */

function connectDB()
{
    return getDB();
}

/**
 * Upload file helper
 * @param array $file - $_FILES array element
 * @param string $folder - Thư mục lưu file (trong uploads/)
 * @return string|false - Tên file mới hoặc false nếu thất bại
 */
function uploadFile($file, $folder = 'uploads')
{
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return false;
    }

    $uploadDir = BASE_PATH . '/' . $folder . '/';

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Tạo tên file mới để tránh trùng lặp
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = time() . '_' . uniqid() . '.' . $extension;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $newFileName;
    }

    return false;
}

/**
 * Delete file helper
 * @param string $filePath - Đường dẫn file cần xóa
 * @return bool
 */
function deleteFile($filePath)
{
    $fullPath = BASE_PATH . '/' . $filePath;
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}
