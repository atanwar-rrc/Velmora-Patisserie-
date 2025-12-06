<?php
include_once('getConnection.php');

// Check if user is logged in
if (!isset($_SESSION['user_mail'])) {
    redirect('SignIn.php');
}

$user_email = $_SESSION['user_mail'];
$message = "";

// Handle remove from wishlist
if (isset($_GET['remove'])) {
    $wishlist_id = check_id_number(senitize($_GET['remove']));
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = :id AND user_email = :email");
    $stmt->bindParam(':id', $wishlist_id);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    redirect('Wishlist.php');
}

// Handle move to cart
if (isset($_POST['move_to_cart'])) {
    $wishlist_id = check_id_number(senitize($_POST['wishlist_id']));
    $product_id = check_id_number(senitize($_POST['product_id']));
    $product_name = senitize($_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_url = senitize($_POST['product_url']);
    $wishlist_qty = intval($_POST['wishlist_qty']);
    
    // Check if already in cart
    $check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_email = :email AND product_id = :pid");
    $check->bindParam(':email', $user_email);
    $check->bindParam(':pid', $product_id);
    $check->execute();
    $existing = $check->fetch();
    
    if ($existing) {
        // Update quantity - add wishlist quantity to existing cart quantity
        $new_qty = $existing['quantity'] + $wishlist_qty;
        $update = $conn->prepare("UPDATE cart SET quantity = :qty WHERE id = :id");
        $update->bindParam(':qty', $new_qty);
        $update->bindParam(':id', $existing['id']);
        $update->execute();
    } else {
        // Insert new to cart with wishlist quantity
        $insert = $conn->prepare("INSERT INTO cart (user_email, product_id, product_name, product_price, product_url, quantity) VALUES (:email, :pid, :pname, :price, :url, :qty)");
        $insert->bindParam(':email', $user_email);
        $insert->bindParam(':pid', $product_id);
        $insert->bindParam(':pname', $product_name);
        $insert->bindParam(':price', $product_price);
        $insert->bindParam(':url', $product_url);
        $insert->bindParam(':qty', $wishlist_qty);
        $insert->execute();
    }
    
    // Remove from wishlist
    $delete = $conn->prepare("DELETE FROM wishlist WHERE id = :id");
    $delete->bindParam(':id', $wishlist_id);
    $delete->execute();
    
    $message = "Added to cart successfully!";
}

include_once('TopBar.php');

// Handle update quantity
if (isset($_POST['update_quantity'])) {
    $wishlist_id = check_id_number(senitize($_POST['wishlist_id']));
    $quantity = max(1, intval($_POST['quantity'])); // Minimum 1
    $stmt = $conn->prepare("UPDATE wishlist SET quantity = :quantity WHERE id = :id AND user_email = :email");
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':id', $wishlist_id);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    redirect('Wishlist.php');
}

// Get wishlist items
$stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_email = :email ORDER BY added_at DESC");
$stmt->bindParam(':email', $user_email);
$stmt->execute();
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="wishlist-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="bi bi-heart-fill text-danger"></i> My Wishlist</h2>
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if (empty($wishlist_items)): ?>
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-heart" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Your wishlist is empty</h4>
                        <p class="text-muted">Start adding your favorite cakes!</p>
                        <a href="index.php" class="btn btn-primary mt-3">Browse Products</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wishlist_items as $item): ?>
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
                                        <td class="fw-bold">$<?php echo number_format($item['product_price'], 2); ?></td>
                                        <td>
                                            <form method="POST" class="d-inline" id="qty-form-w-<?php echo $item['id']; ?>">
                                                <input type="hidden" name="wishlist_id" value="<?php echo $item['id']; ?>">
                                                <input type="hidden" name="update_quantity" value="1">
                                                <div class="input-group" style="width: 120px;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="decrementQtyW(<?php echo $item['id']; ?>)">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                           name="quantity" 
                                                           id="qty-w-<?php echo $item['id']; ?>"
                                                           value="<?php echo isset($item['quantity']) ? $item['quantity'] : 1; ?>" 
                                                           min="1" 
                                                           class="form-control form-control-sm text-center"
                                                           style="max-width: 60px;"
                                                           readonly>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="incrementQtyW(<?php echo $item['id']; ?>)">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" class="d-inline me-2">
                                                <input type="hidden" name="wishlist_id" value="<?php echo $item['id']; ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $item['product_name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $item['product_price']; ?>">
                                                <input type="hidden" name="product_url" value="<?php echo $item['product_url']; ?>">
                                                <input type="hidden" name="wishlist_qty" value="<?php echo isset($item['quantity']) ? $item['quantity'] : 1; ?>">
                                                <button type="submit" name="move_to_cart" class="btn btn-sm btn-success">
                                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                                </button>
                                            </form>
                                            <a href="Wishlist.php?remove=<?php echo $item['id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Remove from wishlist?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 mb-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
function incrementQtyW(wishlistId) {
    const input = document.getElementById('qty-w-' + wishlistId);
    input.value = parseInt(input.value) + 1;
    document.getElementById('qty-form-w-' + wishlistId).submit();
}

function decrementQtyW(wishlistId) {
    const input = document.getElementById('qty-w-' + wishlistId);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        document.getElementById('qty-form-w-' + wishlistId).submit();
    }
}
</script>

<?php include_once('Footer.php'); ?>
