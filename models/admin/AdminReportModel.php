<?php

class AdminReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    // Lấy danh sách tất cả báo cáo
    public function getAllReports()
{
    $sql = "
        SELECT 
            r.id,
            r.description,
            r.created_at,
            u.full_name AS guide_name,
            b.id AS booking_id,
            t.name AS tour_name
        FROM tour_assignments_reports r
        JOIN users u ON r.guide_id = u.id
        JOIN bookings b ON r.booking_id = b.id
        JOIN tours t ON b.tour_id = t.id
        ORDER BY r.created_at DESC
    ";

    $stmt = $this->db->query($sql);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reports as &$report) {
        $stmtImg = $this->db->prepare("
            SELECT image_path 
            FROM tour_report_images 
            WHERE report_id = :id
        ");
        $stmtImg->execute([':id' => $report['id']]);
        $report['images'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN);
    }

    return $reports;
}

    public function getOneReport($id)
{
    $sql = "
        SELECT 
            r.id,
            r.description,
            r.created_at,
            u.full_name AS guide_name,
            t.name AS tour_name,
            b.id AS booking_id
        FROM tour_assignments_reports r
        JOIN users u ON r.guide_id = u.id
        JOIN bookings b ON r.booking_id = b.id
        JOIN tours t ON b.tour_id = t.id
        WHERE r.id = :id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lấy danh sách ảnh
    $stmtImg = $this->db->prepare("
        SELECT image_path 
        FROM tour_report_images 
        WHERE report_id = :id
    ");
    $stmtImg->execute([':id' => $id]);
    $report['images'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN);

    return $report;
}


}
