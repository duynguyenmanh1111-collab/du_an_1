<?php
require_once __DIR__ . '/../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
  <div class="main-page">
    <div class="col_3">
      <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
          <i class="pull-left fa fa-dollar icon-rounded"></i>
          <div class="stats">
            <h5><strong><?= $bookingDone ?></strong></h5>
            <span>Tổng Booking</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
          <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
          <div class="stats">
            <h5><strong><?= $totalGuides ?></strong></h5>
            <span>Tổng Hướng Dẫn viên</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
          <i class="pull-left fa fa-money user2 icon-rounded"></i>
          <div class="stats">
            <h5><strong><?= $totalRevenue ?></strong></h5>
            <span>Doanh thu</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
          <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
          <div class="stats">
            <h5><strong><?= $totalCustomers ?></strong></h5>
            <span>Tổng khách hàng</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 widget">
        <div class="r3_counter_box">
          <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
          <div class="stats">
            <h5><strong>1450</strong></h5>
            <span>Total Users</span>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="row-one widgettable">
      <div class="col-md-7 content-top-2 card">
        <div class="agileinfo-cdr">
          <div class="card-header">
            <h3>Weekly Sales</h3>
          </div>
          <div id="Linegraph" style="width: 98%; height: 350px"></div>
        </div>
      </div>
      <div class="col-md-3 stat">
        <div class="content-top-1">
          <div class="col-md-6 top-content">
            <h5>Sales</h5>
            <label>1283+</label>
          </div>
          <div class="col-md-6 top-content1">
            <div
              id="demo-pie-1"
              class="pie-title-center"
              data-percent="45">
              <span class="pie-value"></span>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="content-top-1">
          <div class="col-md-6 top-content">
            <h5>Reviews</h5>
            <label>2262+</label>
          </div>
          <div class="col-md-6 top-content1">
            <div
              id="demo-pie-2"
              class="pie-title-center"
              data-percent="75">
              <span class="pie-value"></span>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="content-top-1">
          <div class="col-md-6 top-content">
            <h5>Visitors</h5>
            <label>12589+</label>
          </div>
          <div class="col-md-6 top-content1">
            <div
              id="demo-pie-3"
              class="pie-title-center"
              data-percent="90">
              <span class="pie-value"></span>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-2 stat">
        <div class="content-top">
          <div class="top-content facebook">
            <a href="#"><i class="fa fa-facebook"></i></a>
          </div>
          <ul class="info">
            <li class="col-md-6">
              <b>1,296</b>
              <p>Friends</p>
            </li>
            <li class="col-md-6">
              <b>647</b>
              <p>Likes</p>
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>
        <div class="content-top">
          <div class="top-content twitter">
            <a href="#"><i class="fa fa-twitter"></i></a>
          </div>
          <ul class="info">
            <li class="col-md-6">
              <b>1,997</b>
              <p>Followers</p>
            </li>
            <li class="col-md-6">
              <b>389</b>
              <p>Tweets</p>
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>
        <div class="content-top">
          <div class="top-content google-plus">
            <a href="#"><i class="fa fa-google-plus"></i></a>
          </div>
          <ul class="info">
            <li class="col-md-6">
              <b>1,216</b>
              <p>Followers</p>
            </li>
            <li class="col-md-6">
              <b>321</b>
              <p>shares</p>
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="charts">
      <div class="col-md-4 charts-grids widget">
        <div class="card-header">
          <h3>Bar chart</h3>
        </div>
        <div id="container" style="width: 100%; height: 270px">
          <canvas id="canvas"></canvas>
        </div>
        <button id="randomizeData">Randomize Data</button>
        <button id="addDataset">Add Dataset</button>
        <button id="removeDataset">Remove Dataset</button>
        <button id="addData">Add Data</button>
        <button id="removeData">Remove Data</button>
      </div>
      <div class="col-md-4 charts-grids widget states-mdl">
        <div class="card-header">
          <h3>Column & Line Graph</h3>
        </div>
        <div id="chartdiv"></div>
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- for amcharts js -->
    <script src="commons/js/amcharts.js"></script>
    <script src="commons/js/serial.js"></script>
    <script src="commons/js/export.min.js"></script>
    <link
      rel="stylesheet"
      href="commons/css/export.css"
      type="text/css"
      media="all" />
    <script src="commons/js/light.js"></script>
    <!-- for amcharts js -->
    <script src="commons/js/index1.js"></script>


  </div>
</div>
<!-- <style>
  html,
  body {
    overflow: auto !important;
    height: auto !important;
    max-height: none !important;
  }
</style> -->
<?php
require_once __DIR__ . '/../layout/admin/footer.php';
?>