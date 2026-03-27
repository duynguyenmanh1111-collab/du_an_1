<?php

class GuidesModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function jobinformation($user_id)
    {
        $sql = "SELECT 
    b.*,

    /* =======================
            TOUR
    ======================== */
    JSON_OBJECT(
        'id', t.id,
        'name', t.name,
        'price', t.price,
        'status', t.status,
        'description', t.description
    ) AS tour,

    /* =======================
            CATEGORY
    ======================== */
    JSON_OBJECT(
        'id', c.id,
        'name', c.name,
        'description', c.description
    ) AS category,

    /* =======================
            DESTINATION
    ======================== */
    JSON_OBJECT(
        'id', d.id,
        'name', d.name,
        'location', d.location,
        'description', d.description
    ) AS destination,

   
   
    /* =======================
            GUIDE (from guides)
    ======================== */
    JSON_OBJECT(
        'id', g.id,
        'full_name', g.full_name,
        'specialization', g.specialization,
        'experience_years', g.experience_years,
        'certificates', g.certificates,
        'languages', g.languages,
        'user_id', g.user_id
    ) AS guide,

    /* =======================
            USER (from users)
    ======================== */
    JSON_OBJECT(
        'id', u.id,
        'username', u.username,
        'email', u.email,
        'phone', u.phone,
        'role', u.role,
        'status', u.status
    ) AS user,

    /* ========== SUB QUERY ========== */
    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', tr.id,
                'type', tr.type,
                'company', tr.company,
                'seats', tr.seats,
                'driver_name', tr.driver_name,
                'driver_cccd', tr.driver_cccd,
                'driver_phone', tr.driver_phone,
                'driver_birthdate', tr.driver_birthdate,
                'license_plate', tr.license_plate,
                'pickup_location', tr.pickup_location,
                'pickup_address', tr.pickup_address,
                'pickup_time', tr.pickup_time
            )
        )
        FROM transports tr
        WHERE tr.booking_id = b.id
    ) AS transports,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', bp.id,
                'fullname', bp.fullname,
                'phone', bp.phone,
                'date', bp.date
            )
        )
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS people,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', s.id,
                'day_number', s.day_number,
                'location', s.location,
                'activities', s.activities,
                'guide_id', s.guide_id,
                'status', s.status,
                'notes', s.notes
            )
        )
        FROM schedules s
        WHERE s.tour_id = b.tour_id
    ) AS schedules,

    
    (
    SELECT JSON_ARRAYAGG(
        JSON_OBJECT(
            'id', a.id,
            'booking_id', a.booking_id,
            'tour_id', a.tour_id,
            'name', a.name,
            'sdt', a.sdt,
            'address', a.address,
            'type', a.type,
            'created_at', a.created_at,
            'updated_at', a.updated_at
        )
    )
    FROM accommodations a
    WHERE a.booking_id = b.id
) AS accommodations,
    (
        SELECT COUNT(*)
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS number_of_people

FROM bookings b
LEFT JOIN tours t ON t.id = b.tour_id
LEFT JOIN tour_categories c ON c.id = t.category_id
LEFT JOIN destinations d ON d.id = t.destination_id

/* =========================
       JOIN GUIDE
========================= */
INNER JOIN guides g ON g.id = b.guide_id

/* =========================
       JOIN USER GUIDE
========================= */
INNER JOIN users u ON u.id = g.user_id

/* =========================
       ⭐ FILTER BY USER_ID - SỬA DÙNG PREPARED STATEMENT
========================= */
WHERE g.user_id = :user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($booking_id)
    {
        $sql = "SELECT 
        b.*,

        /* =======================
                TOUR
        ======================== */
        JSON_OBJECT(
            'id', t.id,
            'name', t.name,
            'price', t.price,
            'status', t.status,
            'description', t.description
        ) AS tour,

        /* =======================
                CATEGORY
        ======================== */
        JSON_OBJECT(
            'id', c.id,
            'name', c.name,
            'description', c.description
        ) AS category,

        /* =======================
                DESTINATION
        ======================== */
        JSON_OBJECT(
            'id', d.id,
            'name', d.name,
            'location', d.location,
            'description', d.description
        ) AS destination,

       

        /* =======================
                GUIDE (from guides)
        ======================== */
        JSON_OBJECT(
            'id', g.id,
            'full_name', g.full_name,
            'specialization', g.specialization,
            'experience_years', g.experience_years,
            'certificates', g.certificates,
            'languages', g.languages,
            'user_id', g.user_id
        ) AS guide,

        /* =======================
                USER (from users)
        ======================== */
        JSON_OBJECT(
            'id', u.id,
            'username', u.username,
            'email', u.email,
            'phone', u.phone,
            'role', u.role,
            'status', u.status
        ) AS user,

        /* ========== SUB QUERY ========== */
        (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', tr.id,
                    'type', tr.type,
                    'company', tr.company,
                    'seats', tr.seats
                )
            )
            FROM transports tr
            WHERE tr.booking_id = b.id
        ) AS transports,

        (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', bp.id,  
                    'fullname', bp.fullname,
                    'phone', bp.phone,
                    'date', bp.date
                )
            )
            FROM bookings_people bp
            WHERE bp.booking_id = b.id
        ) AS people,

        /* ✅ SỬA: schedules liên kết qua tour_id */
        (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', s.id,
                    'day_number', s.day_number,
                    'location', s.location,
                    'activities', s.activities,
                    'guide_id', s.guide_id,
                    'status', s.status,
                    'notes', s.notes
                )
            )
            FROM schedules s
            WHERE s.tour_id = b.tour_id
        ) AS schedules,

        

        (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', a.id,
                    'tour_id', a.tour_id,
                    'booking_id', a.booking_id,
                    'name', a.name,
                    'address', a.address,
                    'type', a.type,
                    'created_at', a.created_at,
                    'updated_at', a.updated_at
                )
            )
            FROM accommodations a
            WHERE a.booking_id = b.id
        ) AS accommodations,

        (
            SELECT COUNT(*)
            FROM bookings_people bp
            WHERE bp.booking_id = b.id
        ) AS number_of_people

    FROM bookings b
    LEFT JOIN tours t ON t.id = b.tour_id
    LEFT JOIN tour_categories c ON c.id = t.category_id
    LEFT JOIN destinations d ON d.id = t.destination_id
    INNER JOIN guides g ON g.id = b.guide_id
    INNER JOIN users u ON u.id = g.user_id
    WHERE b.id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function jobStatus($user_id)
    {
        $sql = "
    SELECT 
        COUNT(*) as total_records,
        SUM(CASE WHEN b.status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN b.status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
        SUM(CASE WHEN b.status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
        SUM(CASE WHEN b.status = 'completed' THEN 1 ELSE 0 END) as completed
    FROM bookings b
    INNER JOIN guides g ON g.id = b.guide_id
    WHERE g.user_id = :user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function booking_people($booking_id)
    {
        $sql = "SELECT *
                FROM bookings_people
                WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // === THÊM VÀO GuidesModel.php ===

    public function getAttendanceDates($booking_id)
    {
        $sql = "SELECT date, is_locked 
            FROM attendance_dates 
            WHERE booking_id = :booking_id 
            ORDER BY date ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thay thế hàm getAttendanceHistory cũ
    public function getAttendanceHistory($booking_id, $date, $session = null)
    {
        $sql = "SELECT 
                bp.id,
                bp.fullname,
                bp.phone,
                bp.date as birthdate,
                a.status,
                a.note,
                a.checkin_time,
                a.session
            FROM bookings_people bp
            LEFT JOIN attendances a 
                ON a.booking_people_id = bp.id 
                AND a.attendance_date = :date
                AND a.session = :session
            WHERE bp.booking_id = :booking_id
            ORDER BY bp.fullname";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $booking_id,
            'date'       => $date,
            'session'    => $session ?? 'morning'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật saveAttendance để hỗ trợ session
    public function saveAttendance($booking_id, $date, $session, $data)
    {
        // Kiểm tra chỉ được điểm danh hôm nay
        $today = date('Y-m-d');
        if ($date !== $today) {
            return ['success' => false, 'message' => 'Chỉ được điểm danh vào hôm nay!'];
        }

        // Kiểm tra ngày có trong attendance_dates
        $check = $this->conn->prepare("SELECT 1 FROM attendance_dates WHERE booking_id = ? AND date = ?");
        $check->execute([$booking_id, $date]);
        if (!$check->fetch()) {
            return ['success' => false, 'message' => 'Ngày điểm danh không hợp lệ!'];
        }

        $this->conn->beginTransaction();
        try {
            $sql = "INSERT INTO attendances 
                (booking_people_id, attendance_date, session, status, note, checkin_time) 
                VALUES (?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                status = VALUES(status),
                note = VALUES(note),
                checkin_time = NOW()";

            $stmt = $this->conn->prepare($sql);

            foreach ($data['people'] as $person) {
                $status = isset($data['attendance'][$person['id']]) ? 'present' : 'absent';
                $note   = $data['notes'][$person['id']] ?? '';

                $stmt->execute([
                    $person['id'],
                    $date,
                    $session,
                    $status,
                    $note
                ]);
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'Điểm danh buổi ' . $this->getSessionLabel($session) . ' thành công!'];
        } catch (Exception $e) {
            $this->conn->rollBack();
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    // Hàm hỗ trợ hiển thị tên buổi tiếng Việt
    private function getSessionLabel($session)
    {
        return match ($session) {
            'morning' => 'Sáng',
            'afternoon' => 'Chiều',
            'evening' => 'Tối',
            default => 'Không xác định'
        };
    }
    // Trong controller khi lấy chi tiết booking
    public function getAttendanceForBooking($booking_id)
    {
        // Lấy chi tiết điểm danh
        $sql = "SELECT 
                a.*,
                bp.fullname,
                bp.phone,
                bp.date,
                bp.cccd,
                DATE_FORMAT(a.attendance_date, '%d/%m/%Y') as formatted_date
            FROM attendances a
            INNER JOIN bookings_people bp ON bp.id = a.people_id
            WHERE a.booking_id = :booking_id
            ORDER BY a.attendance_date, a.session, bp.fullname";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        $attendances = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy tổng quan theo ngày
        $sql = "SELECT 
                attendance_date,
                DATE_FORMAT(attendance_date, '%d/%m/%Y') as formatted_date,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_count
            FROM attendances
            WHERE booking_id = :booking_id
            GROUP BY attendance_date
            ORDER BY attendance_date";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        $summary = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'attendances' => $attendances,
            'attendance_summary' => $summary
        ];
    }
}
