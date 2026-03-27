<?php
require_once __DIR__ . '/../layout/admin/header.php';

?>


<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">
		<div class="tables">
			<h2 class="title1">Quản lý tài khoản</h2>
			<div class="bs-example widget-shadow" data-example-id="hoverable-table">
				<h4>Danh sách tài khoản</h4>
				<div class="mb-3">
					<a href="<?= BASE_URL ?>?act=user-create" class="btn btn-sm btn-primary">
						<i class="fa fa-plus"></i> Thêm mới
					</a>
				</div>

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tên đăng nhập</th>
								<th>Email</th>
								<th>Full Name</th>
								<th>Role</th>
								<th>Phone</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Trạng thái </th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($users)): ?>
								<tr>
									<td colspan="8" class="text-center">
										<i class="fa fa-info-circle"></i> Không có dữ liệu
									</td>
								</tr>
							<?php else: ?>
								<?php foreach ($users as $user): ?>
									<tr>
										<th scope="row"><?php echo $user['id']; ?></th>
										<td><?php echo htmlspecialchars($user['username']); ?></td>
										<td><?php echo htmlspecialchars($user['email']); ?></td>
										<td><?php echo htmlspecialchars($user['full_name']); ?></td>
										<td>
											<?php if ($user['role'] === 'admin'): ?>
												<span class="badge badge-danger">Admin</span>
											<?php else: ?>
												<span class="badge badge-primary">Guide</span>
											<?php endif; ?>
										</td>
										<td><?php echo htmlspecialchars($user['phone']); ?></td>
										<td><?php echo htmlspecialchars($user['created_at']); ?></td>
										<td><?php echo htmlspecialchars($user['updated_at']); ?></td>

										<td>
											<?php if ($user['status'] === 'active'): ?>
												<span class="badge badge-success">Hoạt động</span>
											<?php elseif ($user['status'] === 'inactive'): ?>
												<span class="badge badge-secondary">Bị khóa</span>
											<?php endif; ?>

										</td>
										<td>
											<a href="<?= BASE_URL ?>?act=admin-edit-user&id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">
												<i class="fa fa-edit"></i> Sửa
											</a>
											<a href="<?= BASE_URL ?>?act=admin-delete-user&id=<?= $user['id'] ?>"
												class="btn btn-sm btn-danger"
												onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')">
												<i class="fa fa-trash"></i> Xóa
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
require_once __DIR__ . '/../layout/admin/footer.php';
?>