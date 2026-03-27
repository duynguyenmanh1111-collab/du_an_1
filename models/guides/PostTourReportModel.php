<?php

class PostTourReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    /**
     * Lấy thông tin booking + tour + assignment, đảm bảo guide được phân công booking đó
     */
    public function getAssignedBookingForGuide($booking_id, $guide_id)
{
    $sql = "
        SELECT 
            b.id AS booking_id,
            b.start_date,
            b.end_date,
            b.status AS booking_status,
            b.guide_id,
            
            t.id AS tour_id,
            t.name AS tour_name,
            
            g.id AS guide_id_check
        FROM bookings b
        JOIN tours t ON b.tour_id = t.id
        JOIN guides g ON b.guide_id = g.id
        WHERE b.id = :booking_id
          AND g.user_id = :guide_id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':booking_id' => $booking_id,
        ':guide_id'   => $guide_id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    /**
     * Kiểm tra xem booking này đã được báo cáo chưa
     */
    public function hasReport($booking_id)
    {
        $sql = "
            SELECT id 
            FROM tour_assignments_reports 
            WHERE booking_id = :booking_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':booking_id' => $booking_id]);

        return $stmt->fetch() !== false;
    }

    /**
     * Tạo báo cáo mới
     * $data gồm:
     *  - booking_id, guide_id, tour_summary, customer_situation, incidents, suggestions, image_paths (array)
     */
    public function createReport($data)
    {
        // Bắt đầu transaction để đảm bảo atomic: insert report + insert ảnh
        try {
            $this->db->beginTransaction();

            $sql = "
                INSERT INTO tour_assignments_reports
                (booking_id, guide_id, tour_summary, customer_situation, incidents, suggestions, created_at)
                VALUES
                (:booking_id, :guide_id, :tour_summary, :customer_situation, :incidents, :suggestions, NOW())
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':booking_id'         => $data['booking_id'],
                ':guide_id'           => $data['guide_id'],
                ':tour_summary'       => $data['tour_summary'],
                ':customer_situation' => $data['customer_situation'],
                ':incidents'          => $data['incidents'],
                ':suggestions'        => $data['suggestions']
            ]);

            $reportId = $this->db->lastInsertId();

            // Nếu có ảnh đính kèm
            if (!empty($data['images']) && is_array($data['images'])) {
                $sqlImg = "INSERT INTO tour_report_images (report_id, image_path) VALUES (:report_id, :image_path)";
                $stmtImg = $this->db->prepare($sqlImg);

                foreach ($data['images'] as $img) {
                    $stmtImg->execute([
                        ':report_id'  => $reportId,
                        ':image_path' => $img
                    ]);
                }
            }

            $this->db->commit();
            return $reportId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Lấy báo cáo cùng ảnh theo booking_id
     */
    public function getReportByBooking($booking_id)
    {
        $sql = "
            SELECT r.*, u.name AS guide_name
            FROM tour_assignments_reports r
            JOIN users u ON r.guide_id = u.id
            WHERE r.booking_id = :booking_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':booking_id' => $booking_id]);
        $report = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$report) return null;

        // Lấy ảnh
        $sqlImg = "
            SELECT image_path 
            FROM tour_report_images 
            WHERE report_id = :report_id
            ORDER BY id ASC
        ";
        $stmtImg = $this->db->prepare($sqlImg);
        $stmtImg->execute([':report_id' => $report['id']]);
        $report['images'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN);

        return $report;
    }
    public function insertReport($guide_id, $booking_id, $description)
{
    $sql = "
        INSERT INTO tour_assignments_reports (guide_id, booking_id, description, created_at)
        VALUES (:guide_id, :booking_id, :description, NOW())
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':guide_id' => $guide_id,
        ':booking_id' => $booking_id,
        ':description' => $description
    ]);

    return $this->db->lastInsertId(); 
}

}
