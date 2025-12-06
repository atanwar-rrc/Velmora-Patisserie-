<?php
include_once('TopBar.php');
include_once("getConnection.php");
admin_authentication();

$no = 1;
$sort_title = "ASC";
$sort_desc = "ASC";
$sort_price = "ASC";
$icon = "";

if (isset($_GET['sort'])) {
    $col = senitize($_GET['col']);
    if (isset($_GET['col']) && $_GET['col'] == 'name') {
        $sort_title = senitize($_GET['sort']);
        $query = "SELECT * FROM product order by $col $sort_title";
        if ($sort_title == "ASC") {
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351'/>
            <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
            $sort_title = "DESC";
        } else {
            $sort_title = "ASC";
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down-alt' viewBox='0 0 16 16'>
            <path d='M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z'/>
            <path fill-rule='evenodd' d='M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z'/>
            <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
        }
    } else if (isset($_GET['col']) && $_GET['col'] == 'created_at') {
        $sort_desc = senitize($_GET['sort']);
        $query = "SELECT * FROM product order by $col $sort_desc";
        if ($sort_desc == "ASC") {
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351'/>
            <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
            $sort_desc = "DESC";
        } else {
            $sort_desc = "ASC";
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down-alt' viewBox='0 0 16 16'>
            <path d='M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z'/>
            <path fill-rule='evenodd' d='M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z'/>
            <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
        }
    } else if (isset($_GET['col']) && $_GET['col'] == 'price') {
        $sort_price = senitize($_GET['sort']);
        $query = "SELECT * FROM product order by $col $sort_price";
        if ($sort_price == "ASC") {
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351'/>
            <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
            $sort_price = "DESC";
        } else {
            $sort_price = "ASC";
            $icon = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-alpha-down-alt' viewBox='0 0 16 16'>
            <path d='M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z'/>
            <path fill-rule='evenodd' d='M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z'/>
            <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z'/>
            </svg>";
        }
    }
} else {
    $query = "SELECT * FROM product";
}
$stmt = $conn->prepare($query);
$stmt->execute();

if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $id = senitize($_GET['id']);
    $old_image_url = senitize($_GET['url']);
    $query = "DELETE FROM product WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if (file_exists($old_image_url)) {
        unlink($old_image_url);
    }
    redirect('AdminProduct.php');
}


?>

<div class="container-fluid set-margin">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center my-3">
            <h1><span class="orange-text mt-5">Product</span> Section</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="AdminAddProduct.php">
                <p class="text-primary h3 mb-4 float-right">Add Product</p>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="5%">No</th>
                        <th scope="col" width="15%"><a href='?sort=<?php echo $sort_title ?>&col=name' class="remove_line_bt text-dark">Product Name <?php if (isset($_GET['col']) && $_GET['col'] == 'name') echo $icon; ?></a></th>
                        <th scope="col" width="20%">Image</th>
                        <th scope="col" width="10%"><a href='?sort=<?php echo $sort_price ?>&col=price' class="remove_line_bt text-dark">Price <?php if (isset($_GET['col']) && $_GET['col'] == 'price') echo $icon; ?></th>
                        <th scope="col" width="20%">Description</th>
                        <th scope="col" width="10%"><a href='?sort=<?php echo $sort_desc ?>&col=created_at' class="remove_line_bt text-dark">Created At <?php if (isset($_GET['col']) && $_GET['col'] == 'created_at') echo $icon; ?></th>
                        <th scope="col" width="20%" class="text-center" colspan="2">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <th scope="row"><?php echo $no++ ?></th>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <?php if ($row["url"] != "") { ?>
                                        <img src="<?php echo $row['url']; ?>" class="image-fluid" width="200px">
                                    <?php } else {
                                        echo "<h5 class='ms-5 text-danger'><b>No Image</b></h5>";
                                    } ?>
                                </td>
                                <td><?php echo $row['price'] ?> $</td>
                                <td><?php echo $row['description'] ?> </td>
                                <td><?php echo $row['created_at'] ?></td>
                                <td class="text-center">
                                    <a href="AdminUpdateProduct.php?id=<?php echo ($row['id'] . '&type=update&name=' . $row['name']) ?>">
                                        <button type="button" class="btn btn-success">Update</button>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="?id=<?php echo $row['id'] ?>&type=delete&name=<?php echo $row['name'] ?>&url=<?php echo $row['url'] ?>">
                                        <button type="button" class="btn btn-danger" onclick="return confirmDelete();">Delete</button>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan=7><h3 class='text-center text-danger'><b>Data Not Available</b></h3></td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once('Footer.php') ?>