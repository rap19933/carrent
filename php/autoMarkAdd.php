<?php include 'connectDB.php'; ?>
<?php
if ($_SESSION['login'] === 'admin') {
    if (!empty($_POST["mark"])) {
        try {
            $stmt = $pdo->prepare('INSERT INTO `mark` (`Mark`) VALUES (:mark)');
            $stmt->bindParam(':mark', $_POST["mark"]);
            $result = $stmt->execute();
            echo $result;
        } catch (PDOException $e) {
            echo '-1';
        }
    } else echo '0';
} else {
    exit();
}
