<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="tables">
            <h2 class="title1">Chi tiết báo cáo</h2>

            <!-- Back Button -->
            <div class="mb-3" style="margin-bottom: 15px;">
                <a href="index.php?act=admin-reports" class="btn btn-secondary btn-sm back-btn">
                    <i class="fa fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>

            <!-- Report Header Card -->
            <div class="report-header-card">
                <div class="report-id-section">
                    <div class="id-badge-large">
                        #<?= $report['id'] ?? '' ?>
                    </div>
                    <div class="report-meta">
                        <h3>Báo cáo chuyến du lịch</h3>
                        <div class="meta-info">
                            <span class="meta-item">
                                <i class="fa fa-clock-o"></i>
                                <?= isset($report['created_at']) ? date('d-m-Y H:i', strtotime($report['created_at'])) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="report-grid">

                <!-- Left Column -->
                <div class="report-col-left">

                    <!-- Tour Info Card -->
                    <div class="info-card">
                        <div class="card-header-custom">
                            <i class="fa fa-map-marker icon-header"></i>
                            <h4>Thông tin Tour</h4>
                        </div>
                        <div class="card-body-custom">
                            <div class="info-item">
                                <label><i class="fa fa-suitcase"></i> Tên tour:</label>
                                <div class="info-value">
                                    <?= htmlspecialchars($report['tour_name'] ?? 'Không có dữ liệu') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guide Info Card -->
                    <div class="info-card">
                        <div class="card-header-custom">
                            <i class="fa fa-user icon-header"></i>
                            <h4>Hướng dẫn viên</h4>
                        </div>
                        <div class="card-body-custom">
                            <div class="guide-profile">
                                <div class="guide-avatar-large">
                                    <?= strtoupper(substr($report['guide_name'] ?? 'N', 0, 1)) ?>
                                </div>
                                <div class="guide-details">
                                    <h5><?= htmlspecialchars($report['guide_name'] ?? 'Không có dữ liệu') ?></h5>
                                    <span class="guide-role">Hướng dẫn viên</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="info-card">
                        <div class="card-header-custom">
                            <i class="fa fa-file-text-o icon-header"></i>
                            <h4>Mô tả báo cáo</h4>
                        </div>
                        <div class="card-body-custom">
                            <div class="description-content">
                                <?= nl2br(htmlspecialchars($report['description'] ?? 'Không có mô tả')) ?>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div class="report-col-right">

                    <!-- Images Card -->
                    <div class="info-card">
                        <div class="card-header-custom">
                            <i class="fa fa-picture-o icon-header"></i>
                            <h4>Hình ảnh đính kèm</h4>
                        </div>
                        <div class="card-body-custom">
                            <?php
                            $images = $report['images'] ?? [];
                            ?>

                            <?php if (!empty($images)): ?>
                                <div class="images-gallery">
                                    <?php foreach ($images as $index => $img): ?>
                                        <div class="image-item">
                                            <img src="<?= htmlspecialchars($img) ?>"
                                                alt="Image <?= $index + 1 ?>"
                                                class="gallery-image"
                                                onclick="openImageModal(this.src)">
                                            <div class="image-overlay">
                                                <i class="fa fa-search-plus"></i>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-images">
                                    <i class="fa fa-image"></i>
                                    <p>Không có hình ảnh đính kèm</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons Card -->
                    <div class="info-card">
                        <div class="card-header-custom">
                            <i class="fa fa-cog icon-header"></i>
                            <h4>Thao tác</h4>
                        </div>
                        <div class="card-body-custom">
                            <div class="action-buttons">
                                <button class="btn-action btn-print" onclick="window.print()">
                                    <i class="fa fa-print"></i>
                                    In báo cáo
                                </button>
                                <button class="btn-action btn-download">
                                    <i class="fa fa-download"></i>
                                    Tải xuống
                                </button>
                                <!-- <button class="btn-action btn-delete" onclick="return confirm('Bạn có chắc muốn xóa báo cáo này?')">
                                    <i class="fa fa-trash"></i>
                                    Xóa báo cáo
                                </button> -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<style>
    /* Mở khóa cuộn toàn trang */
    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    #wrapper,
    .wrapper {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    #page-wrapper,
    .content-wrapper {
        overflow: auto !important;
        height: auto !important;
        min-height: 100vh !important;
        max-height: none !important;
    }

    .main-page,
    .right_col,
    .container,
    .tables,
    .panel-body {
        overflow: visible !important;
        height: auto !important;
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }

    body,
    #wrapper,
    #page-wrapper {
        position: static !important;
    }

    /* ===== CUSTOM STYLES FOR REPORT DETAIL ===== */

    .title1 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }

    /* Back Button */
    .back-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #5a6268;
        transform: translateX(-5px);
        color: white;
    }

    /* Report Header Card */
    .report-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .report-id-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .id-badge-large {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 28px;
        font-weight: 700;
        padding: 20px 30px;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .report-meta {
        flex: 1;
    }

    .report-meta h3 {
        color: white;
        margin: 0 0 10px 0;
        font-size: 24px;
        font-weight: 600;
    }

    .meta-info {
        display: flex;
        gap: 20px;
    }

    .meta-item {
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .meta-item i {
        font-size: 16px;
    }

    /* Grid Layout */
    .report-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-top: 25px;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header-custom {
        background: linear-gradient(to right, #f8f9ff, #ffffff);
        padding: 18px 20px;
        border-bottom: 2px solid #e8ebf9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-custom h4 {
        margin: 0;
        color: #2d3748;
        font-size: 16px;
        font-weight: 600;
    }

    .icon-header {
        color: #667eea;
        font-size: 20px;
    }

    .card-body-custom {
        padding: 20px;
    }

    /* Info Items */
    .info-item {
        margin-bottom: 15px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item label {
        display: block;
        color: #718096;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item label i {
        margin-right: 5px;
        color: #667eea;
    }

    .info-value {
        background: #f8f9ff;
        padding: 12px 15px;
        border-radius: 8px;
        color: #2d3748;
        font-weight: 500;
        border-left: 3px solid #667eea;
    }

    /* Guide Profile */
    .guide-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9ff;
        border-radius: 10px;
    }

    .guide-avatar-large {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .guide-details h5 {
        margin: 0 0 5px 0;
        color: #2d3748;
        font-size: 18px;
        font-weight: 600;
    }

    .guide-role {
        color: #718096;
        font-size: 13px;
    }

    /* Description */
    .description-content {
        background: #f8f9ff;
        padding: 15px;
        border-radius: 8px;
        color: #2d3748;
        line-height: 1.8;
        border-left: 3px solid #667eea;
        white-space: pre-line;
    }

    /* Images Gallery */
    .images-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .image-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        cursor: pointer;
        aspect-ratio: 1;
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid #e8ebf9;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(102, 126, 234, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 10px;
    }

    .image-overlay i {
        color: white;
        font-size: 32px;
    }

    .image-item:hover .gallery-image {
        transform: scale(1.1);
    }

    .image-item:hover .image-overlay {
        opacity: 1;
    }

    /* No Images */
    .no-images {
        text-align: center;
        padding: 40px 20px;
        color: #718096;
    }

    .no-images i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .no-images p {
        margin: 0;
        font-size: 14px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-action {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-download {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: zoom 0.3s;
    }

    @keyframes zoom {
        from {
            transform: translate(-50%, -50%) scale(0);
        }

        to {
            transform: translate(-50%, -50%) scale(1);
        }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-close:hover {
        color: #bbb;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .report-grid {
            grid-template-columns: 1fr;
        }

        .report-id-section {
            flex-direction: column;
            text-align: center;
        }

        .id-badge-large {
            font-size: 24px;
            padding: 15px 25px;
        }

        .report-meta h3 {
            font-size: 20px;
        }

        .images-gallery {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }
    }

    @media (max-width: 576px) {
        .guide-profile {
            flex-direction: column;
            text-align: center;
        }

        .images-gallery {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Print Styles */
    @media print {

        .sticky-header,
        .back-btn,
        .action-buttons,
        .image-overlay {
            display: none !important;
        }

        .report-grid {
            grid-template-columns: 1fr;
        }

        .info-card {
            break-inside: avoid;
        }
    }
</style>

<script>
    function openImageModal(src) {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = src;
    }

    function closeImageModal() {
        document.getElementById("imageModal").style.display = "none";
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>