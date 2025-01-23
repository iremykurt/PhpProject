<?php
include('includes/db.php');
include('includes/header.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
global $conn;
if ($search != '') {
    // Kullanıcının arama girdiğine göre SQL sorgusunu güncelle
    $sql = "SELECT * FROM users WHERE 
            first_name LIKE ? OR 
            last_name LIKE ? OR 
            phone LIKE ? OR 
            email LIKE ?";

    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Varsayılan olarak tüm kullanıcıları listele
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
}
?>

<!-- Sayfa İçeriği -->
<div class="container mt-4">
    <h2 class="text-center">Kullanıcı Listesi</h2>

    <!-- Arama Formu -->
    <form action="" method="GET" class="mb-3">
        <div class="row justify-content-end">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Ad, Soyad, Telefon veya E-posta ara..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Ara</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Yeni Kullanıcı Ekle Butonu -->
    <a href="add.php" class="btn btn-success mb-3">Yeni Kullanıcı Ekle</a>

    <!-- Kullanıcı Listesi Tablosu -->
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Not</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['note'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Düzenle</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?')">Sil</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
