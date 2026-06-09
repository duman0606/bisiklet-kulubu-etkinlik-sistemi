<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: dashboard.php");
            exit;
        } else {
            $message = "E-posta veya şifre hatalı.";
        }
    } else {
        $message = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Bisiklet Kulübü - Giriş</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:
    linear-gradient(rgba(255,255,255,0.45), rgba(255,255,255,0.45)),
    url('https://images.unsplash.com/photo-1529429617124-aee711a5ac1c?q=80&w=1974&auto=format&fit=crop');
    background-size:cover;
    background-position:center;
    font-family:Arial, sans-serif;
}

.login-box{
    width:430px;
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    text-align:center;
}

.title{
    color:#ff6fa5;
    font-size:40px;
    font-weight:bold;
}

.subtitle{
    color:#666;
    margin-bottom:25px;
}

.form-control{
    height:50px;
    border-radius:15px;
    margin-bottom:20px;
}

.btn-login{
    background:#ff7faa;
    border:none;
    height:50px;
    border-radius:15px;
    font-size:18px;
    color:white;
    width:100%;
}

.btn-login:hover{
    background:#ff5f96;
}

.bike{
    width:115px;
    margin-bottom:15px;
}

.small-text{
    margin-top:20px;
    color:#777;
}
</style>
</head>

<body>

<div class="login-box">

<img class="bike" src="https://cdn-icons-png.flaticon.com/512/2972/2972185.png">

<div class="title">Bisiklet Kulübü</div>
<div class="subtitle">Tekrar hoş geldin 🌸</div>

<?php if($message): ?>
<div class="alert alert-danger">
    <?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" class="form-control" placeholder="E-posta">
    <input type="password" name="password" class="form-control" placeholder="Şifre">

    <button class="btn-login">Giriş Yap</button>
</form>

<div class="small-text">
    Hesabın yok mu?
    <a href="register.php">Kayıt ol</a>
</div>

</div>

</body>
</html>
