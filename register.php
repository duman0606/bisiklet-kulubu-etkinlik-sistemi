<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name && $email && $password) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        try {

            $stmt->execute([$name, $email, $hashedPassword]);

            $message = "Kayıt başarılı!";

        } catch(PDOException $e) {

            $message = "Bu e-posta zaten kayıtlı.";
        }

    } else {

        $message = "Tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>

<meta charset="UTF-8">
<title>Bisiklet Kulübü</title>

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
    linear-gradient(rgba(255,255,255,0.4),
    rgba(255,255,255,0.4)),
    url('https://images.unsplash.com/photo-1529429617124-aee711a5ac1c?q=80&w=1974&auto=format&fit=crop');
    background-size:cover;
    background-position:center;
    font-family: Arial, sans-serif;
}

.register-box{
    width:450px;
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    text-align:center;
}

.title{
    color:#ff6fa5;
    font-size:42px;
    font-weight:bold;
    margin-bottom:10px;
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

.btn-register{
    background:#ff7faa;
    border:none;
    height:50px;
    border-radius:15px;
    font-size:18px;
    color:white;
    width:100%;
    transition:0.3s;
}

.btn-register:hover{
    background:#ff5f96;
}

.bike{
    width:120px;
    margin-bottom:15px;
}

.small-text{
    margin-top:20px;
    color:#777;
}

</style>

</head>

<body>

<div class="register-box">

<img class="bike"
src="https://cdn-icons-png.flaticon.com/512/2972/2972185.png">

<div class="title">
Bisiklet Kulübü
</div>

<div class="subtitle">
Birlikte pedallayalım 🌸
</div>

<?php if($message): ?>

<div class="alert alert-info">
<?php echo htmlspecialchars($message); ?>
</div>

<?php endif; ?>

<form method="POST">

<input
type="text"
name="name"
class="form-control"
placeholder="Ad Soyad">

<input
type="email"
name="email"
class="form-control"
placeholder="E-posta">

<input
type="password"
name="password"
class="form-control"
placeholder="Şifre">

<button class="btn-register">
Kayıt Ol
</button>

</form>

<div class="small-text">
Zaten hesabın var mı?
<a href="login.php">Giriş Yap</a>
</div>

</div>

</body>
</html>
