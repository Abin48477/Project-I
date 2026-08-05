<?php
// We put on our grown-up hat (header)!
include("header.php");
// We open the secret pipe to the treasure box!
include("../src/connection.php");

// We count all the friends in our clubhouse (users)!
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
// We count all the products on the shelves (products)!
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
// We count all the prizes given out (orders)!
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
// We count all the gold coins in our piggy bank (revenue)!
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'];
?>

<div class="row mt-4">
    <div class="col-md-3">
        <!-- A blue card for our clubhouse friends! -->
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5>Clubhouse Friends</h5>
                <h2><?php echo $user_count; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5>Total Products</h5>
                <h2><?php echo $product_count; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h5>Total Orders</h5>
                <h2><?php echo $order_count; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <!-- A yellow card for all our gold coins! -->
        <div class="card bg-warning shadow" style="color:#1b4332;">
            <div class="card-body">
                <h5>Total Gold Coins</h5>
                <h2>Rs. <?php echo number_format($total_revenue, 2); ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h3>Newest Prizes Given</h3>
    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Code #</th>
                <th>Friend's Name</th>
                <th>Coins Spent</th>
                <th>Status (How it's going)</th>
                <th>Day of Play</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // We find the 5 newest orders to show on the dashboard!
            $query = "SELECT orders.*, users.username FROM orders LEFT JOIN users ON orders.user_id = users.id ORDER BY created_at DESC LIMIT 5";
            $res = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td class="fw-semibold"><?php echo $row['username']; ?></td>
                    <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><span class='badge bg-warning' style='color:#1b4332;'><?php echo $row['status']; ?></span></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php
            }
            if (mysqli_num_rows($res) == 0) {
                echo "<tr><td colspan='5' class='text-center'>No recent orders.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("footer.php"); ?>