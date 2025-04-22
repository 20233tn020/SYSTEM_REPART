<?php
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';
require_once '../libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json; charset=utf-8');
// 🛡️ Cabeceras de seguridad HTTP
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=()");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Método no permitido
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

// Validar y sanitizar los datos
$nombre = isset($_POST["nombre"]) ? htmlspecialchars(trim($_POST["nombre"])) : "";
$email = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : "";
$telefono = isset($_POST["telefono"]) ? htmlspecialchars(trim($_POST["telefono"])) : "";
$mensaje = isset($_POST["mensaje"]) ? htmlspecialchars(trim($_POST["mensaje"])) : "";
$servicios = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje)) {
    http_response_code(400);
    echo json_encode(["error" => "Todos los campos son obligatorios."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Correo electrónico no válido."]);
    exit;
}

if (count($servicios) === 0) {
    echo json_encode(["error" => "Debes seleccionar al menos un servicio."]);
    exit;
}

// Configurar cuerpo del correo
$asunto = "TECHOVER - Nuevo mensaje de contacto";
$cuerpo = "Nombre: $nombre\n";
$cuerpo .= "Correo: $email\n";
$cuerpo .= "Teléfono: $telefono\n";
$cuerpo .= "Servicios: " . implode(", ", $servicios) . "\n";
$cuerpo .= "Mensaje:\n$mensaje\n";

// Configurar PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '20233tn020@utez.edu.mx'; // ← Cambia esto
    $mail->Password   = 'djcdjqfanwmlasn'; // ← Cambia esto (no es tu contraseña normal)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('20233tn020@utez.edu.mx', 'TechOver'); // ← Igual que Username
    $mail->addAddress('chrisdomingo809@gmail.com', 'TechOver Soporte'); // ← Destinatario real

    // Contenido del correo
    $mail->isHTML(false); // plain text
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;

    $mail->send();

    echo json_encode(["success" => "Mensaje enviado correctamente."]);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al enviar el mensaje: " . $mail->ErrorInfo]);
}
?>
