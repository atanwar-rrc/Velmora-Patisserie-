<?php
include_once('TopBar.php');
include_once('getConnection.php');
admin_authentication();

$error_msg = "";
if (isset($_POST["addUser"])) {
    $name = senitize($_POST["name"]);
    $email = senitize($_POST["email"]);
    $password = hashpass(senitize($_POST["password"]));

    $query = "INSERT INTO user(name,email,password,user_type) values(:name,:email,:password,:type)";
    $stmt = $conn->prepare($query);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':type', 'user');
    if ($stmt->execute()) {
        redirect('AdminUser.php');
    } else {
        $msg = 'Something went wrong';
    }
}
?>

<div class="container set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Add</span> User</h1>
        </div>
    </div>
    <div class="row">
        <div class="col mb-5">
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" name='name' placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" name='email' placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password' required>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name='addUser' value="Add User" class="btn text-center btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('Footer.php');
?>