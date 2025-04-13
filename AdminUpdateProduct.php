<?php
include_once('TopBar.php');
include_once('getConnection.php');
$error_msg = "";

if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['name'])) {
    $id = checkIdNumber(senitize($_GET['id']));
    $name = (senitize($_GET['name']));
    $type = senitize($_GET['type']);

    $query = "SELECT * from product WHERE id=:id AND name=:name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":name", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0 && $type == "update") {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        redirect('404.php');
    }
    $old_image_url = $row['url'];

    $query = "SELECT * FROM category";
    $stmt1 = $conn->prepare($query);
    $stmt1->execute();
}

if (isset($_POST['update_product'])) {

    $id = senitize($_GET['id']);
    $name = senitize($_POST['name']);
    $description = senitize($_POST['description']);
    $cid = senitize($_POST['category']);
    $price = senitize($_POST['price']);
    $target_dir = "upload/";
    $remove_image = 0;

    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $target_dir = $target_dir . rand() . $filename;
    $imageFileType = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));

    if (isset($_POST['remove-img'])) {
        $remove_image = 1;
    }

    if (($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "")) {
        if ($remove_image == 0 && $imageFileType != "") {
            $query = "UPDATE product SET cid=:cid,name=:name,url=:url,price=:price,description=:description WHERE id=:id";
        } else if ($remove_image == 1 && $imageFileType == "") {
            $query = "UPDATE product SET cid=:cid,name=:name,url='',price=:price,description=:description WHERE id=:id";
        } else {
            $query = "UPDATE product SET cid=:cid,name=:name,price=:price,description=:description WHERE id=:id";
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
    if ($remove_image == 0 && $imageFileType != "") {
        $stmt->bindParam(":url", $target_dir);
    }
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if ($remove_image == 0 && $imageFileType != "") {
        move_uploaded_file($tempname, $target_dir);
    }
    if ($remove_image == 1 && file_exists($old_image_url)) {
        unlink($old_image_url);
    }
    // echo $query;
    redirect("adminProduct.php");
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
            <?php if ($row['url'] != "") { ?>
                <img src="<?php echo $row['url']; ?>" id="imageResult" class="img-fluid" height="350px" alt="">
            <?php } else { ?>
                <img src="assets/img/upload.png" id="imageResult" class="img-fluid" height="350px" alt="">
            <?php } ?>
        </div>
        <div class="col-lg-6 mb-5">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" name='name' placeholder="Product Name" value="<?php echo $row['name'] ?>" required>
                </div>
                <div class="form-group">
                    <select name="category" class="form-control">
                        <option selected disabled value="">Select Category</option>
                        <?php while ($data = $stmt1->fetch()) { ?>
                            <option value="<?php echo $data['cid'] ?>" <?php if ($data["cid"] == $row["cid"]) echo "selected" ?>><?php echo $data['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control w-100" name='price' placeholder="Price" value="<?php echo $row['price'] ?>" required>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" name='image' id="upload" onchange="readURL(this);">
                    <?php if ($row['url'] != "") { ?>
                        <input class="form-check-input mt-2 ml-1" type="checkbox" id="inlineCheckbox1" name="remove-img" value="1" <?php if ($row['url'] == "") echo "checked"; ?>>
                        <label class="form-check-label ml-4" for="inlineCheckbox1">Delete Image</label>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <textarea name="description" placeholder="Description" class="form-control" cols="30" rows="5"><?php echo $row['description'] ?></textarea>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='update_product' value="Update Product" class="btn text-center btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once("Footer.php") ?>