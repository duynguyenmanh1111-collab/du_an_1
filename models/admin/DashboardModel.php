<?php


class DashboardModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Booking đã đi (completed / confirmed và end_date < hôm nay)
    public function getBookingDone()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM bookings ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Booking đang đi (start_date <= hôm nay <= end_date)
    public function getBookingOngoing()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM bookings 
                WHERE status='confirmed' 
                AND start_date <= CURDATE() 
                AND end_date >= CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Tổng số khách hàng (distinct customer_id)
    public function getTotalCustomers()
    {
        $sql = "SELECT COUNT(*) AS total FROM bookings_people;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Tổng số hướng dẫn viên
    public function getTotalGuides()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM users 
                WHERE role='guide'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Tổng doanh thu (booking đã thanh toán)
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(tours.price * max_people) AS revenue
        FROM bookings
        JOIN tours ON bookings.tour_id = tours.id
        
        AND bookings.end_date < CURDATE()
        AND bookings.status = 'completed'
";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['revenue'] ?? 0;
    }
}
