<?php

session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

if(isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM events
            WHERE id = ?
            AND user_id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id,
        $_SESSION["user_id"]
    ]);
}

header("Location: dashboard.php");
exit;

?>
