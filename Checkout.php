<?php
include_once('getConnection.php');

// Check if user is logged in
if (!isset($_SESSION['user_mail'])) {
    redirect('SignIn.php');
}

$user_email = $_SESSION['user_mail'];

// Get cart items
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_email = :email ORDER BY added_at DESC");
$stmt->bindParam(':email', $user_email);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if cart is empty
if (empty($cart_items)) {
    redirect('Cart.php');
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['product_price'] * $item['quantity'];
}

// Handle order submission
if (isset($_POST['place_order'])) {
    // Clear cart after order
    $clear = $conn->prepare("DELETE FROM cart WHERE user_email = :email");
    $clear->bindParam(':email', $user_email);
    $clear->execute();
    
    $success_message = "Order placed successfully! Total: $" . number_format($total, 2);
}

include_once('TopBar.php');
?>

<section class="checkout-section py-5">
    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center py-5">
                <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Thank You!</h3>
                <p class="fs-5"><?php echo $success_message; ?></p>
                <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <h2 class="mb-4"><i class="bi bi-credit-card"></i> Checkout</h2>
            
            <form method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Billing Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your address.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your city.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                        <input type="text" name="postal_code" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your postal code.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="phone" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your phone number.</div>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <h5 class="card-title mb-3">Payment Method</h5>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment" id="cod" checked>
                                    <label class="form-check-label" for="cod">
                                        Cash on Delivery
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment" id="card">
                                    <label class="form-check-label" for="card">
                                        Credit/Debit Card
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-5">
                        <h5 class="mb-3">Order Summary</h5>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $item['product_url']; ?>" 
                                                 alt="<?php echo $item['product_name']; ?>" 
                                                 class="rounded me-2" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <small class="d-block"><?php echo $item['product_name']; ?></small>
                                                <small class="text-muted">Qty: <?php echo $item['quantity']; ?></small>
                                            </div>
                                        </div>
                                        <span class="fw-bold">$<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></span>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <strong>Total:</strong>
                                    <strong class="text-success fs-4">$<?php echo number_format($total, 2); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="Cart.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Cart
                    </a>
                    <button type="submit" name="place_order" class="btn btn-success btn-lg">
                        Place Order - $<?php echo number_format($total, 2); ?>
                    </button>
                </div>
            </form>
            
            <script>
            // Bootstrap form validation
            (function() {
                'use strict';
                var forms = document.querySelectorAll('form');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
            </script>
        <?php endif; ?>
    </div>
</section>

<?php include_once('Footer.php'); ?>
