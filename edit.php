<?php include('includes/db.php'); ?>
<?php include('includes/header.php'); ?>

<?php
global $conn;
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h2>Kullanıcı Düzenle</h2>
<form action="process.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="text" name="first_name" class="form-control mb-2" value="<?= $row['first_name'] ?>" required>
    <input type="text" name="last_name" class="form-control mb-2" value="<?= $row['last_name'] ?>" required>
    <input type="text" name="phone" class="form-control mb-2" value="<?= $row['phone'] ?>" required>
    <input type="email" name="email" class="form-control mb-2" value="<?= $row['email'] ?>" required>
    <textarea name="note" class="form-control mb-2"><?= $row['note'] ?></textarea>
    <button type="submit" name="update_user" class="btn btn-success">Güncelle</button>
</form>

<?php include('includes/footer.php'); ?>
