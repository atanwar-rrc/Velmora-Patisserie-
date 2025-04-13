<?php
include_once('TopBar.php');
include_once('getConnection.php');

if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['name'])) {

    $id = checkIdNumber(senitize($_GET['id']));
    $name = senitize($_GET['name']);
    $type = senitize($_GET['type']);
    $query = "SELECT * FROM category WHERE cid = :cid AND name = :name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":cid", $id);
    $stmt->bindParam(":name", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0 && $type == "update") {
        $row = $stmt->fetch();
    } else {
        redirect("404.php");
    }
}

if (isset($_POST["update_category"])) {

    $cname = senitize($_POST["cname"]);

    $query = "UPDATE category SET name=:name WHERE cid=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':name', $cname);
    $stmt->bindValue(':id', $id);

    if ($stmt->execute()) {
        redirect('AdminCategory.php');
    } else {
        $msg = 'Something went wrong';
    }
}
?>

<div class="container set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Update</span> Category</h1>
        </div>
    </div>
    <div class="row">
        <div class="col mb-5">
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='cname' placeholder="Category Name" value="<?php echo $row['name'] ?>" required>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='update_category' value="Update Category" class="btn text-center btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('Footer.php');
?>