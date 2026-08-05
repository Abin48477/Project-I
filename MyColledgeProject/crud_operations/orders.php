<?php
// We put on our grown-up hat (header)!
include("header.php");
// We open the secret pipe to the treasure box!
include("../src/connection.php");
?>

<div class="mt-4">
    <h2>The Big Book of Every Product Sold</h2>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-success" style="color:#1b4332;">
            <tr>
                <th>Order Number (#)</th>
                <th>Friend (Customer)</th>
                <th>Total Coins</th>
                <th>Piggy Bank Info</th>
                <th>How it's going (Status)</th>
                <th>Time of Play</th>
                <th>Products Inside!</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // We read our big book of orders from newest to oldest!
            $query = "SELECT orders.*, users.username FROM orders LEFT JOIN users ON orders.user_id = users.id ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['id'];
                    // We check who bought the products!
                    $cust_name = $row['username'] ? $row['username'] : 'Deleted User';
                    ?>
                    <tr>
                        <td>#<?php echo $order_id; ?></td>
                        <td><span class="fw-bold"><?php echo $cust_name; ?></span></td>
                        <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                        <td>
                        <td>
                            <!-- We check if they paid with the eSewa piggy bank! -->
                            <div class="small">Magic Box: <strong><?php echo ucfirst($row['payment_method'] ?? 'N/A'); ?></strong>
                            </div>
                            <?php
                            $p_status = $row['payment_status'] ?? 'pending';
                            $badge_class = ($p_status == 'paid') ? 'bg-success' : (($p_status == 'failed') ? 'bg-danger' : 'bg-warning');
                            ?>
                            <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($p_status); ?></span>
                        </td>
                        <td><span class="badge bg-info" style="color:#1b4332;"><?php echo $row['status']; ?></span></td>
                        <td><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                <?php
                                // We open each order box to see exactly which products are inside!
                                $items_query = "SELECT order_items.*, products.name FROM order_items 
                                            JOIN products ON order_items.product_id = products.id 
                                            WHERE order_id = '$order_id'";
                                $items_res = mysqli_query($conn, $items_query);
                                while ($item = mysqli_fetch_assoc($items_res)) {
                                    // List each product name and how many!
                                    echo "<li>• <strong>{$item['name']}</strong> (x{$item['quantity']})</li>";
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4'>No orders found in the system.</td></tr>";
            }
            ?>
            ?>
        </tbody>
    </table>
</div><?php include("footer.php"); ?>