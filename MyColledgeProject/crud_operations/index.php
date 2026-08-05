<?php 
// We put on our grown-up hat (header)!
include("header.php"); ?>
<?php 
// We open the secret pipe to the treasure box!
include("connection.php"); ?>


<!-- This is the big title that says "We are in charge of products!" -->
<div class="box1 d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded shadow-sm">
    <h2 class="product-lists mb-0 text-primary fw-bold">Magic Product Manager</h2>
    <!-- A big green button to add brand new products to the shop! -->
    <a href="add_product.php" class="btn btn-success px-4">
        <i class="fas fa-plus-circle me-2"></i> Add New Product
    </a>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-hover table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>ID (Code Number)</th>
                <th style="width: 40%;">Product Name</th>
                <th>Price (Coins)</th>
                <th class="text-center">Fix It (Update)</th>
                <th class="text-center">Throw Away (Delete)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // We look at every single product in our big treasure book!
            $query = "select * from products";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                // If the book is torn, we stop!
                die("Query Failed" . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    // We draw a row for each product!
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td class="fw-semibold"><?php echo $row['name']; ?></td>
                        <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                        <td class="text-center">
                            <!-- A button to change the product's name or price! -->
                            <a href="update_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-edit"></i> Fix Product
                            </a>
                        </td>
                        <td class="text-center">
                            <!-- A button to take the product out of the shop! -->
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php
// If something happens, we show a little colored message!
if (isset($_GET['message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> ' . htmlspecialchars($_GET['message']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
} else if (isset($_GET['insert_msg'])) {
    echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-check-circle me-2"></i> ' . htmlspecialchars($_GET['insert_msg']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
} else if (isset($_GET['update_msg'])) {
    echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-check-circle me-2"></i> ' . htmlspecialchars($_GET['update_msg']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
} else if (isset($_GET['delete_msg'])) {
    echo '<div class="alert alert-info alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-info-circle me-2"></i> ' . htmlspecialchars($_GET['delete_msg']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}
?>


<?php include("footer.php"); ?>