<?php
$conn;

try {
    $servername = "localhost";
    $dbname = "velmorapatisserie";
    $username = "root";
    $password = "";

    $conn = new PDO(
        "mysql:host=$servername; dbname=$dbname;",
        $username,
        $password
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    echo "Connection failed: "
        . $e->getMessage();
}
function hashpass($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function senitize($text)
{
    return htmlspecialchars($text);
}

function check_id_number($id) {
    if(is_numeric($id)) {
        return $id;
    }else{
        redirect('404.php');
    }
}

function redirect($page)
{ ?>
    <script>window.location.href = '<?php echo $page ?>';</script>
<?php
    die();
}

function admin_authentication()
{
    if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'admin') {
        redirect('index.php');
    }
}

function check_user()
{
    if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'user') {
        redirect('login.php');
    }
}

function checkIdNumber($id) {
    if(is_numeric($id)) {
        return $id;
    }else{
        redirect('404.php');
    }
}


?>