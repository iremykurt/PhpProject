<?php
include('includes/db.php'); // Veritabanı bağlantısını dahil et

// Eğer URL'den "id" parametresi geldiyse
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Güvenlik için ID'nin sadece sayı olduğundan emin ol
    if (!is_numeric($id)) {
        die("Geçersiz ID!");
    }
    global $conn;
    // Silme sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?success=deleted"); // Başarı mesajıyla yönlendir
        exit();
    } else {
        echo "Silme işlemi başarısız!";
    }
} else {
    echo "Geçersiz istek!";
}
?>
