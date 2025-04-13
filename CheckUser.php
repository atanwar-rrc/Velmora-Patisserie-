<?php 
    include_once("getConnection.php");
    if(isset($_GET["email"])){
        $email = senitize($_GET['email']);
        $query = "SELECT COUNT(email) FROM user WHERE email=:email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['COUNT(email)']==1){
            echo "This email is already used";
        }else{
            echo "";
        }
    }
?>