<?php
require 'authentication.php'; // admin authentication check 
session_start();

// تحقق من المصادقة
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// استعلام لجلب الفئات
$db = new Database();
$conn = $db->dbConnection();
$sql = "SELECT * FROM categories ORDER BY category_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_name', $category_name);
    if ($stmt->execute()) {
        header('Location: categories.php');
        exit();
    } else {
        echo "حدث خطأ أثناء إضافة الفئة.";
    }
}

if (isset($_GET['delete_category'])) {
    $category_id = $_GET['category_id'];
    $sql = "DELETE FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    if ($stmt->execute()) {
        header('Location: categories.php');
        exit();
    } else {
        echo "حدث خطأ أثناء حذف الفئة.";
    }
}

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الفئات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body>
<div class="container">
    <h
