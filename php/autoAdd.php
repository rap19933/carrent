<?php include 'connectDB.php'; ?>
<?php
if ($_SESSION['login'] === 'admin') {
    if ($_POST["image"] !== 'undefined' && $_POST["model"] !== '' && $_POST["number"] !== '' && $_POST["releaseData"]
        !== '' && $_POST["price"] !== '') {
        if (is_numeric($_POST["price"]) && is_numeric($_POST["releaseData"])) {
            try {
                $stmt = $pdo->prepare('INSERT INTO `auto`
                    (`MarkId`, `Model`, `Number`, `ReleaseData`, `Price`, `Photo`)
                        VALUES (:markId, :model, :gosNumber, :releaseData, :price, :image)');
                $stmt->bindParam(':markId', $_POST["selectId"]);
                $stmt->bindParam(':model', $_POST["model"]);
                $stmt->bindParam(':gosNumber', $_POST["number"]);
                $stmt->bindParam(':releaseData', $_POST["releaseData"], PDO::PARAM_INT);
                $stmt->bindParam(':price', $_POST["price"]);
                $stmt->bindParam(':image', $_POST["image"]);

                $result = $stmt->execute();
                echo $result;
            } catch (PDOException $e) {
                echo '-1';
            }
        } else  echo '-2';
    } else echo '-3';
} else {
    exit();
}
