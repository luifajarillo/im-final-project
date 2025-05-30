<?php include("mysqli_connect.php"); ?>

<style>
.modal2 {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal2.show {
    display: flex;
}
</style>

<main id="users-section" class="main-section" style="display: none;">
    <div class="head-title">
        <div class="left">
            <h1>Users</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Users</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">All Users</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>

    <!-- 🔽 Users Table Here -->
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Registered Users</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users ORDER BY created_at DESC";
                    $result = $dbcon->query($sql);
                    while($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <a href="#" onclick="event.preventDefault(); openDeleteModal2('<?= $row['user_id'] ?>', 'users')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal2" class="modal2">
    <div style="background:#fff; padding:20px; text-align:center; min-width: 300px;">
        <h3>Are you sure you want to delete this user?</h3>
        <form method="POST" action="actions/delete_user.php">
            <input type="hidden" name="id" id="deleteId2">
            <button type="submit">Yes, Delete</button>
            <button type="button" onclick="closeDeleteModal2()">Cancel</button>
        </form>
    </div>
</div>

<script src="/JLougawan/js/admin.js"></script>