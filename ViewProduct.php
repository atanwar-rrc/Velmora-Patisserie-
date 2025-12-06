<?php
include_once('getConnection.php');

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_mail'])) {
        redirect('SignIn.php');
    }
    
    $product_id = check_id_number(senitize($_POST['product_id']));
    $product_name = senitize($_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_url = senitize($_POST['product_url']);
    $user_email = $_SESSION['user_mail'];
    
    // Check if already in cart
    $check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_email = :email AND product_id = :pid");
    $check->bindParam(':email', $user_email);
    $check->bindParam(':pid', $product_id);
    $check->execute();
    $existing = $check->fetch();
    
    if ($existing) {
        // Update quantity
        $new_qty = $existing['quantity'] + 1;
        $update = $conn->prepare("UPDATE cart SET quantity = :qty WHERE id = :id");
        $update->bindParam(':qty', $new_qty);
        $update->bindParam(':id', $existing['id']);
        $update->execute();
    } else {
        // Insert new
        $insert = $conn->prepare("INSERT INTO cart (user_email, product_id, product_name, product_price, product_url) VALUES (:email, :pid, :pname, :price, :url)");
        $insert->bindParam(':email', $user_email);
        $insert->bindParam(':pid', $product_id);
        $insert->bindParam(':pname', $product_name);
        $insert->bindParam(':price', $product_price);
        $insert->bindParam(':url', $product_url);
        $insert->execute();
    }
    
    // Set session message and redirect
    $_SESSION['product_message'] = "Added to cart!";
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Handle Add to Wishlist
if (isset($_POST['add_to_wishlist'])) {
    if (!isset($_SESSION['user_mail'])) {
        redirect('SignIn.php');
    }
    
    $product_id = check_id_number(senitize($_POST['product_id']));
    $product_name = senitize($_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_url = senitize($_POST['product_url']);
    $user_email = $_SESSION['user_mail'];
    
    // Check if already in wishlist
    $check = $conn->prepare("SELECT id, quantity FROM wishlist WHERE user_email = :email AND product_id = :pid");
    $check->bindParam(':email', $user_email);
    $check->bindParam(':pid', $product_id);
    $check->execute();
    $existing = $check->fetch();
    
    if ($existing) {
        // Update quantity
        $new_qty = $existing['quantity'] + 1;
        $update = $conn->prepare("UPDATE wishlist SET quantity = :qty WHERE id = :id");
        $update->bindParam(':qty', $new_qty);
        $update->bindParam(':id', $existing['id']);
        $update->execute();
    } else {
        // Insert new
        $insert = $conn->prepare("INSERT INTO wishlist (user_email, product_id, product_name, product_price, product_url, quantity) VALUES (:email, :pid, :pname, :price, :url, 1)");
        $insert->bindParam(':email', $user_email);
        $insert->bindParam(':pid', $product_id);
        $insert->bindParam(':pname', $product_name);
        $insert->bindParam(':price', $product_price);
        $insert->bindParam(':url', $product_url);
        $insert->execute();
    }
    
    // Set session message and redirect
    $_SESSION['product_message'] = "Added to wishlist!";
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

include_once('TopBar.php');

// Get message from session and clear it
$message = "";
if (isset($_SESSION['product_message'])) {
    $message = $_SESSION['product_message'];
    unset($_SESSION['product_message']);
}

if (isset($_GET['id']) && isset($_GET['name'])) {
    $id = check_id_number(senitize($_GET['id']));
    $name = senitize($_GET['name']);

    $sql = "SELECT p.id,p.name,p.price,p.url,p.description,c.name as 'cname' FROM product p INNER JOIN category c ON c.cid = p.cid AND p.id=:id AND p.name=:name";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $name);
    // echo $id." ".$name;
    $stmt->execute();
    $row = $stmt->fetch();
    // print_r($row);
} else {
    redirect('404.php');
}
?>

<div class="container view-product my-5">
    <div class="card shadow-lg w-100 rounded-4 p-4 bg-light border-0">

        <!-- Success Message -->
        <?php if (!empty($message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Path/Breadcrumb -->
        <div class="mb-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 fw-medium">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-secondary">Home</a></li>
                    <li class="breadcrumb-item"><a href="products.php" class="text-decoration-none text-secondary">Products</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page"><?php echo $row['name'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row g-4 align-items-center">
            <!-- Product Image -->
            <div class="col-md-6 text-center">
                <?php if ($row['url'] != "") { ?>
                    <img class="img-fluid rounded-4 shadow-sm animate__animated animate__fadeInLeft" src="<?php echo $row['url'] ?>" alt="Product Image" />
                <?php } else { ?>
                    <h3 class="text-danger">No Image Available😟</h3>
                <?php } ?>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h2 class="fw-bold font-monospace mb-3"><?php echo $row['name'] ?></h2>
                <span class="badge text-bg-warning mb-3">Bestseller</span>

                <p class="text-muted"><?php echo $row['description'] ?></p>

                <ul class="list-unstyled">
                    <li><strong>Price:</strong> $<?php echo $row['price'] ?></li>
                    <li><strong>Weight:</strong> 500g</li>
                    <li><strong>Flavour:</strong> <?php echo explode(' ', $row['cname'])[0]; ?></li>
                </ul>

                <form method="POST" class="d-flex gap-3 mt-4">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="product_url" value="<?php echo $row['url']; ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-success px-4 rounded-3 shadow">Add to Cart 🛒</button>
                    <button type="submit" name="add_to_wishlist" class="btn btn-outline-primary px-4 rounded-3">Wishlist ❤️</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php include_once("Footer.php") ?>