<?php
include('includes/db.php');
global $conn;
if (isset($_POST['add_user'])) {
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $_POST['note']);
    $stmt->execute();
    header("Location: index.php");
}

if (isset($_POST['update_user'])) {
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, phone=?, email=?, note=? WHERE id=?");
    $stmt->bind_param("sssssi", $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $_POST['note'], $_POST['id']);
    $stmt->execute();
    header("Location: index.php");
}

if (isset($_GET['id'])) {
    $conn->query("DELETE FROM users WHERE id=" . $_GET['id']);
    header("Location: index.php");
}
?>
