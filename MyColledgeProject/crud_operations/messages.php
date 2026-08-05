<?php 
// We put on our grown-up hat (header)!
include("header.php"); ?>

<!-- This is the box where we keep all the secret whispers from our friends! -->
<div class="box1 d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded shadow-sm">
    <h2 class="product-lists mb-0 text-primary fw-bold">Clubhouse Whispers</h2>
    <span class="badge bg-primary px-3 py-2">Listening Box</span>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-hover table-bordered mb-0">
        <thead class="table-success" style="color:#1b4332;">
            <tr>
                <th>Whisper ID</th>
                <th>Who sent it? (Friend Details)</th>
                <th>What did they say? (Message)</th>
                <th>Time it got here</th>
                <th>Throw it away?</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // We read every whisper in our secret book!
            $query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // We draw a row for each secret message!
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td>
                            <div class="fw-bold" style="color:#1b4332;"><?php echo $row['name']; ?></div>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i><?php echo $row['email']; ?></small>
                        </td>
                        <td>
                            <div class="p-2 bg-light rounded small" style="max-width: 400px; white-space: pre-wrap;">
                                <?php echo $row['message']; ?>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></small><br>
                            <small class="fw-bold"><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                        </td>
                        <td class="text-center">
                            <!-- A red button to throw a whisper into the trash! -->
                            <a href="delete_message.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Are you sure you want to throw away this whisper?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5' class='text-center py-5 text-muted'>
                        <i class='fas fa-inbox fa-3x mb-3 d-block'></i>
                        No inquiries received yet.
                      </td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("footer.php"); ?>