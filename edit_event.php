<?php
session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

if(!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM events
        WHERE id = ?
        AND user_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $id,
    $_SESSION["user_id"]
]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$event) {
    header("Location: dashboard.php");
    exit;
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date = $_POST["event_date"];
    $location = trim($_POST["location"]);
    $difficulty = $_POST["difficulty"];

    $update = "UPDATE events
               SET title=?,
                   description=?,
                   event_date=?,
                   location=?,
                   difficulty=?
               WHERE id=?
               AND user_id=?";

    $updateStmt = $pdo->prepare($update);

    $updateStmt->execute([
        $title,
        $description,
        $event_date,
        $location,
        $difficulty,
        $id,
        $_SESSION["user_id"]
    ]);

    $message = "Etkinlik güncellendi 🌸";

    $stmt->execute([$id, $_SESSION["user_id"]]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>

<meta charset="UTF-8">
<title>Etkinlik Düzenle</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#ffeef5;
    font-family:Arial;
}

.form-box{
    width:600px;
    margin:auto;
    margin-top:50px;
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.title{
    color:#ff6fa5;
    text-align:center;
    font-size:35px;
    font-weight:bold;
    margin-bottom:25px;
}

.form-control,
.form-select{
    border-radius:15px;
    margin-bottom:20px;
    height:50px;
}

textarea.form-control{
    height:120px;
}

.btn-pink{
    background:#ff7faa;
    border:none;
    height:50px;
    border-radius:15px;
    color:white;
    width:100%;
    font-size:18px;
}

.btn-pink:hover{
    background:#ff5f96;
}

</style>

</head>

<body>

<div class="form-box">

<div class="title">
Etkinlik Düzenle 🚴
</div>

<?php if($message): ?>

<div class="alert alert-success">
<?php echo htmlspecialchars($message); ?>
</div>

<?php endif; ?>

<form method="POST">

<input
type="text"
name="title"
class="form-control"
value="<?php echo htmlspecialchars($event["title"]); ?>">

<textarea
name="description"
class="form-control"><?php echo htmlspecialchars($event["description"]); ?></textarea>

<input
type="date"
name="event_date"
class="form-control"
value="<?php echo htmlspecialchars($event["event_date"]); ?>">

<input
type="text"
name="location"
class="form-control"
value="<?php echo htmlspecialchars($event["location"]); ?>">

<select
name="difficulty"
class="form-select">

<option <?php if($event["difficulty"]=="Kolay") echo "selected"; ?>>
Kolay
</option>

<option <?php if($event["difficulty"]=="Orta") echo "selected"; ?>>
Orta
</option>

<option <?php if($event["difficulty"]=="Zor") echo "selected"; ?>>
Zor
</option>

</select>

<button class="btn-pink">
Güncelle
</button>

</form>

<div class="mt-3 text-center">

<a href="dashboard.php">
Panele Dön
</a>

</div>

</div>

</body>
</html>
