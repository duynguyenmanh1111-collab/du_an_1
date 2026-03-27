<?php

class AdminBookingController
{
    private $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        requireAdmin();
        $bookings = $this->bookingModel->getAllBookings();
        view('admin.bookings.list', [
            'title' => 'Quản lý Booking',
            'bookings' => $bookings,
        ]);
    }

    public function detail()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $booking = $this->bookingModel->getBookingById($id);
        if (!$booking) {
            $_SESSION['error'] = 'Booking không tồn tại!';
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $seats = $this->bookingModel->checkAvailableSeats($id);
        $attendances = $this->bookingModel->getBookingAttendances($id);
        $attendanceSummary = $this->bookingModel->getAttendanceSummaryByDate($id);

        view('admin.bookings.detail', [
            'title' => 'Chi tiết Booking',
            'booking' => $booking,
            'seats' => $seats,
            'attendances' => $attendances,
            'attendanceSummary' => $attendanceSummary,
        ]);
    }

    public function add()
    {
        requireAdmin();

        $categories = $this->bookingModel->allCategory();
        $tours = $this->bookingModel->allTour();
        $guides = $this->bookingModel->allGuide();
        $destinations = $this->bookingModel->allDestination();

        $availablePeople = [];
        $availableGuides = [];

        if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $availablePeople = $this->bookingModel->getAvailablePeople($_GET['start_date'], $_GET['end_date']);
            $availableGuides = $this->bookingModel->getAvailableGuides($_GET['start_date'], $_GET['end_date']);
        }

        view('admin.bookings.add', [
            'title' => 'Thêm Booking',
            'categories' => $categories,
            'tours' => $tours,
            'guides' => $guides,
            'destinations' => $destinations,
            'availablePeople' => $availablePeople,
            'availableGuides' => $availableGuides,
        ]);
    }

    public function create()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=bookings-add');
            exit;
        }

        $data = [
            'tour_id' => $_POST['tour_id'] ?? null,
            'guide_id' => $_POST['guide_id'] ?? null,
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'special_request' => $_POST['special_request'] ?? '',
            'max_people' => $_POST['max_people'] ?? 10,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ];

        $bookingId = $this->bookingModel->insert($data);

        if ($bookingId) {
            // Xử lý transports
            if (!empty($_POST['transports'])) {
                foreach ($_POST['transports'] as $transport) {
                    if (!empty($transport['type'])) {
                        $this->bookingModel->createTransports($bookingId, $transport);
                    }
                }
            }

            // Xử lý accommodations
            if (!empty($_POST['accommodations'])) {
                foreach ($_POST['accommodations'] as $accommodation) {
                    if (!empty($accommodation['name'])) {
                        $this->bookingModel->createAccommodations($bookingId, $accommodation);
                    }
                }
            }

            // Xử lý people
            if (!empty($_POST['peoples'])) {
                foreach ($_POST['peoples'] as $person) {
                    if (!empty($person['existing_id'])) {
                        $this->bookingModel->addExistingPersonToBooking($bookingId, $person['existing_id']);
                    } elseif (!empty($person['fullname'])) {
                        $this->bookingModel->createPeople($bookingId, $person);
                    }
                }
            }

            $_SESSION['success'] = 'Thêm booking thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        header('Location: ' . BASE_URL . '?act=bookings');
        exit;
    }

    public function edit()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $booking = $this->bookingModel->getBookingById($id);
        if (!$booking) {
            $_SESSION['error'] = 'Booking không tồn tại!';
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $categories = $this->bookingModel->allCategory();
        $tours = $this->bookingModel->allTour();
        $guides = $this->bookingModel->allGuide();
        $destinations = $this->bookingModel->allDestination();
        $seats = $this->bookingModel->checkAvailableSeats($id);

        view('admin.bookings.edit', [
            'title' => 'Sửa Booking',
            'booking' => $booking,
            'categories' => $categories,
            'tours' => $tours,
            'guides' => $guides,
            'destinations' => $destinations,
            'seats' => $seats,
        ]);
    }

    public function update()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=bookings');
            exit;
        }

        $data = [
            'tour_id' => $_POST['tour_id'] ?? null,
            'guide_id' => $_POST['guide_id'] ?? null,
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'special_request' => $_POST['special_request'] ?? '',
            'max_people' => $_POST['max_people'] ?? 10,
            'status' => $_POST['status'] ?? 'pending',
            'payment_status' => $_POST['payment_status'] ?? 'unpaid',
        ];

        $this->bookingModel->update($id, $data);
        $_SESSION['success'] = 'Cập nhật booking thành công!';
        header('Location: ' . BASE_URL . '?act=bookings-edit&id=' . $id);
        exit;
    }

    public function delete()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->bookingModel->delete($id);
            $_SESSION['success'] = 'Xóa booking thành công!';
        }
        header('Location: ' . BASE_URL . '?act=bookings');
        exit;
    }

    // API Endpoints
    public function getAvailablePeopleApi()
    {
        header('Content-Type: application/json');
        $start = $_GET['start_date'] ?? null;
        $end = $_GET['end_date'] ?? null;

        if (!$start || !$end) {
            echo json_encode(['error' => 'Missing dates', 'data' => []]);
            exit;
        }

        $people = $this->bookingModel->getAvailablePeople($start, $end);
        echo json_encode(['count' => count($people), 'data' => $people]);
        exit;
    }

    public function checkPersonConflictApi()
    {
        header('Content-Type: application/json');
        $personId = $_GET['person_id'] ?? null;
        $start = $_GET['start_date'] ?? null;
        $end = $_GET['end_date'] ?? null;
        $bookingId = $_GET['booking_id'] ?? null;

        $conflicts = $this->bookingModel->checkPersonScheduleConflict($personId, $start, $end, $bookingId);
        echo json_encode(['has_conflict' => !empty($conflicts), 'conflicts' => $conflicts]);
        exit;
    }

    public function checkGuideConflictApi()
    {
        header('Content-Type: application/json');
        $guideId = $_GET['guide_id'] ?? null;
        $start = $_GET['start_date'] ?? null;
        $end = $_GET['end_date'] ?? null;
        $bookingId = $_GET['booking_id'] ?? null;

        $conflicts = $this->bookingModel->checkGuideScheduleConflict($guideId, $start, $end, $bookingId);
        echo json_encode(['has_conflict' => !empty($conflicts), 'conflicts' => $conflicts]);
        exit;
    }

    public function getAvailableGuidesApi()
    {
        header('Content-Type: application/json');
        $start = $_GET['start_date'] ?? null;
        $end = $_GET['end_date'] ?? null;

        if (!$start || !$end) {
            echo json_encode(['error' => 'Missing dates', 'data' => []]);
            exit;
        }

        $guides = $this->bookingModel->getAvailableGuides($start, $end);
        echo json_encode(['count' => count($guides), 'data' => $guides]);
        exit;
    }
}
