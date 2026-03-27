<?php
// DEBUG: Bật hiển thị lỗi (tắt khi deploy production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Nạp cấu hình
$config = require __DIR__ . '/config/config.php';

// Nạp helpers
require_once __DIR__ . '/src/helpers/helpers.php';
require_once __DIR__ . '/src/helpers/database.php';
require_once __DIR__ . '/commons/function.php';

// Nạp models
require_once __DIR__ . '/src/models/User.php';
require_once __DIR__ . '/models/AuthModel.php';
require_once __DIR__ . '/models/admin/DashboardModel.php';
require_once __DIR__ . '/models/admin/IndexModel.php';
require_once __DIR__ . '/models/admin/UserModel.php';
require_once __DIR__ . '/models/admin/BookingModel.php';
require_once __DIR__ . '/models/admin/CategoryModel.php';
require_once __DIR__ . '/models/admin/DestinationModel.php';
require_once __DIR__ . '/models/admin/GuideModel.php';

// Nạp controllers
require_once __DIR__ . '/src/controllers/HomeController.php';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/controllers/admin/IndexController.php';
require_once __DIR__ . '/src/controllers/admin/UserController.php';
require_once __DIR__ . '/src/controllers/admin/BookingController.php';
require_once __DIR__ . '/src/controllers/admin/CategoryController.php';
require_once __DIR__ . '/src/controllers/admin/DestinationController.php';
require_once __DIR__ . '/src/controllers/admin/GuideController.php';

// Khởi tạo controllers
$homeController = new HomeController();
$authController = new AuthController();
$adminIndexController = new AdminIndexController();
$userController = new AdminUserController();
$bookingController = new AdminBookingController();
$categoryController = new AdminCategoryController();
$destinationController = new AdminDestinationController();
$guideController = new AdminGuideController();

// Route
$act = $_GET['act'] ?? '/';

match ($act) {
    // ===== PUBLIC =====
    '/', 'welcome' => $homeController->welcome(),
    'home' => $homeController->home(),

    // ===== AUTH =====
    'login' => $authController->login(),
    'check-login' => $authController->checkLogin(),
    'logout' => $authController->logout(),

    // ===== ADMIN DASHBOARD =====
    'admin' => $adminIndexController->index(),

    // ===== TOUR MANAGEMENT =====
    'tour-list' => $adminIndexController->tourList(),
    'tour-add' => $adminIndexController->tourAdd(),
    'tour-create' => $adminIndexController->tourCreate(),
    'tour-edit' => $adminIndexController->tourEdit(),
    'tour-update' => $adminIndexController->tourUpdate(),
    'tour-delete' => $adminIndexController->tourDelete(),

    // ===== USER MANAGEMENT =====
    'admin-list-user' => $userController->index(),
    'user-create' => $userController->create(),
    'user-store' => $userController->store(),
    'admin-edit-user' => $userController->edit(),
    'user-update' => $userController->update(),
    'user-delete' => $userController->delete(),
    'my-account' => $userController->myAccount(),

    // ===== BOOKING MANAGEMENT =====
    'bookings' => $bookingController->index(),
    'bookings-add' => $bookingController->add(),
    'bookings-create' => $bookingController->create(),
    'bookings-edit' => $bookingController->edit(),
    'bookings-update' => $bookingController->update(),
    'bookings-detail' => $bookingController->detail(),
    'bookings-delete' => $bookingController->delete(),
    'get-available-people-api' => $bookingController->getAvailablePeopleApi(),
    'check-person-conflict-api' => $bookingController->checkPersonConflictApi(),
    'check-guide-conflict-api' => $bookingController->checkGuideConflictApi(),
    'get-available-guides-api' => $bookingController->getAvailableGuidesApi(),

    // ===== CATEGORY MANAGEMENT =====
    'category' => $categoryController->index(),
    'category-add' => $categoryController->add(),
    'category-handle-add' => $categoryController->handleAdd(),
    'category-edit' => $categoryController->edit(),
    'category-handle-edit' => $categoryController->handleEdit(),
    'category-delete' => $categoryController->delete(),

    // ===== DESTINATION MANAGEMENT =====
    'destination' => $destinationController->index(),
    'destination-index' => $destinationController->index(),
    'destination-create' => $destinationController->create(),
    'destination-store' => $destinationController->store(),
    'destination-edit' => $destinationController->edit(),
    'destination-update' => $destinationController->update(),
    'destination-delete' => $destinationController->delete(),

    // ===== GUIDE MANAGEMENT =====
    'admin_guides' => $guideController->index(),
    'admin_guide_create' => $guideController->create(),
    'admin_guide_store' => $guideController->store(),
    'admin_guide_edit' => $guideController->edit(),
    'admin_guide_update' => $guideController->update(),
    'admin_guide_delete' => $guideController->delete(),

    // ===== DEFAULT =====
    default => $homeController->notFound(),
};
