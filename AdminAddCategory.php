<?php
include_once('TopBar.php');
include_once('getConnection.php');
admin_authentication();
$error_msg = "";
if (isset($_POST["addCategory"])) {
    
    $cname = senitize($_POST["categoryName"]);

    $query = "INSERT INTO category(name) values(:categoryName)";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':categoryName', $cname);

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
            <h1><span class="orange-text mt-5">Add</span> Category</h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col mb-5">
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='categoryName' placeholder="Category Name" required>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='addCategory' value="Add Category" class="btn text-center btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('Footer.php');
?>