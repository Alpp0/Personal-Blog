<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veritabanı bağlantı bilgileri
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog";

    // Veritabanı bağlantısını oluştur
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // POST verilerini al
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $messageText = $_POST['message'];

    // SQL sorgusu
    $sql = "INSERT INTO iletisim (ad, soyad, email, mesaj) VALUES (?, ?, ?, ?)";

    // Parametreli sorgu kullanımı
    $stmt = $conn->prepare($sql);

    // Değişkenleri parametrelere bağla
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $messageText);

    // SQL sorgusunu çalıştır ve sonucu kontrol et
    if ($stmt->execute()) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => "Form gönderilirken bir hata oluştu. Hata Açıklaması: " . $stmt->error);
        echo json_encode($response);
    }

    // Bağlantıyı kapat
    $stmt->close();
    $conn->close();
}
