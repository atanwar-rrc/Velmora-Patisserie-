<?php
session_start();
include_once('getConnection.php');
if (isset($_SESSION['popup']) && $_SESSION['popup']) {
    echo '<script type ="text/JavaScript">alert(" Sucessfully logged in ' . $_SESSION['user_name'] . '")</script>';
    $_SESSION['popup'] = false;
}

$sql = "SELECT name FROM category";
$category =  $conn->prepare($sql);
$category->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Velmora Patisserie</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/mainFirst.css" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid position-relative d-flex align-items-center">

            <a href="index.php" class="logo d-flex align-items-start me-auto me-xl-0">
                <h1 class="sitename">Velmora Patisserie</h1>
                <span>.</span>
            </a>

            <nav id="navmenu" class="navmenu d-flex justify-content-center flex-grow-1">
                <ul>
                    <li><a href="index.php" class="active">Home<br></a></li>
                    <?php if ((isset($_SESSION['user_type']) && $_SESSION['user_type'] != "admin") || !isset($_SESSION['user_type'])) { ?>
                        <li><a href="Products.php">Products</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#contact">Contact</a></li>
                    <?php } else { ?>
                        <li><a href="AdminCategory.php">Categories</a></li>
                        <li><a href="AdminProduct.php">Products</a></li>
                        <li><a href="AdminUser.php">Users</a></li>
                    <?php } ?>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
        <!-- Search Icon -->
        <button class="button me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
            <svg class="svgIcon" viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm50.7-186.9L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path>
            </svg>
            Search
        </button>
        <div class="float-end me-3">
            <label class="popup">
                <input type="checkbox" />
                <div tabindex="0" class="burger">
                    <svg
                        viewBox="0 0 24 24"
                        fill="white"
                        height="20"
                        width="20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 2c2.757 0 5 2.243 5 5.001 0 2.756-2.243 5-5 5s-5-2.244-5-5c0-2.758 2.243-5.001 5-5.001zm0-2c-3.866 0-7 3.134-7 7.001 0 3.865 3.134 7 7 7s7-3.135 7-7c0-3.867-3.134-7.001-7-7.001zm6.369 13.353c-.497.498-1.057.931-1.658 1.302 2.872 1.874 4.378 5.083 4.972 7.346h-19.387c.572-2.29 2.058-5.503 4.973-7.358-.603-.374-1.162-.811-1.658-1.312-4.258 3.072-5.611 8.506-5.611 10.669h24c0-2.142-1.44-7.557-5.631-10.647z"></path>
                    </svg>
                </div>
                <nav class="popup-window">
                    <?php if (isset($_SESSION['user_name'])) { ?>
                        <legend><?php echo 'Dear, ' . $_SESSION['user_name']; ?></legend>
                    <?php } ?>
                    <ul>
                        <?php if (!isset($_SESSION['user_name'])) { ?>
                            <li>
                                <button>
                                    <a href="SignIn.php">
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.2"
                                            stroke-linecap="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19 4v6.406l-3.753 3.741-6.463-6.462 3.7-3.685h6.516zm2-2h-12.388l1.497 1.5-4.171 4.167 9.291 9.291 4.161-4.193 1.61 1.623v-12.388zm-5 4c.552 0 1 .449 1 1s-.448 1-1 1-1-.449-1-1 .448-1 1-1zm0-1c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6.708.292l-.708.708v3.097l2-2.065-1.292-1.74zm-12.675 9.294l-1.414 1.414h-2.619v2h-2v2h-2v-2.17l5.636-5.626-1.417-1.407-6.219 6.203v5h6v-2h2v-2h2l1.729-1.729-1.696-1.685z"></path>
                                        </svg>
                                        <span class="text-dark">Sign In</span>
                                    </a>
                                </button>
                            </li>
                            <li>
                                <button>
                                    <a href="Logout.php">
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1"
                                            stroke-linecap="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.598 9h-1.055c1.482-4.638 5.83-8 10.957-8 6.347 0 11.5 5.153 11.5 11.5s-5.153 11.5-11.5 11.5c-5.127 0-9.475-3.362-10.957-8h1.055c1.443 4.076 5.334 7 9.902 7 5.795 0 10.5-4.705 10.5-10.5s-4.705-10.5-10.5-10.5c-4.568 0-8.459 2.923-9.902 7zm12.228 3l-4.604-3.747.666-.753 6.112 5-6.101 5-.679-.737 4.608-3.763h-14.828v-1h14.826z"></path>
                                        </svg>
                                        <span class="text-dark">Sign Up</span>
                                        <a>
                                </button>
                            </li>
                        <?php } else { ?>
                            <li>
                                <button>
                                    <a href="./Logout.php">
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1"
                                            stroke-linecap="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.598 9h-1.055c1.482-4.638 5.83-8 10.957-8 6.347 0 11.5 5.153 11.5 11.5s-5.153 11.5-11.5 11.5c-5.127 0-9.475-3.362-10.957-8h1.055c1.443 4.076 5.334 7 9.902 7 5.795 0 10.5-4.705 10.5-10.5s-4.705-10.5-10.5-10.5c-4.568 0-8.459 2.923-9.902 7zm12.228 3l-4.604-3.747.666-.753 6.112 5-6.101 5-.679-.737 4.608-3.763h-14.828v-1h14.826z"></path>
                                        </svg>
                                        <span class="text-dark">Logout</span>
                                        <a>
                                </button>
                            </li>
                        <?php } ?>

                    </ul>
                </nav>
            </label>

        </div>
    </header>
    <main class="main">
        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header bg-gradient text-center text-white">
                        <h5 class="modal-title font-monospace" id="searchModalLabel">Search Cakes</h5>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="Products.php" method="GET">
                        <div class="modal-body">
                            <!-- Search Input -->
                            <div class="mb-3">
                                <label for="searchKeyword" class="form-label fw-bold">Cake Name / Keyword</label>
                                <input type="text" class="form-control shadow-sm" id="searchKeyword" name="cake" placeholder="Enter cake name or keyword">
                            </div>

                            <!-- Category Dropdown -->
                            <div class="mb-3">
                                <label for="categorySelect" class="form-label fw-bold">Select Category</label>
                                <select class="form-select shadow-sm" id="categorySelect" name="category">
                                    <option value="all">All Categories</option>
                                    <?php foreach ($category as $cat) { ?>
                                        <option value="<?php echo $cat['name']; ?>"><?php echo ucfirst($cat['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning w-100 fw-semibold">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>