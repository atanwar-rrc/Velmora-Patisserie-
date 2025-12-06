<?php
include_once('getConnection.php');
if (isset($_SESSION['user_name'])) {
    $mail = $_SESSION['user_name'];
}
if (isset($_POST['post_comment'])) {
    if (!isset($_SESSION['user_name'])) {
        $mail = senitize($_POST['name']);
    }
    $comment = senitize($_POST['comment']);
    $stmt = $conn->prepare("INSERT INTO comment(name,visible, comment) VALUES(:mail,1, :comment)");
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
    redirect("");
}
$stmt = $conn->prepare("SELECT * FROM comment WHERE visible=1 ORDER BY time DESC LIMIT 0,8");
$stmt->execute();
?>

<form action="" method="post" class="card w-75">
    <span class="title">Comments</span>
    <div class="comments w-100">
        <div class="comment-react">
        </div>
        <div class="comment-container">
            <?php if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) { ?>
                    <div class="user">
                        <div class="user-pic">
                            <svg fill="none" viewBox="0 0 24 24" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linejoin="round" fill="#707277" stroke-linecap="round" stroke-width="2" stroke="#707277" d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z"></path>
                                <path stroke-width="2" fill="#707277" stroke="#707277" d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z"></path>
                            </svg>
                        </div>
                        <div class="user-info">
                            <span><?php echo $row['name'] ?></span>
                            <p><?php echo $row['time'] ?></p>
                        </div>
                    </div>
                    <p class="comment-content">
                        <?php echo $row['comment'] ?>
                    </p>
            <?php }
            } ?>
        </div>
    </div>

    <div class="text-box">
        <?php if (!isset($_SESSION['user_name'])) { ?>
            <div class="box-container mb-3">
                <input type="text" name="name" class="border-0 w-100 comment-name" placeholder="Name">
            </div>
        <?php } ?>
        <div class="box-container">
            <textarea placeholder="Reply" name="comment"></textarea>
            <div>
                <div class="formatting float-end mt-3">
                    <button type="submit" name="post_comment" value="Post" class="send" title="Send">
                        <svg fill="none" viewBox="0 0 24 24" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#ffffff" d="M12 5L12 20"></path>
                            <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#ffffff" d="M7 9L11.2929 4.70711C11.6262 4.37377 11.7929 4.20711 12 4.20711C12.2071 4.20711 12.3738 4.37377 12.7071 4.70711L17 9"></path>
                        </svg><span>Post Comment</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>