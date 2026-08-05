<?php 
// We put on our grown-up hat (header)!
include("header.php"); ?>
<?php 
// We open the secret pipe to the treasure box!
include("connection.php"); ?>

<!-- // Fetching student record based on ID from URL -->
<?php
// If we know which product needs fixing...
$row = ['id' => '', 'name' => '', 'price' => '', 'image' => ''];
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // We look in our treasure book for that specific product!
    $query = "SELECT * FROM `products` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}
?>

<!-- // Processing form submission for updating product details -->
<?php
// If we click the "UPDATE" button after fixing the product...
if (isset($_POST['update_products'])) {

    if (isset($_POST['id'])) {
        $idnew = $_POST['id'];
    }

    // We read the new name, price, and picture you wrote!
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // We tell the treasure box to "Change the old details to these new ones!"
    $updateQuery = "UPDATE `products` SET `name`='$productName', `price`='$price', `image`='$image' WHERE `id`='$idnew'";

    $updateResult = mysqli_query($conn, $updateQuery);
    if (!$updateResult) {
        // If the magic wand is broken, we show an error!
        die("Error updating record: " . mysqli_error($conn));
    } else {
        // We go back to the product list and say "All fixed!"
        header('location:index.php?update_msg=You have successfully updated the product record!!');
        exit();
    }
}
?>
<!-- // HTML form to display and update product details -->
<h2 class="text-center text-primary">Update Product Details</h2>

<form action="update_student.php<?php echo isset($_GET['id']) ? '?id='.$_GET['id'] : ''; ?>" method="POST">
    <div class="form-group">
        <!-- Where we type the product's new name! -->
        <label for="productName">New Product Name</label>
        <input type="text" class="form-control" name="productName" id="productName" placeholder="Enter Product Name"
            value="<?php echo $row['name']; ?>">
    </div>
    <div class="form-group">
        <!-- Where we type how many coins it costs now! -->
        <label for="price">New Price</label>
        <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price"
            value="<?php echo $row['price']; ?>">
    </div>
    <div class="form-group">
        <label for="image">Image URL</label>
        <input type="text" class="form-control" name="image" id="image" placeholder="Enter Image URL"
            value="<?php echo $row['image']; ?>">
    </div>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="submit" name="update_products" value="UPDATE" class="btn btn-primary">
</form>

<?php include("footer.php"); ?>
<!-- // it shows the footer part of the html page -->