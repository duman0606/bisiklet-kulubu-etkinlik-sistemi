<?php
session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date = $_POST["event_date"];
    $location = trim($_POST["location"]);
    $difficulty = $_POST["difficulty"];
    $imageName = null;

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];

        if(in_array($_FILES["image"]["type"], $allowedTypes)) {

            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $imageName = time() . "_" . uniqid() . "." . $extension;
            $uploadPath = "uploads/" . $imageName;

            move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
        }
    }

    if($title && $event_date && $location && $difficulty) {

        $sql = "INSERT INTO events
        (user_id, title, description, event_date, location, difficulty, image)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_SESSION["user_id"],
            $title,
            $description,
            $event_date,
            $location,
            $difficulty,
            $imageName
        ]);

        $message = "Etkinlik başarıyla eklendi 🌸";
    } else {
        $message = "Lütfen tüm zorunlu alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Etkinlik Ekle</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    background:linear-gradient(135deg,#ffeef5,#fff8fb);
    font-family:Arial, sans-serif;
}

.form-box{
    width:650px;
    margin:45px auto;
    background:white;
    padding:42px;
    border-radius:28px;
    box-shadow:0 10px 28px rgba(0,0,0,0.1);
}

.title{
    color:#ff6fa5;
    text-align:center;
    font-size:36px;
    font-weight:bold;
    margin-bottom:8px;
}

.subtitle{
    text-align:center;
    color:#777;
    margin-bottom:25px;
}

.form-control,
.form-select{
    border-radius:15px;
    margin-bottom:18px;
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

.back-link{
    text-align:center;
    margin-top:18px;
}
</style>
</head>

<body>

<div class="form-box">

    <div class="title">Yeni Etkinlik 🚴</div>
    <div class="subtitle">Kulüp için yeni bir bisiklet rotası ekle 🌸</div>

    <?php if($message): ?>
        <div class="alert <?php echo strpos($message, 'başarıyla') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="title" class="form-control" placeholder="Etkinlik Başlığı *">

        <textarea name="description" class="form-control" placeholder="Etkinlik açıklaması"></textarea>

        <input type="date" name="event_date" class="form-control">

        <input type="text" name="location" class="form-control" placeholder="Konum *">

        <select name="difficulty" class="form-select">
            <option>Kolay</option>
            <option>Orta</option>
            <option>Zor</option>
        </select>

        <input type="file" name="image" class="form-control">

        <button class="btn-pink">
            Etkinliği Kaydet
        </button>

    </form>

    <div class="back-link">
        <a href="dashboard.php">Panele Dön</a>
    </div>

</div>

</body>
</html>
