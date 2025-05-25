<?php include("mysqli_connect.php"); ?>

<style>
.modal {
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
.modal.show {
    display: flex;
}
</style>

<main id="store-section" class="main-section" style="display: none;">
    <div class="head-title">
        <div class="left">
            <h1>My Store</h1>
        </div>
        <button onclick="location.href='add_product_form.php'" class="btn-download">
            <i class='bx bx-plus'></i> Add Product
        </button>
    </div>

    <div class="table-data">
        <div class="order">
            <h3>Base Foods</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th><th>Price</th><th>Available</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM base_foods";
                $result = $dbcon->query($query);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₱<?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['is_available'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="edit_product_form.php?id=<?= $row['basefood_id'] ?>">Edit</a> |
                        <a href="#" onclick="event.preventDefault(); openDeleteModal('<?= $row['basefood_id'] ?>', 'base_foods')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <h3>Beverages</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th><th>Price</th><th>Available</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM beverages";
                $result = $dbcon->query($query);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₱<?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['is_available'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="edit_product_form.php?id=<?= $row['beverage_id'] ?>">Edit</a> |
                        <a href="#" onclick="event.preventDefault(); openDeleteModal('<?= $row['beverage_id'] ?>', 'beverages')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

        <div class="table-data">
        <div class="order">
            <h3>Add Ons</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th><th>Price</th><th>Available</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM addons";
                $result = $dbcon->query($query);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₱<?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['is_available'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="edit_product_form.php?id=<?= $row['addon_id'] ?>">Edit</a> |
                        <a href="#" onclick="event.preventDefault(); openDeleteModal('<?= $row['addon_id'] ?>', 'addons')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div style="background:#fff; padding:20px; text-align:center; min-width: 300px;">
        <h3>Are you sure you want to delete this item?</h3>
        <form method="POST" action="actions/delete_product.php">
            <input type="hidden" name="id" id="deleteId">
            <input type="hidden" name="table" id="deleteTable">
            <button type="submit">Yes, Delete</button>
            <button type="button" onclick="closeDeleteModal()">Cancel</button>
        </form>
    </div>
</div>

<script src="/JLougawan/js/admin.js"></script>