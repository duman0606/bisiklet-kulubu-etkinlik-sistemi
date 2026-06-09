# Yapay Zeka Kullanımı

Bu proje geliştirilirken ChatGPT'den  hata düzeltme ve tasarım önerileri konusunda destek alınmıştır.

Kodların düzenlenmesi hatalarının ayıklanması  ve proje yapısının oluşturulması süreçlerinde yapay zekadan yardımcı araç olarak yararlanılmıştır. Yapay zekaya ona sorduğum soruları derlemesini istedim böyle bir sonuç çıktı.
 


 # AI.md

## Projeyi yaparken yapay zekaya sorduğum bazı sorular

---

### Soru 1

Bu projeye nerden başlayacağım ya?

### Cevap

Önce veritabanını oluşturup sonra config.php dosyasını hazırlamam, daha sonra kayıt ve giriş sistemini yapmam önerildi.

---

### Soru 2

phpMyAdmin kullanıyorum yeni veritabanını nasıl oluşturuyorduk?

### Cevap

Yeni butonuna basıp veritabanı adını yazıp oluşturabileceğim söylendi.

---

### Soru 3

xampp böyle görünüyor napcam?

### Cevap

Apache ve MySQL servislerini başlatmam gerektiği söylendi.

---

### Soru 4

Tamam oluşturdum şimdi sırada ne var?

### Cevap

Önce users tablosunu sonra events tablosunu oluşturmam tavsiye edildi.

---

### Soru 5

Şifreleri düz mü kaydedeyim?

### Cevap

Hayır, password_hash() fonksiyonunu kullanmanın daha güvenli olduğu anlatıldı.

---

### Soru 6

Şöyle yaptım ama giriş olmuyor.

### Cevap

password_verify() fonksiyonunu kullanmam gerektiği söylendi.

```php
if(password_verify($password,$user["password"])){
    $_SESSION["user_id"]=$user["id"];
}
```

---

### Soru 7

Dashboard'a giriş yapmadan giriliyor bunu nasıl engellerim?

### Cevap

Session kontrolü eklemem gerektiği anlatıldı.

```php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location:login.php");
    exit;
}
```

---

### Soru 8

Etkinlikleri nasıl listeleyebilirim?

### Cevap

Veritabanından çekip foreach ile ekrana yazdırabileceğim söylendi.

```php
foreach($events as $event){
    echo $event["title"];
}
```

---

### Soru 9

CRUD tam olarak neydi 

### Cevap

Create Read Update Delete işlemlerinin tamamına CRUD denildiği anlatıldı.

---

### Soru 10

Bu kayıt ekranını süsleyelim çiçekli falan olsun bisiklet resmi olsun.

### Cevap

Bootstrap kart yapıları ve pastel renkler kullanabileceğim önerildi.

---

### Soru 11

Kodun tamamını atsana tek tek uğraşmayayım.

### Cevap

Eksik kısımlar yerine tam dosya düzenlenerek verilmesi daha kolay olduğu söylendi.

---

### Soru 12

Bu hata neden çıkıyor?

### Cevap

Önce config.php dosyasını ve veritabanı bağlantısını kontrol etmem gerektiği söylendi.

---

### Soru 13

localhost çalışıyor ama hostinge atınca çalışmıyor.

### Cevap

config.php içindeki veritabanı bilgilerinin hosting bilgileriyle değiştirilmesi gerektiği anlatıldı.

---

### Soru 14

Hosting nerde 

### Cevap

Okulun verdiği hosting bilgileri sayfasından phpMyAdmin ve FTP bilgilerinin alınabileceği söylendi.

---

### Soru 15

GitHub'a zip mi yükleyeceğim?

### Cevap

Zip değil, zipin içindeki dosyaların yüklenmesi gerektiği anlatıldı.

---

### Soru 16

README ne yazacağım?

### Cevap

Projenin amacı, kullanılan teknolojiler ve kurulum adımlarını yazmam önerildi.

---

### Soru 17

AI.md dosyasına ne yazılıyor?

### Cevap

Yapay zekadan hangi konularda yardım aldığımı ve süreç boyunca sorduğum soruları eklemem gerektiği söylendi.

---

### Soru 18

Dashboard'da etkinlikleri tarihe göre sıralayabilir miyim?

### Cevap

ORDER BY kullanılabileceği söylendi.

```sql
SELECT * FROM events
ORDER BY event_date ASC;
```

---

### Soru 19

Etkinlik araması nasıl yapılır?

### Cevap

LIKE operatörü kullanılabileceği anlatıldı.

```php
$sql.=" AND title LIKE ?";
$params[]="%".$search."%";
```

---

### Soru 20

Çıkış yapınca tekrar panele girmesin istiyorum.

### Cevap

session_destroy() kullanmam gerektiği söylendi.

```php
session_start();
session_destroy();
header("Location:login.php");
```

---

### Soru 21

Bu dosyaları GitHub'a yükleyince herkes siteyi kullanabilecek mi?

### Cevap

GitHub'ın sadece kod deposu olduğu, çalışan sitenin hosting üzerinde bulunduğu açıklandı.

---

### Soru 22

Fotoğraf yükledim ama görünmüyor.

### Cevap

Önce uploads klasörünü sonra image alanının veritabanına kaydolup kaydolmadığını kontrol etmem gerektiği söylendi.

---

### Soru 23

uploads klasörü olmuş mu?

### Cevap

Doğru yerde olduğu ve içine yüklenen dosyaların kontrol edilmesi gerektiği söylendi.

---

### Soru 24

Tarayıcıya ne yazınca çıkacak?

### Cevap

localhost kullanırken htdocs klasörü üzerinden erişmem gerektiği anlatıldı.

---

### Soru 25

FileZilla'ya bağlandım şimdi ne yapacağım?

### Cevap

create_event.php, dashboard.php ve diğer güncel dosyaları public_html klasörüne yüklemem gerektiği söylendi.

---

### Soru 26

Bu kod neden kırmızı gözüküyor?

### Cevap

PHP etiketlerinin doğru kapanıp kapanmadığını kontrol etmem gerektiği söylendi.

---

### Soru 27

Ana linkte Forbidden yazıyor.

### Cevap

index.php olmadığı için oluştuğu, login.php dosyasına yönlendirme yapılabileceği söylendi.

---

### Soru 28

Veritabanı bağlantı hatası alıyorum.

### Cevap

config.php dosyasındaki host, kullanıcı adı ve şifrenin kontrol edilmesi gerektiği anlatıldı.

---


### Soru 29

Proje bitti mi şimdi?

### Cevap

Kayıt olma, giriş yapma, etkinlik ekleme, düzenleme, silme ve listeleme çalışıyorsa projenin teslim edilebilir durumda olduğu belirtildi.
