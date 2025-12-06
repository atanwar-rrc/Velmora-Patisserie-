<?php
include_once('getConnection.php');
include_once('TopBar.php');
admin_authentication();

$no = 1;
$query = "SELECT * FROM category";
$stmt = $conn->prepare($query);
$stmt->execute();

if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $id = checkIdNumber(senitize($_GET['id']));
    $query = "DELETE FROM category WHERE cid=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    redirect("AdminCategory.php");
}

?>
<div class="container-fluid set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Category</span> Section</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="AdminAddCategory.php">
                <p class="text-primary h3 mb-4 float-right">Add Category</p>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Category Name</th>
                        <th scope="col" class="text-center" colspan="2">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <th scope="row"><?php echo $no++ ?></th>
                                <td><?php echo $row['name'] ?></td>
                                <td class="text-center">
                                    <a href="AdminUpdateCategory.php?id=<?php echo $row['cid'] . '&type=update&name=' . $row['name'] ?>">
                                        <button type="button" class="btn btn-success">Update</button>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="?id=<?php echo $row['cid'] ?>&type=delete&name=<?php echo $row['name'] ?>">
                                        <button type="button" class="btn btn-danger" onclick="return confirmDelete();">Delete</button>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan=4><h4 class='text-center text-uppercase text-danger'><b>Data Not Available</b></h4></td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once("Footer.php") ?>