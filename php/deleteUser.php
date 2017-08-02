<?php include 'connectDB.php'; ?>
<?php
if ($_SESSION['login'] === 'admin') {
    try {
        $stmt = $pdo->prepare('DELETE FROM `user` WHERE `UserId`=:userId');
        $stmt->bindParam(':userId', $_POST["id"]);
        $result = $stmt->execute();
        echo $result;
    } catch (PDOException $e) {
        echo '-1';
    }
} else {
    exit();
}
