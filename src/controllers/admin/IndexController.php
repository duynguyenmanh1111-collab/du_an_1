<?php

/**
 * Admin IndexController - Dashboard và Tour Management
 */
class AdminIndexController
{
    private $dashboardModel;
    private $indexModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
        $this->indexModel = new IndexModel();
    }

    /**
     * Dashboard - Trang chủ admin
     */
    public function index()
    {
        requireAdmin();

        $bookingDone = $this->dashboardModel->getBookingDone();
        $bookingOngoing = $this->dashboardModel->getBookingOngoing();
        $totalCustomers = $this->dashboardModel->getTotalCustomers();
        $totalGuides = $this->dashboardModel->getTotalGuides();
        $totalRevenue = $this->dashboardModel->getTotalRevenue();

        view('admin.dashboard', [
            'title' => 'Dashboard',
            'bookingDone' => $bookingDone,
            'bookingOngoing' => $bookingOngoing,
            'totalCustomers' => $totalCustomers,
            'totalGuides' => $totalGuides,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    /**
     * Danh sách tour
     */
    public function tourList()
    {
        requireAdmin();

        $tours = $this->indexModel->QlTour();

        view('admin.tours.list', [
            'title' => 'Quản lý Tour',
            'tours' => $tours,
        ]);
    }

    /**
     * Form thêm tour
     */
    public function tourAdd()
    {
        requireAdmin();

        $categories = $this->indexModel->allCategory();
        $destinations = $this->indexModel->allDestination();

        view('admin.tours.add', [
            'title' => 'Thêm Tour mới',
            'categories' => $categories,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Xử lý thêm tour
     */
    public function tourCreate()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=tour-add');
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'destination_id' => $_POST['destination_id'] ?? null,
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'status' => $_POST['status'] ?? 'open',
        ];

        $success = $this->indexModel->createQltour($data);

        if ($success && !empty($_POST['schedules'])) {
            $tourId = $this->indexModel->getLastInsertId();
            foreach ($_POST['schedules'] as $schedule) {
                if (!empty($schedule['day_number'])) {
                    $this->indexModel->createshedules($tourId, [
                        'day_number' => $schedule['day_number'],
                        'location' => $schedule['location'] ?? '',
                        'activities' => $schedule['activities'] ?? '',
                        'notes' => $schedule['notes'] ?? '',
                    ]);
                }
            }
        }

        $_SESSION['success'] = 'Thêm tour thành công!';
        header('Location: ' . BASE_URL . '?act=tour-list');
        exit;
    }

    /**
     * Form sửa tour
     */
    public function tourEdit()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=tour-list');
            exit;
        }

        $tour = $this->indexModel->findTour($id);
        if (!$tour) {
            $_SESSION['error'] = 'Không tìm thấy tour!';
            header('Location: ' . BASE_URL . '?act=tour-list');
            exit;
        }

        $categories = $this->indexModel->allCategory();
        $destinations = $this->indexModel->allDestination();

        view('admin.tours.edit', [
            'title' => 'Sửa Tour',
            'tour' => $tour,
            'categories' => $categories,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Xử lý cập nhật tour
     */
    public function tourUpdate()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=tour-list');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=tour-list');
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'destination_id' => $_POST['destination_id'] ?? null,
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'status' => $_POST['status'] ?? 'open',
        ];

        $this->indexModel->updateqltour($id, $data);

        // Xử lý schedules
        if (isset($_POST['schedules'])) {
            $keptIds = [];
            foreach ($_POST['schedules'] as $schedule) {
                if (!empty($schedule['id'])) {
                    // Update existing
                    $this->indexModel->updateschedules($schedule['id'], $id, [
                        'day_number' => $schedule['day_number'],
                        'location' => $schedule['location'] ?? '',
                        'activities' => $schedule['activities'] ?? '',
                        'notes' => $schedule['notes'] ?? '',
                    ]);
                    $keptIds[] = $schedule['id'];
                } else if (!empty($schedule['day_number'])) {
                    // Create new
                    $this->indexModel->createshedules($id, [
                        'day_number' => $schedule['day_number'],
                        'location' => $schedule['location'] ?? '',
                        'activities' => $schedule['activities'] ?? '',
                        'notes' => $schedule['notes'] ?? '',
                    ]);
                    $newId = $this->indexModel->getLastInsertId();
                    if ($newId) $keptIds[] = $newId;
                }
            }
            // Delete removed schedules
            $this->indexModel->deleteshedules($id, $keptIds);
        }

        $_SESSION['success'] = 'Cập nhật tour thành công!';
        header('Location: ' . BASE_URL . '?act=tour-edit&id=' . $id);
        exit;
    }

    /**
     * Xóa tour
     */
    public function tourDelete()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->indexModel->deleteQltour($id);
            $_SESSION['success'] = 'Xóa tour thành công!';
        }

        header('Location: ' . BASE_URL . '?act=tour-list');
        exit;
    }
}
