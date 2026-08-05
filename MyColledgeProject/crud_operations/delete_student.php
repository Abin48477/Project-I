<?php 
// We put on our grown-up hat (header)!
include("header.php"); ?>
<?php 
// We open the secret pipe to the treasure box!
include("connection.php"); ?>

<?php
// If we know which product we are talking about...
if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // We look in our treasure book for that specific product!
  $query = "SELECT * FROM `products` WHERE `id` = '$id'";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
    // We found the product!
    $row = mysqli_fetch_assoc($result);
  } else {
    // If the product is already gone, we go back!
    header('Location: index.php?delete_msg=' . urlencode('Product not found'));
    exit();
  }
}

// If we click the big red "Delete" button...
if (isset($_POST['delete_product'])) {
  $id_to_delete = mysqli_real_escape_string($conn, $_POST['id']);
  // We tell the treasure box to "Forget this product forever!"
  $deleteQuery = "DELETE FROM `products` WHERE `id` = '$id_to_delete'";
  if (mysqli_query($conn, $deleteQuery)) {
    // We go back and say "All gone!"
    header('Location: index.php?delete_msg=' . urlencode('Product record deleted successfully'));
    exit();
  } else {
    // If something gets stuck, we say "Oh no!"
    header('Location: index.php?delete_msg=' . urlencode('Failed to delete product'));
    exit();
  }
}
?>

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-danger text-white">
      <h3 class="mb-0">Delete Product Confirmation</h3>
    </div>
    <div class="card-body text-center">
      <!-- A big red warning so we don't make a mistake! -->
      <h4 class="text-danger">Careful Now!</h4>
      <p class="lead">Are you sure you want to take this product away?</p>
      <div class="alert alert-warning">
        <strong>The Product's Name:</strong> <?php echo htmlspecialchars($row['name']); ?><br>
        <strong>How many coins it cost:</strong> Rs. <?php echo htmlspecialchars($row['price']); ?>
      </div>

      <!-- A little box with buttons: One to go back, one to delete! -->
      <form action="delete_student.php" method="POST" class="mt-3">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <a href="index.php" class="btn btn-secondary me-2">Wait, Take it Back!</a>
        <button type="submit" name="delete_product" class="btn btn-danger">Yes, Delete Forever</button>
      </form>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<!-- // it shows the footer part of the html page -->