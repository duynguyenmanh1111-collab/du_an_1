<?php
require_once __DIR__ . '/../layout/admin/header.php';

?>

<div id="page-wrapper">
    <div class="main-page">
        <div class="page-header">
            <h2 class="title1">🌍 Bản đồ phân bố khách hàng</h2>
        </div>

        <!-- Thống kê nhanh -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-3">
                <div class="stats-card">
                    <h3><?php echo count($mapData); ?></h3>
                    <p>Địa điểm</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3><?php echo array_sum(array_column($mapData, 'total_customers')); ?></h3>
                    <p>Tổng khách hàng</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3><?php echo array_sum(array_column($mapData, 'total_bookings')); ?></h3>
                    <p>Tổng booking</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3><?php echo !empty($mapData) ? $mapData[0]['country'] : 'N/A'; ?></h3>
                    <p>Thị trường lớn nhất</p>
                </div>
            </div>
        </div>

        <!-- Bản đồ Google Charts GeoChart -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bản đồ thế giới</h3>
                    </div>
                    <div class="panel-body">
                        <div id="geoChart" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Chi tiết theo quốc gia</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Quốc gia</th>
                                    <th>Địa điểm</th>
                                    <th class="text-right">Số booking</th>
                                    <th class="text-right">Số khách hàng</th>
                                    <th class="text-right">Tỷ lệ %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = array_sum(array_column($mapData, 'total_customers'));
                                foreach ($mapData as $data):
                                    $percent = $total > 0 ? ($data['total_customers'] / $total * 100) : 0;
                                ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($data['country']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($data['location']); ?></td>
                                        <td class="text-right"><?php echo $data['total_bookings']; ?></td>
                                        <td class="text-right">
                                            <span class="badge badge-primary"><?php echo $data['total_customers']; ?></span>
                                        </td>
                                        <td class="text-right"><?php echo number_format($percent, 1); ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Dữ liệu từ PHP
    const phpData = <?php echo $mapDataJson; ?>;

    // Chuyển đổi dữ liệu cho Google Charts
    const chartData = phpData.map(item => [
        item.country,
        parseInt(item.total_customers)
    ]);

    // Load Google Charts
    google.charts.load('current', {
        'packages': ['geochart']
    });

    google.charts.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Country');
        data.addColumn('number', 'Customers');
        data.addRows(chartData);

        const options = {
            colorAxis: {
                colors: ['#e3f2fd', '#64b5f6', '#1976d2', '#0d47a1']
            },
            backgroundColor: '#f5f7fa',
            datalessRegionColor: '#f0f0f0',
            defaultColor: '#f5f5f5',
            legend: 'none',
            tooltip: {
                textStyle: {
                    fontSize: 13
                }
            }
        };

        const chart = new google.visualization.GeoChart(
            document.getElementById('geoChart')
        );

        chart.draw(data, options);
    }

    // Responsive
    window.addEventListener('resize', () => {
        drawRegionsMap();
    });
</script>

<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .stats-card h3 {
        font-size: 2.5em;
        margin: 0 0 10px 0;
        font-weight: bold;
    }

    .stats-card p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9em;
    }

    .panel {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .badge-primary {
        background: #667eea;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 1em;
    }
</style>

<?php
require_once __DIR__ . '/../layout/admin/footer.php';
?>