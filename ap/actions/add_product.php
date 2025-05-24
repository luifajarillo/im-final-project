<?php
include("../mysqli_connect.php");
echo '<pre>';
print_r($_POST);
echo '</pre>';
//exit;

// Fetch posted values safely
$category = $_POST['category'] ?? '';
$basefood_id = $_POST['basefood_id'] ?? null;
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$imagePath = '';

// Validate category
$allowedCategories = ['base_foods', 'beverages', 'addons'];
if (!in_array($category, $allowedCategories)) {
    die("Invalid category.");
}

// If addons, validate basefood_id properly (int > 0)
if ($category === 'addons') {
    $basefood_id = (int)$basefood_id;
    if ($basefood_id <= 0) {
        die("Missing or invalid basefood_id for addon.");
    }
}

// Handle image upload if provided
if (!empty($_FILES['image']['name'])) {
    $originalName = basename($_FILES['image']['name']);
    $newFileName = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "", $originalName); // sanitize filename

    $uploadFolder = __DIR__ . "/../../media/menu/";
    $fullFilePath = $uploadFolder . $newFileName;
    $imagePath = "media/menu/" . $newFileName;

    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder, 0777, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fullFilePath)) {
        die("Error: Failed to upload image.");
    }
}

// Prepare SQL query and bind parameters based on category
switch ($category) {
    case 'base_foods':
        $query = "INSERT INTO base_foods (category_id, name, description, price, image_url) VALUES (1, ?, ?, ?, ?)";
        $stmt = $dbcon->prepare($query);
        if (!$stmt) die("Prepare failed: " . $dbcon->error);
        $stmt->bind_param("ssds", $name, $description, $price, $imagePath);
        break;

    case 'beverages':
        $query = "INSERT INTO beverages (category_id, name, price, image_url) VALUES (3, ?, ?, ?)";
        $stmt = $dbcon->prepare($query);
        if (!$stmt) die("Prepare failed: " . $dbcon->error);
        $stmt->bind_param("sds", $name, $price, $imagePath);
        break;

    case 'addons':
        $category_id = "2"; // string because the column is varchar
        $query = "INSERT INTO addons (category_id, basefood_id, name, price, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $dbcon->prepare($query);
        if (!$stmt) die("Prepare failed: " . $dbcon->error);
        $stmt->bind_param("sisds", $category_id, $basefood_id, $name, $price, $imagePath);
        break;

    default:
        die("Unsupported category.");
}

if ($stmt->execute()) {
    header("Location: ../store.php");
    exit();
} else {
    die("Execute failed: " . $stmt->error);
}
