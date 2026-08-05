<?php 
// We put on our grown-up hat (header)!
include("header.php"); ?>
<!-- This is a big card to write down all the details for a brand new product! -->
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-success text-white py-3">
        <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Add New Product</h4>
    </div>
    <div class="card-body p-4">
        <?php 
        if(isset($_GET['message'])){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> ' . htmlspecialchars($_GET['message']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        ?>
        <form action="insert_data.php" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <!-- Where we write the brand new product's name! -->
                <label for="productName" class="form-label fw-bold">Brand New Product Name</label>
                <input type="text" class="form-control form-control-lg" name="productName" id="productName"
                    placeholder="Enter Product Name" required>
                <div class="invalid-feedback">
                    Please provide a product name.
                </div>
            </div>
            <div class="mb-3">
                <!-- Where we write how many gold coins it costs! -->
                <label for="price" class="form-label fw-bold">Price (Gold Coins)</label>
                <input type="number" step="0.01" min="0.01" class="form-control form-control-lg" name="price" id="price"
                    placeholder="Enter Price" required>
                <div class="invalid-feedback">
                    Please provide a valid price (greater than 0).
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Image URL</label>
                <input type="text" class="form-control form-control-lg" name="image" id="image"
                    placeholder="Enter Image URL (e.g. https://... or images/product.jpg)" required>
                <div class="invalid-feedback">
                    Please provide an image URL or path.
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end mt-4">
                <!-- A button to say "Wait, I don't want to add this product!" -->
                <a href="index.php" class="btn btn-secondary px-4">Cancel</a>
                <!-- A big green button to say "Yes, put it on the shelf!" -->
                <button type="submit" name="add_students" class="btn btn-success px-5">Add My Product!</button>
            </div>
        </form>
    </div>
</div>

<script>
// Disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
<?php include("footer.php"); ?>