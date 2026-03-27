<?php
class BookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ==========================================
    // HELPER METHOD
    // ==========================================

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    // ✅ KIỂM TRA SỐ CHỖ CÒN TRỐNG
    public function checkAvailableSeats($bookingId)
    {
        $sql = "SELECT 
                b.max_people,
                (SELECT COUNT(*) FROM bookings_people WHERE booking_id = b.id) as current_people
                FROM bookings b
                WHERE b.id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'max_people' => $result['max_people'],
            'current_people' => $result['current_people'],
            'available_seats' => $result['max_people'] - $result['current_people']
        ];
    }

    // ==========================================
    // LẤY DANH SÁCH VÀ CHI TIẾT BOOKING
    // ==========================================

    // ==========================================
    // LẤY DANH SÁCH VÀ CHI TIẾT BOOKING
    // ==========================================

    public function getAllBookings()
    {
        $sql = "SELECT 
b.*,

/* ============================
        TOUR
============================ */
JSON_OBJECT(
    'id', t.id,
    'name', t.name,
    'price', t.price,
    'status', t.status,
    'description', t.description
) AS tour,

/* ============================
        CATEGORY
============================ */
JSON_OBJECT(
    'id', c.id,
    'name', c.name,
    'description', c.description
) AS category,

/* ============================
        DESTINATION
============================ */
JSON_OBJECT(
    'id', d.id,
    'name', d.name,
    'location', d.location,
    'description', d.description
) AS destination,

/* ============================
        GUIDE
============================ */
JSON_OBJECT(
    'id', g.id,
    'full_name', g.full_name,
    'specialization', g.specialization,
    'experience_years', g.experience_years,
    'certificates', g.certificates,
    'languages', g.languages
) AS guide,

/* ============================
        USER (Guide belongs to user)
============================ */
JSON_OBJECT(
    'id', u.id,
    'username', u.username,
    'email', u.email,
    'phone', u.phone,
    'role', u.role,
    'status', u.status
) AS user,

/* ============================
        TRANSPORTS
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', tr.id,
        'booking_id', tr.booking_id,
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
        'pickup_time', tr.pickup_time,
        'created_at', tr.created_at,
        'updated_at', tr.updated_at
    )
)
FROM transports tr 
WHERE tr.booking_id = b.id
) AS transports,

/* ============================
        PEOPLE
============================ */
(
    SELECT JSON_ARRAYAGG(
        JSON_OBJECT(
            'id', bp.id,
            'fullname', bp.fullname,
            'phone', bp.phone,
            'date', bp.date,
            'cccd', bp.cccd,
            'note', bp.note
        )
    )
    FROM bookings_people bp 
    WHERE bp.booking_id = b.id
) AS people,

/* ============================
        SCHEDULES (theo tour_id)
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', s.id,
        'day_number', s.day_number,
        'location', s.location,
        'activities', s.activities,
        'status', s.status,
        'notes', s.notes
    )
)
FROM schedules s 
WHERE s.tour_id = b.tour_id
) AS schedules,

/* ============================
        ACCOMMODATIONS
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', a.id,
        'booking_id', a.booking_id,
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
) AS accommodations  -- ✅ XÓA DẤU PHẨY Ở ĐÂY

FROM bookings b
LEFT JOIN tours t ON t.id = b.tour_id
LEFT JOIN tour_categories c ON c.id = t.category_id
LEFT JOIN destinations d ON d.id = t.destination_id
LEFT JOIN guides g ON g.id = b.guide_id
LEFT JOIN users u ON u.id = g.user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================

    public function getBookingById($id)
    {
        $sql = "SELECT 
b.*,

/* ============================
        TOUR
============================ */
JSON_OBJECT(
    'id', t.id,
    'name', t.name,
    'price', t.price,
    'status', t.status,
    'description', t.description
) AS tour,

/* ============================
        CATEGORY
============================ */
JSON_OBJECT(
    'id', c.id,
    'name', c.name,
    'description', c.description
) AS category,

/* ============================
        DESTINATION
============================ */
JSON_OBJECT(
    'id', d.id,
    'name', d.name,
    'location', d.location,
    'description', d.description
) AS destination,

/* ============================
        GUIDE
============================ */
JSON_OBJECT(
    'id', g.id,
    'full_name', g.full_name,
    'specialization', g.specialization,
    'experience_years', g.experience_years,
    'certificates', g.certificates,
    'languages', g.languages
) AS guide,

/* ============================
        USER (Guide belongs to user)
============================ */
JSON_OBJECT(
    'id', u.id,
    'username', u.username,
    'email', u.email,
    'phone', u.phone,
    'role', u.role,
    'status', u.status
) AS user,

/* ============================
        TRANSPORTS
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', tr.id,
        'booking_id', tr.booking_id,
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
        'pickup_time', tr.pickup_time,
        'created_at', tr.created_at,
        'updated_at', tr.updated_at
    )
)
FROM transports tr 
WHERE tr.booking_id = b.id
) AS transports,

/* ============================
        PEOPLE
============================ */
(
    SELECT JSON_ARRAYAGG(
        JSON_OBJECT(
            'id', bp.id,
            'fullname', bp.fullname,
            'phone', bp.phone,
            'date', bp.date,
            'cccd', bp.cccd,
            'note', bp.note
        )
    )
    FROM bookings_people bp 
    WHERE bp.booking_id = b.id
) AS people,

/* ============================
        SCHEDULES (theo tour_id)
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', s.id,
        'day_number', s.day_number,
        'location', s.location,
        'activities', s.activities,
        'status', s.status,
        'notes', s.notes
    )
)
FROM schedules s 
WHERE s.tour_id = b.tour_id
) AS schedules,

/* ============================
        ACCOMMODATIONS
============================ */
(
SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
        'id', a.id,
        'booking_id', a.booking_id,
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
) AS accommodations  -- ✅ XÓA DẤU PHẨY Ở ĐÂY

FROM bookings b
LEFT JOIN tours t ON t.id = b.tour_id
LEFT JOIN tour_categories c ON c.id = t.category_id
LEFT JOIN destinations d ON d.id = t.destination_id
LEFT JOIN guides g ON g.id = b.guide_id
LEFT JOIN users u ON u.id = g.user_id
WHERE b.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // ==========================================
    // CRUD BOOKING CHÍNH
    // ==========================================

    public function createBooking($data)
    {
        $sql = "INSERT INTO bookings (tour_id, guide_id, start_date, end_date, special_request, max_people)
            VALUES (:tour_id, :guide_id, :start_date, :end_date, :special_request, :max_people)";

        $stmt = $this->conn->prepare($sql);
        $data['max_people'] = $data['max_people'] ?? 30;
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }
    public function updateBooking($id, $data)
    {
        $sql = "UPDATE bookings SET 
                tour_id = :tour_id,
                guide_id = :guide_id,
                payment_status = :payment_status,
                status = :status,
                special_request = :special_request,
                start_date = :start_date,
                end_date = :end_date,
                max_people = :max_people,
                updated_at = NOW()
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ==========================================
    // TRANSPORTS - Phương tiện (FIXED)
    // ==========================================

    // ✅ CẬP NHẬT createTransports
    public function createTransports($bookingId, $data)
    {
        $sql = "INSERT INTO transports (
        booking_id, type, company, seats,
        driver_name, driver_phone, driver_cccd, 
        driver_birthdate, license_plate,
        pickup_location, pickup_address, pickup_time
    ) VALUES (
        :booking_id, :type, :company, :seats,
        :driver_name, :driver_phone, :driver_cccd,
        :driver_birthdate, :license_plate,
        :pickup_location, :pickup_address, :pickup_time
    )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'type' => $data['type'] ?? '',
            'company' => $data['company'] ?? '',
            'seats' => $data['seats'] ?? 0,
            'driver_name' => !empty($data['driver_name']) ? $data['driver_name'] : null,
            'driver_phone' => !empty($data['driver_phone']) ? $data['driver_phone'] : null,
            'driver_cccd' => !empty($data['driver_cccd']) ? $data['driver_cccd'] : null,
            'driver_birthdate' => !empty($data['driver_birthdate']) ? $data['driver_birthdate'] : null,
            'license_plate' => !empty($data['license_plate']) ? $data['license_plate'] : null,
            'pickup_location' => $data['pickup_location'] ?? '',
            'pickup_address' => $data['pickup_address'] ?? '',
            'pickup_time' => !empty($data['pickup_time']) ? $data['pickup_time'] : null
        ]);
        return $this->conn->lastInsertId();
    }

    // ✅ CẬP NHẬT updateTransports
    public function updateTransports($transportId, $bookingId, $data)
    {
        $sql = "UPDATE transports SET 
        type = :type,
        company = :company,
        seats = :seats,
        driver_name = :driver_name,
        driver_phone = :driver_phone,
        driver_cccd = :driver_cccd,
        driver_birthdate = :driver_birthdate,
        license_plate = :license_plate,
        pickup_location = :pickup_location,
        pickup_address = :pickup_address,
        pickup_time = :pickup_time
        WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'type' => $data['type'] ?? '',
            'company' => $data['company'] ?? '',
            'seats' => $data['seats'] ?? 0,
            'driver_name' => $data['driver_name'] ?? '',
            'driver_phone' => $data['driver_phone'] ?? '',
            'driver_cccd' => $data['driver_cccd'] ?? '',
            'driver_birthdate' => !empty($data['driver_birthdate']) ? $data['driver_birthdate'] : null,
            'license_plate' => $data['license_plate'] ?? '',
            'pickup_location' => $data['pickup_location'] ?? '',
            'pickup_address' => $data['pickup_address'] ?? '',
            'pickup_time' => !empty($data['pickup_time']) ? $data['pickup_time'] : null,
            'id' => $transportId,
            'booking_id' => $bookingId
        ]);
        return true;
    }

    public function deleteTransports($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM transports WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM transports 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // ACCOMMODATIONS - Chỗ ở
    // ==========================================

    public function updateAccommodations($accommodationId, $bookingId, $data)
    {
        $sql = "UPDATE accommodations SET 
            name = :name,
            address = :address,
            type = :type,
            sdt = :sdt
            WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'type' => $data['type'],
            'sdt' => !empty($data['sdt']) ? $data['sdt'] : null,
            'id' => $accommodationId,
            'booking_id' => $bookingId
        ]);
        return true;
    }
    public function createAccommodations($bookingId, $data)
    {
        $sql = "INSERT INTO accommodations (booking_id, name, address, type, sdt) 
            VALUES (:booking_id, :name, :address, :type, :sdt)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'name' => $data['name'],
            'address' => $data['address'],
            'type' => $data['type'],
            'sdt' => !empty($data['sdt']) ? $data['sdt'] : null
        ]);
        return $this->conn->lastInsertId();
    }

    public function deleteAccommodations($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM accommodations WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM accommodations 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // PEOPLE - Người tham gia
    // ==========================================

    /**
     * ✅ KIỂM TRA TRÙNG LẶP THÔNG TIN TRONG HỆ THỐNG
     * Kiểm tra xem người này đã tồn tại trong database chưa (dựa trên tên+ngày sinh, CCCD, hoặc SĐT)
     */
    public function checkDuplicatePersonInSystem($fullname, $date, $cccd, $phone, $excludeId = null)
    {
        $sql = "SELECT id, fullname, phone, date, cccd, booking_id
                FROM bookings_people
                WHERE (
                    (LOWER(TRIM(fullname)) = LOWER(TRIM(:fullname)) AND date = :date)
                    OR (cccd = :cccd AND cccd != '' AND cccd IS NOT NULL AND :cccd != '')
                    OR (phone = :phone AND phone != '' AND phone IS NOT NULL AND :phone != '')
                )";

        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
        }

        $sql .= " LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $params = [
            'fullname' => trim($fullname),
            'date' => $date,
            'cccd' => $cccd ?? '',
            'phone' => $phone ?? ''
        ];

        if ($excludeId) {
            $params['exclude_id'] = $excludeId;
        }

        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ KIỂM TRA NGƯỜI NÀY ĐÃ CÓ TRONG BOOKING NÀY CHƯA
     */
    public function checkPersonExistsInBooking($bookingId, $fullname, $date, $cccd, $phone)
    {
        $sql = "SELECT id, fullname, phone, date, cccd
                FROM bookings_people
                WHERE booking_id = :booking_id
                AND (
                    (LOWER(TRIM(fullname)) = LOWER(TRIM(:fullname)) AND date = :date)
                    OR (cccd = :cccd AND cccd != '' AND cccd IS NOT NULL AND :cccd != '')
                    OR (phone = :phone AND phone != '' AND phone IS NOT NULL AND :phone != '')
                )
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'fullname' => trim($fullname),
            'date' => $date,
            'cccd' => $cccd ?? '',
            'phone' => $phone ?? ''
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ KIỂM TRA TRÙNG LỊCH TOUR
     */
    public function checkPersonScheduleConflict($personId, $startDate, $endDate, $excludeBookingId = null)
    {
        $sql = "SELECT b.id, b.start_date, b.end_date, t.name as tour_name
                FROM bookings_people bp
                INNER JOIN bookings b ON bp.booking_id = b.id
                INNER JOIN tours t ON b.tour_id = t.id
                WHERE bp.id = :person_id
                AND b.status NOT IN ('cancelled')
                AND (
                    (b.start_date <= :end_date AND b.end_date >= :start_date)
                    OR (b.start_date >= :start_date AND b.start_date <= :end_date)
                )";

        if ($excludeBookingId) {
            $sql .= " AND b.id != :exclude_booking_id";
        }

        $stmt = $this->conn->prepare($sql);
        $params = [
            'person_id' => $personId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        if ($excludeBookingId) {
            $params['exclude_booking_id'] = $excludeBookingId;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ LẤY DANH SÁCH NGƯỜI CÓ SẴN (Không trùng lịch)
     */
    public function getAvailablePeople($startDate, $endDate, $excludeBookingId = null)
    {
        $sql = "SELECT DISTINCT 
                    bp.id,
                    bp.fullname,
                    bp.phone,
                    bp.date,
                    bp.cccd,
                    bp.note,
                    COUNT(DISTINCT bp.booking_id) as total_bookings
                FROM bookings_people bp
                WHERE bp.id NOT IN (
                    SELECT bp2.id 
                    FROM bookings_people bp2
                    INNER JOIN bookings b2 ON bp2.booking_id = b2.id
                    WHERE (
                        (b2.start_date <= :end_date AND b2.end_date >= :start_date)
                        OR (b2.start_date >= :start_date AND b2.start_date <= :end_date)
                    )
                    AND b2.status NOT IN ('cancelled')";

        if ($excludeBookingId) {
            $sql .= " AND b2.id != :exclude_booking_id";
        }

        $sql .= ")
                GROUP BY bp.id, bp.fullname, bp.phone, bp.date, bp.cccd
                ORDER BY bp.fullname ASC";

        $stmt = $this->conn->prepare($sql);
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        if ($excludeBookingId) {
            $params['exclude_booking_id'] = $excludeBookingId;
        }

        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debug log
        error_log("✅ getAvailablePeople: Tìm thấy " . count($result) . " người");
        error_log("   Start: $startDate, End: $endDate, Exclude: " . ($excludeBookingId ?? 'none'));

        return $result;
    }

    /**
     * ✅ THÊM NGƯỜI MỚI (Có kiểm tra trùng lặp đầy đủ)
     */
    public function createPeople($bookingId, $data)
    {
        // 1. Kiểm tra giới hạn chỗ
        $seats = $this->checkAvailableSeats($bookingId);
        if ($seats['available_seats'] <= 0) {
            throw new Exception("❌ Booking đã đầy! Hiện có {$seats['current_people']}/{$seats['max_people']} người.");
        }

        // 2. Chuẩn hóa dữ liệu
        $fullname = trim($data['fullname'] ?? '');
        $date = $data['date'] ?? date('Y-m-d');
        $cccd = trim($data['cccd'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $note = trim($data['note'] ?? '');

        if (empty($fullname)) {
            throw new Exception("❌ Vui lòng nhập họ tên!");
        }

        // 3. Kiểm tra trùng lặp TRONG BOOKING NÀY
        $existsInBooking = $this->checkPersonExistsInBooking($bookingId, $fullname, $date, $cccd, $phone);
        if ($existsInBooking) {
            throw new Exception("❌ Người này đã có trong booking này! (Trùng: {$existsInBooking['fullname']})");
        }

        // 4. Thêm vào database
        $sql = "INSERT INTO bookings_people (booking_id, fullname, phone, date, cccd, note) 
                VALUES (:booking_id, :fullname, :phone, :date, :cccd, :note)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'fullname' => $fullname,
            'phone' => $phone,
            'date' => $date,
            'cccd' => $cccd,
            'note' => $note
        ]);

        return $this->conn->lastInsertId();
    }

    /**
     * ✅ THÊM NGƯỜI CÓ SẴN VÀO BOOKING
     */
    public function addExistingPersonToBooking($bookingId, $personId)
    {
        // 1. Lấy thông tin người từ ID
        $sql = "SELECT fullname, phone, date, cccd 
                FROM bookings_people 
                WHERE id = :person_id 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['person_id' => $personId]);
        $person = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$person) {
            throw new Exception("❌ Không tìm thấy thông tin người này!");
        }

        // 2. Kiểm tra giới hạn chỗ
        $seats = $this->checkAvailableSeats($bookingId);
        if ($seats['available_seats'] <= 0) {
            throw new Exception("❌ Booking đã đầy! Hiện có {$seats['current_people']}/{$seats['max_people']} người.");
        }

        // 3. Kiểm tra người này đã có trong booking chưa
        $existsInBooking = $this->checkPersonExistsInBooking(
            $bookingId,
            $person['fullname'],
            $person['date'],
            $person['cccd'],
            $person['phone']
        );

        if ($existsInBooking) {
            throw new Exception("❌ Người này đã có trong booking này!");
        }

        // 4. Thêm bản sao mới vào booking
        return $this->createPeople($bookingId, $person);
    }

    /**
     * ✅ CẬP NHẬT THÔNG TIN NGƯỜI
     */
    public function updatePeople($personId, $bookingId, $data)
    {
        $sql = "UPDATE bookings_people SET 
                fullname = :fullname,
                phone = :phone,
                date = :date,   
                cccd = :cccd,
                note = :note
                WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'fullname' => trim($data['fullname']),
            'phone' => trim($data['phone']),
            'date' => $data['date'],
            'cccd' => trim($data['cccd']),
            'note' => trim($data['note']),
            'id' => $personId,
            'booking_id' => $bookingId
        ]);
        return true;
    }

    /**
     * ✅ XÓA NGƯỜI (Giữ lại những người trong $keepIds)
     */
    public function deletePeople($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM bookings_people WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM bookings_people 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // LẤY DANH SÁCH CHO FORM
    // ==========================================

    public function allCategory()
    {
        $sql = "SELECT * FROM tour_categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allDestination()
    {
        $sql = "SELECT * FROM destinations";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allTour()
    {
        $sql = "SELECT 
    t.*, 
    c.name AS category_name, 
    d.name AS destination_name,
    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', s.id, 
                'day_number', s.day_number, 
                'location', s.location, 
                'activities', s.activities, 
                'notes', s.notes, 
                'status', s.status
            )
        )
        FROM schedules s 
        WHERE s.tour_id = t.id 
        ORDER BY s.day_number
    ) AS schedules
FROM tours t
LEFT JOIN tour_categories c ON t.category_id = c.id
LEFT JOIN destinations d ON t.destination_id = d.id
ORDER BY t.id DESC;
";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allGuide()
    {
        $sql = "SELECT 
                g.*, 
                u.id AS user_id, 
                u.username, 
                u.full_name AS user_full_name, 
                u.email, 
                u.phone, 
                u.role, 
                u.status
                FROM guides g
                LEFT JOIN users u ON u.id = g.user_id";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // ==========================================
// KIỂM TRA TRÙNG LỊCH HƯỚNG DẪN VIÊN
// ==========================================

    /**
     * ✅ KIỂM TRA HDV CÓ TRÙNG LỊCH KHÔNG
     */
    public function checkGuideScheduleConflict($guideId, $startDate, $endDate, $excludeBookingId = null)
    {
        $sql = "SELECT b.id, b.start_date, b.end_date, t.name as tour_name
            FROM bookings b
            INNER JOIN tours t ON b.tour_id = t.id
            WHERE b.guide_id = :guide_id
            AND b.status NOT IN ('cancelled')
            AND (
                (b.start_date <= :end_date AND b.end_date >= :start_date)
                OR (b.start_date >= :start_date AND b.start_date <= :end_date)
            )";

        if ($excludeBookingId) {
            $sql .= " AND b.id != :exclude_booking_id";
        }

        $stmt = $this->conn->prepare($sql);
        $params = [
            'guide_id' => $guideId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        if ($excludeBookingId) {
            $params['exclude_booking_id'] = $excludeBookingId;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ LẤY DANH SÁCH HDV CÓ SẴN (Không trùng lịch)
     */
    public function getAvailableGuides($startDate, $endDate, $excludeBookingId = null)
    {
        $sql = "SELECT DISTINCT 
                g.*,
                u.username,
                u.email,
                u.phone,
                COUNT(DISTINCT b.id) as total_tours
            FROM guides g
            LEFT JOIN users u ON g.user_id = u.id
            LEFT JOIN bookings b ON g.id = b.guide_id
            WHERE g.id NOT IN (
                SELECT b2.guide_id 
                FROM bookings b2
                WHERE b2.guide_id IS NOT NULL
                AND (
                    (b2.start_date <= :end_date AND b2.end_date >= :start_date)
                    OR (b2.start_date >= :start_date AND b2.start_date <= :end_date)
                )
                AND b2.status NOT IN ('cancelled')";

        if ($excludeBookingId) {
            $sql .= " AND b2.id != :exclude_booking_id";
        }

        $sql .= ")
            GROUP BY g.id
            ORDER BY g.full_name ASC";

        $stmt = $this->conn->prepare($sql);
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        if ($excludeBookingId) {
            $params['exclude_booking_id'] = $excludeBookingId;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * ✅ LẤY LỊCH ĐIỂM DANH CỦA BOOKING
     */
    public function getBookingAttendances($bookingId)
    {
        $sql = "SELECT 
    a.*,
    bp.fullname,
    bp.phone,
    bp.date,
    bp.cccd,
    DATE_FORMAT(a.attendance_date, '%d/%m/%Y') as formatted_date,
    TIME_FORMAT(a.checkin_time, '%H:%i') as formatted_time
FROM attendances a
INNER JOIN bookings_people bp ON a.booking_people_id = bp.id
WHERE bp.booking_id = :booking_id
ORDER BY 
    a.attendance_date ASC,
    CASE a.session
        WHEN 'morning' THEN 1
        WHEN 'afternoon' THEN 2
        WHEN 'evening' THEN 3
        ELSE 4
    END,
    bp.fullname ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ LẤY TỔNG HỢP ĐIỂM DANH THEO NGÀY
     */
    public function getAttendanceSummaryByDate($bookingId)
    {
        $sql = "SELECT 
            a.attendance_date,
            DATE_FORMAT(a.attendance_date, '%d/%m/%Y') as formatted_date,
            COUNT(*) as total_records,
            SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as present_count,
            SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) as absent_count
        FROM attendances a
        INNER JOIN bookings_people bp ON a.booking_people_id = bp.id
        WHERE bp.booking_id = :booking_id
        GROUP BY a.attendance_date
        ORDER BY a.attendance_date ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
