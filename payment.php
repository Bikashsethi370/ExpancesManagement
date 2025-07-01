
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat = $_POST['category_id'];
    $amt = $_POST['amount'];
    $date = $_POST['date'];
    $stmt = $pdo->prepare("INSERT INTO payments (category_id, amount, date) VALUES (?, ?, ?)");
    $stmt->execute([$cat, $amt, $date]);
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$currentMonth = date('Y-m');
$payments = $pdo->prepare("SELECT p.*, c.name AS category_name FROM payments p JOIN categories c ON p.category_id = c.id WHERE DATE_FORMAT(p.date, '%Y-%m') = ?");
$payments->execute([$currentMonth]);
$paymentList = $payments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h3>Payments - <?= date('F Y') ?></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentList as $pay): ?>
                <tr>
                    <td><?= htmlspecialchars($pay['category_name']) ?></td>
                    <td>₹<?= number_format($pay['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($pay['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#payModal">Add Payment</button>

    <div class="modal fade" id="payModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <select name="category_id" class="form-control mb-2" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="amount" class="form-control mb-2" placeholder="Amount" required>
            <input type="date" name="date" class="form-control" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add Payment</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
