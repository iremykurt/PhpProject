<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<?php
// Hata mesajını ve form verilerini kontrol et
$error_message = "";
$first_name = $last_name = $phone = $email = $note = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $note = trim($_POST['note']);

    // Aynı e-posta veya telefon numarası olup olmadığını kontrol et
    $checkQuery = "SELECT * FROM users WHERE email = ? OR phone = ?";
    global $conn;
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Bu e-posta veya telefon numarası zaten kayıtlı!";
    } else {
        // Yeni kullanıcıyı ekle
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, note) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $phone, $email, $note);

        if ($stmt->execute()) {
            header("Location: index.php?success=added");
            exit();
        } else {
            $error_message = "Kayıt işlemi başarısız oldu, lütfen tekrar deneyin!";
        }
    }
}
?>

<h2>Yeni Kullanıcı Ekle</h2>

<!-- Hata Mesajı -->
<?php if ($error_message): ?>
    <div class="alert alert-danger"><?= $error_message ?></div>
<?php endif; ?>

<form action="add.php" method="POST">
    <input type="text" name="first_name" class="form-control mb-2" placeholder="Ad" value="<?= htmlspecialchars($first_name) ?>" required>
    <input type="text" name="last_name" class="form-control mb-2" placeholder="Soyad" value="<?= htmlspecialchars($last_name) ?>" required>
    <input type="text" name="phone" class="form-control mb-2" placeholder="Telefon" value="<?= htmlspecialchars($phone) ?>" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="E-mail" value="<?= htmlspecialchars($email) ?>" required>
    <textarea name="note" class="form-control mb-2" placeholder="Not"><?= htmlspecialchars($note) ?></textarea>
    <button type="submit" class="btn btn-success">Kaydet</button>
</form>

<?php include('includes/footer.php'); ?>
