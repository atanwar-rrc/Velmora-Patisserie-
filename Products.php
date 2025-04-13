<?php
include_once('getConnection.php');
include_once('TopBar.php');
?>

<?php
if (isset($_GET['cake'])) {
    if (isset($_GET['category'])) {
        $category = senitize($_GET['category']);
        $search = senitize($_GET['cake'] . '%');
        if ($category == 'all') {
            $sql = "SELECT p.id,p.name,p.price,p.url FROM product p INNER JOIN category c ON c.cid = p.cid AND p.name LIKE CONCAT('%', :name, '%')";
        } else {
            $sql = "SELECT p.id,p.name,p.price,p.url FROM product p INNER JOIN category c ON c.cid = p.cid WHERE c.name = :cid AND p.name LIKE CONCAT('%', :name, '%')";
        }

        $stmt = $conn->prepare($sql);

        if ($category != 'all') {
            $stmt->bindParam(':cid', $category);
            // echo 'all';
        }

        $stmt->bindParam(':name', $search);
        // echo 'search with cat '.$search.' '.$category;
    } else {
        $search = senitize($_GET['cake'] . '%');
        $sql = "SELECT p.id,p.name,p.price,p.url,p.description,c.name as 'cname' FROM product p INNER JOIN category c ON c.cid = p.cid AND p.cid=c.cid AND p.name LIKE CONCAT('%', :name, '%')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $search);
        // echo 'only search';
    }
} else {
    $sql = "SELECT p.id,p.name,p.price,p.url,p.description,c.name as 'cname' FROM product p INNER JOIN category c ON c.cid = p.cid AND p.cid=c.cid";
    $stmt = $conn->prepare($sql);
}
$stmt->execute();

$sql = "SELECT name FROM category";
$category =  $conn->prepare($sql);
$category->execute();

?>

<section id="menu" class="menu section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Menu</h2>
        <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p>
    </div>
</section>

<div class="container">
    <div class="row gy-5" data-aos="fade-up">
        <?php if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
        ?>
                <div class="col-lg-4 menu-item">
                    <div class="container m-4">
                        <div class="product-card">
                            <div class="align-content-center justify-content-center">
                                <?php if ($row['url'] != "") { ?>
                                    <img src="<?php echo $row['url'] ?>" height="200px" alt="">
                                <?php } else { ?>
                                    <h3 class="text-danger">No Image Available😟</h3>
                                <?php } ?>
                            </div>
                            <h4 class="cake-font"><?php echo $row['name']; ?></h4>
                            <div>
                                <span>$<?php echo $row['price'] ?></span>
                                <a href="ViewProduct.php?id=<?php echo $row['id'] ?>&name=<?php echo $row['name'] ?>"><button class="view-botton">
                                    <p>Taste Cake!</p>
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <!-- Cake Not Found Message -->
            <div id="cakeNotFound" class="alert alert-warning text-center p-4 rounded-4 shadow-lg" role="alert">
                <h4 class="mt-4 fw-bold">🍰 Oh no! Cake Not Found! 🍰</h4>
                <p class="text-muted">We couldn't find any cakes matching your taste. Let's try something else!</p>
                <button class="btn btn-danger px-4 mt-2" onclick="window.location.href='Products.php'">
                    🔁 Go Back to Cakes
                </button>
            </div>

        <?php } ?>
    </div>

</div>
<?php include_once('Comments.php') ?>
<?php include_once('Footer.php') ?>