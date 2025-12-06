<?php
include_once('TopBar.php');
include_once('getConnection.php');
$error_msg = "";

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = senitize($_GET['id']);
    $type = senitize($_GET['type']);
    $query = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":email", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0 && $type == "update") {
        $row = $stmt->fetch();
    } else {
        redirect('404.php');
    }
}
if (isset($_POST['update_user'])) {
    $name = senitize($_POST['name']);
    $password = senitize($_POST['password']);
    $email = senitize($_POST['email']);

    if ($password == "") {
        $query = "UPDATE user SET name=:name,email=:email WHERE email=:id";
    } else {
        $query = "UPDATE user SET name=:name,email=:email,password=:password WHERE email=:id";
    }
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":name", $name);
    if ($password != "") {
        $password = hashpass($password);
        $stmt->bindParam(":password", $password);
    }
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    redirect("AdminUser.php");
}
?>

<div class="container set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Update</span> User</h1>
        </div>
    </div>
    <div class="row">
        <div class="col mb-5">
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='name' placeholder="First Name" value="<?php echo $row['name'] ?>" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='email' placeholder="Email" value="<?php echo $row['email'] ?>" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password'>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='update_user' value="Update User" class="btn text-center btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('Footer.php') ?>