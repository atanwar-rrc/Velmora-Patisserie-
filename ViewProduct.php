<?php
include_once('getConnection.php');
include_once('TopBar.php');

if (isset($_GET['id']) && isset($_GET['name'])) {
    $id = check_id_number(senitize($_GET['id']));
    $name = senitize($_GET['name']);

    $sql = "SELECT p.name,p.price,p.url,p.description,c.name as 'cname' FROM product p INNER JOIN category c ON c.cid = p.cid AND p.id=:id AND p.name=:name";
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

                <div class="d-flex gap-3 mt-4">
                    <button class="btn btn-success px-4 rounded-3 shadow">Add to Cart 🛒</button>
                    <button class="btn btn-outline-primary px-4 rounded-3">Wishlist ❤️</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include_once("Footer.php") ?>