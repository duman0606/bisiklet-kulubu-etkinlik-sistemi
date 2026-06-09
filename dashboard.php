<?php
session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

$user_id = $_SESSION["user_id"];

$search = isset($_GET["search"]) ? trim($_GET["search"]) : "";
$difficulty = isset($_GET["difficulty"]) ? $_GET["difficulty"] : "";

$sql = "SELECT * FROM events WHERE user_id = ?";
$params = [$user_id];

if($search != "") {
    $sql .= " AND (title LIKE ? OR location LIKE ?)";
    $params[] = "%".$search."%";
    $params[] = "%".$search."%";
}

if($difficulty != "") {
    $sql .= " AND difficulty = ?";
    $params[] = $difficulty;
}

$sql .= " ORDER BY event_date ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalEvents = count($events);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Bisiklet Kulübü Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    background:linear-gradient(135deg,#ffeef5,#fff8fb);
    font-family:Arial, sans-serif;
}

.navbar-custom{
    background:white;
    padding:18px 40px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.logo{
    color:#ff6fa5;
    font-size:28px;
    font-weight:bold;
}

.container-box{
    width:90%;
    max-width:1100px;
    margin:35px auto;
}

.hero{
    background:white;
    border-radius:28px;
    padding:35px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.hero h1{
    color:#ff6fa5;
    font-weight:bold;
}

.btn-pink{
    background:#ff7faa;
    color:white;
    border:none;
    border-radius:14px;
    padding:10px 18px;
    text-decoration:none;
}

.btn-pink:hover{
    background:#ff5f96;
    color:white;
}

.stat-box{
    background:white;
    border-radius:20px;
    padding:22px;
    text-align:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.stat-box h3{
    color:#ff6fa5;
    font-weight:bold;
}

.filter-box{
    background:white;
    border-radius:22px;
    padding:20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    margin:25px 0;
}

.card-box{
    background:white;
    border-radius:24px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    border-left:8px solid #ff9fbd;
}

.event-image{
    width:100%;
    max-height:260px;
    object-fit:cover;
    border-radius:18px;
    margin-bottom:18px;
}

.card-box h4{
    color:#ff6fa5;
    font-weight:bold;
}

.badge-pink{
    background:#ffe1ec;
    color:#ff4f8b;
    padding:8px 14px;
    border-radius:20px;
}

.empty-box{
    background:white;
    border-radius:22px;
    padding:35px;
    text-align:center;
    color:#777;
}

.footer{
    text-align:center;
    color:#888;
    margin:35px 0;
}
</style>
</head>

<body>

<div class="navbar-custom d-flex justify-content-between align-items-center">
    <div class="logo">🌸 Bisiklet Kulübü</div>

    <div>
        <a href="create_event.php" class="btn-pink">+ Etkinlik Ekle</a>
        <a href="logout.php" class="btn-pink">Çıkış Yap</a>
    </div>
</div>

<div class="container-box">

    <div class="hero">
        <h1>Hoş geldin, <?php echo htmlspecialchars($_SESSION["user_name"]); ?> 🚴</h1>
        <p>
            Bu panelden bisiklet etkinliklerini ekleyebilir, düzenleyebilir ve takip edebilirsin.
        </p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="stat-box">
                <h3><?php echo $totalEvents; ?></h3>
                <p>Listelenen Etkinlik</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-box">
                <h3>🌸</h3>
                <p>Pastel Tema</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-box">
                <h3>🚴</h3>
                <p>Bisiklet Kulübü</p>
            </div>
        </div>
    </div>

    <div class="filter-box">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                placeholder="Başlık veya konuma göre ara"
                value="<?php echo htmlspecialchars($search); ?>">
            </div>

            <div class="col-md-4">
                <select name="difficulty" class="form-select">
                    <option value="">Tüm zorluklar</option>
                    <option value="Kolay" <?php if($difficulty=="Kolay") echo "selected"; ?>>Kolay</option>
                    <option value="Orta" <?php if($difficulty=="Orta") echo "selected"; ?>>Orta</option>
                    <option value="Zor" <?php if($difficulty=="Zor") echo "selected"; ?>>Zor</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn-pink w-100">Filtrele</button>
            </div>
        </form>
    </div>

    <?php if(count($events) > 0): ?>

        <?php foreach($events as $event): ?>

            <div class="card-box">

                <?php if(!empty($event["image"])): ?>
                    <img class="event-image"
                    src="uploads/<?php echo htmlspecialchars($event["image"]); ?>"
                    alt="Etkinlik görseli">
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center">
                    <h4><?php echo htmlspecialchars($event["title"]); ?></h4>
                    <span class="badge-pink">
                        <?php echo htmlspecialchars($event["difficulty"]); ?>
                    </span>
                </div>

                <p><?php echo htmlspecialchars($event["description"]); ?></p>
                <p>📍 <?php echo htmlspecialchars($event["location"]); ?></p>
                <p>📅 <?php echo htmlspecialchars($event["event_date"]); ?></p>
                <p>🕒 Oluşturulma: <?php echo htmlspecialchars($event["created_at"]); ?></p>

                <a href="edit_event.php?id=<?php echo $event["id"]; ?>" class="btn btn-warning">
                    Düzenle
                </a>

                <a href="delete_event.php?id=<?php echo $event["id"]; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Bu etkinliği silmek istediğinize emin misiniz?');">
                    Sil
                </a>
            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="empty-box">
            Etkinlik bulunamadı 🌸 <br>
            Yeni bir etkinlik ekleyebilir veya filtreyi temizleyebilirsin.
        </div>

    <?php endif; ?>

    <div class="footer">
        Bisiklet Kulübü Etkinlik Takip Sistemi | PHP & MySQL Projesi
    </div>

</div>

</body>
</html>
