
<?php include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h3>Category List</h3>
    <ul class="list-group mb-3">
        <?php foreach ($categories as $cat): ?>
            <li class="list-group-item"><?= htmlspecialchars($cat['name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Category</button>

    <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="text" name="category_name" class="form-control" placeholder="Category name" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
