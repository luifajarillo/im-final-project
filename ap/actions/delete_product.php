<?php
include("../mysqli_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $table = $_POST['table'];

    $allowedTables = ['base_foods', 'beverages', 'addons'];
    if (!in_array($table, $allowedTables)) {
        die("Invalid table.");
    }

    $idField = match($table) {
        'base_foods' => 'basefood_id',
        'beverages' => 'beverage_id',
        'addons' => 'addon_id',
    };

    // If deleting from base_foods, delete dependent addons first
    if ($table === 'base_foods') {
        $stmt = $dbcon->prepare("DELETE FROM addons WHERE basefood_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Now delete the actual item
    $stmt = $dbcon->prepare("DELETE FROM $table WHERE $idField = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error deleting product.";
    }
}
?>
