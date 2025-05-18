<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JLougawan - Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="admin-container">
        <h2>Welcome, Admin</h2>

        <div class="admin-cards">
            <div class="admin-card">
                <h3>Manage Menu</h3>
                <p>Edit, add, or remove porridge items from your menu.</p>
                <a href="manage-menu.php" class="admin-btn">Go</a>
            </div>
            
            <div class="admin-card">
                <h3>View Orders</h3>
                <p>Check recent orders and track customer requests.</p>
                <a href="orders.php" class="admin-btn">Go</a>
            </div>

            <div class="admin-card">
                <h3>Manage Users</h3>
                <p>View or remove registered users.</p>
                <a href="users.php" class="admin-btn">Go</a>
            </div>
        </div>
    </main>
</body>
</html>