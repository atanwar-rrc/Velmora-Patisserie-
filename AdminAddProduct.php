<?php
include_once('TopBar.php');
include_once('getConnection.php');
$error_msg = "";

$category = "SELECT * FROM category";
$stmt = $conn->prepare($category);
$stmt->execute();

if (isset($_POST['add_product'])) {
    $query = "";
    $name = senitize($_POST['name']);
    $cid = senitize($_POST['category']);
    $price = senitize($_POST['price']);
    $description = senitize($_POST['description']);
    $target_dir = "upload/";
    $add_image = 0;

    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $target_dir = $target_dir . rand() . $filename;
    $imageFileType = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));

    if (isset($_FILES['image']) && $imageFileType != "") {
        $add_image = 1;
    }
    if (($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "")) {
        if ($add_image == 1) {
            $query = "INSERT INTO product(name,cid,url,price,description) values(:name,:cid,:url,:price,:description)";
        } else {
            $query = "INSERT INTO product(name,cid,price,description) values(:name,:cid,:price,:description)";
        }
    } else {
        echo "<script>alert('File type is not supported');
                    window.location.href='AdminProduct.php';        
            </script>";
    }
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":cid", $cid);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":price", $price);
    if ($add_image == 1) {
        $stmt->bindParam(":url", $target_dir);
    }
    $stmt->bindParam(":description", $description);
    move_uploaded_file($tempname, $target_dir);
    $stmt->execute();
    redirect("AdminProduct.php");
}
?>

<div class="container-fluid set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Update</span> Product</h1>
        </div>
    </div>
    <div class="row  align-items-center d-flex">
        <div class="col-lg-6 text-center">
            <img src="assets/img/photos/upload.png" id="imageResult" class="img-fluid" height="250px" alt="">
        </div>
        <div class="col-lg-6 mb-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" name='name' placeholder="Product Name" required>
                </div>
                <div class="form-group">
                    <select name="category" class="form-control">
                        <option selected disabled value="">Select Category</option>
                        <?php while ($row = $stmt->fetch()) { ?>
                            <option value="<?php echo $row['cid'] ?>"><?php echo $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control w-100" name='price' placeholder="Price" required>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" name='image' id="upload" onchange="readURL(this);">
                </div>
                <div class="form-group">
                    <textarea name="description" placeholder="Description" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='add_product' value="Add Product" class="btn text-center btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('Footer.php');
?>