<?php require 'db.php'; 

$perPage = 10;
$page    = max(1, (int)($_GET['page'] ?? 1));  // tránh page <= 0
$offset  = ($page - 1) * $perPage;

// Đếm tổng số bản ghi
$totalStmt = $pdo->query("SELECT COUNT(*) FROM users");
$total     = $totalStmt->fetchColumn();
$lastPage  = max(1, ceil($total / $perPage));

// Lấy dữ liệu trang hiện tại
// Cách đúng: bind kiểu INT cho LIMIT và OFFSET
$sql   = "SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt  = $pdo->prepare($sql);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background:#f8f9fa; }</style>
</head>
<body class="container mt-5">

<h2 class="mb-4">Danh sách người dùng <small class="text-muted">(Tổng: <?= number_format($total) ?>)</small></h2>
<a href="index.php" class="btn btn-primary mb-3">Thêm người dùng mới</a>

<?php if ($total == 0): ?>
    <div class="alert alert-info">Chưa có dữ liệu nào. Hãy đăng ký người dùng đầu tiên!</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Account Type</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['first_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($u['last_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($u['phone'] ?? '') ?></td>
                    <td>
                        <span class="badge bg-<?= $u['account_type'] == 'Business' ? 'warning' : 'success' ?>">
                            <?= $u['account_type'] ?? 'Personal' ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination đẹp hơn -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page-1 ?>">« Previous</a>
            </li>
            <?php 
            $start = max(1, $page - 2);
            $end   = min($lastPage, $page + 2);
            for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $lastPage ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page+1 ?>">Next »</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

</body>
</html>