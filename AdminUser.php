<?php
include_once('TopBar.php');
include_once("getConnection.php");
admin_authentication();

$no = 1;
$query = "SELECT * FROM user where user_type='user'";
$stmt = $conn->prepare($query);
$stmt->execute();



if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $email = senitize($_GET['id']);
    $query = "DELETE FROM user WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    redirect("AdminUser.php");
}
?>

<div class="container-fluid set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Users</span> Section</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="AdminAddUsers.php">
                <p class="text-primary h3 mb-4 float-right">Add User</p>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center" colspan="2">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <th scope="row"><?php echo $no ?></th>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td class="text-center">
                                    <a href="AdminUpdateUser.php?id=<?php echo $row['email'] ?>&type=update">
                                        <button type="button" class="btn btn-success">Update</button>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="?id=<?php echo $row['email'] ?>&type=delete">
                                        <button type="button" class="btn btn-danger" onclick="return confirmDelete();">Delete</button>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan=5><h6 class='text-center text-danger'><b>Data Not Available</b></h6></td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once('Footer.php') ?>