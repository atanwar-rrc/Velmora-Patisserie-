<?php
include_once('getConnection.php');

// Check if user is logged in
if (!isset($_SESSION['user_mail'])) {
    redirect('SignIn.php');
}

$user_email = $_SESSION['user_mail'];

// Handle remove from cart
if (isset($_GET['remove'])) {
    $cart_id = check_id_number(senitize($_GET['remove']));
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id AND user_email = :email");
    $stmt->bindParam(':id', $cart_id);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    redirect('Cart.php');
}

// Handle update quantity
if (isset($_POST['update_quantity'])) {
    $cart_id = check_id_number(senitize($_POST['cart_id']));
    $quantity = max(1, intval($_POST['quantity'])); // Minimum 1
    $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND user_email = :email");
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':id', $cart_id);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    redirect('Cart.php');
}

include_once('TopBar.php');

// Get cart items
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_email = :email ORDER BY added_at DESC");
$stmt->bindParam(':email', $user_email);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['product_price'] * $item['quantity'];
}
?>

<section class="cart-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="bi bi-cart3"></i> Shopping Cart</h2>
                
                <?php if (empty($cart_items)): ?>
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Your cart is empty</h4>
                        <p class="text-muted">Add some delicious cakes to get started!</p>
                        <a href="Products.php" class="btn btn-primary mt-3">Browse Products</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['product_url'])): ?>
                                                    <img src="<?php echo $item['product_url']; ?>" 
                                                         alt="<?php echo $item['product_name']; ?>" 
                                                         class="rounded me-3" 
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0"><?php echo $item['product_name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                                        <td>
                                            <form method="POST" class="d-inline" id="qty-form-<?php echo $item['id']; ?>">
                                                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                                <input type="hidden" name="update_quantity" value="1">
                                                <div class="input-group" style="width: 120px;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="decrementQty(<?php echo $item['id']; ?>)">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                           name="quantity" 
                                                           id="qty-<?php echo $item['id']; ?>"
                                                           value="<?php echo $item['quantity']; ?>" 
                                                           min="1" 
                                                           class="form-control form-control-sm text-center"
                                                           style="max-width: 60px;"
                                                           readonly>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="incrementQty(<?php echo $item['id']; ?>)">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="fw-bold">$<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></td>
                                        <td>
                                            <a href="Cart.php?remove=<?php echo $item['id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Remove this item from cart?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold text-success fs-5">$<?php echo number_format($total, 2); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                        <a href="Checkout.php" class="btn btn-success btn-lg">
                            Proceed to Checkout <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
function incrementQty(cartId) {
    const input = document.getElementById('qty-' + cartId);
    input.value = parseInt(input.value) + 1;
    document.getElementById('qty-form-' + cartId).submit();
}

function decrementQty(cartId) {
    const input = document.getElementById('qty-' + cartId);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        document.getElementById('qty-form-' + cartId).submit();
    }
}
</script>

<?php include_once('Footer.php'); ?>
