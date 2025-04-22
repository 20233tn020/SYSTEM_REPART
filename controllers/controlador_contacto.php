<?php
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';
require_once '../libs/PHPMailer/src/Exception.php';
require 'model/db.php';
//seguridad
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=()");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
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

// Generar código único
function generarCodigoUnico($conn, $longitud = 6) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    
    do {
        $codigo = '';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Verificar si ya existe en la base de datos
        $stmt = $conn->prepare("SELECT COUNT(*) FROM client WHERE Id_Client = ?");
        $stmt->execute([$codigo]);
        $existe = $stmt->fetchColumn();

    } while ($existe > 0); // Repetir si el código ya existe

    return $codigo;
}


$codigoUnico = generarCodigoUnico($conn);


// Fecha y hora local de Morelos
date_default_timezone_set("America/Mexico_City");
$fecha = date("Y-m-d H:i:s");

// Convertir servicios a string si es array
$serviciosTexto = is_array($servicios) ? implode(", ", $servicios) : $servicios;

// Insertar en la base de datos
try {
    $stmt = $conn->prepare('INSERT INTO client (Id_Client, Namee, Email, Movil, Services, messages, Statu, fecha_report) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $codigoUnico,
        $nombre,
        $email,
        $telefono,
        $serviciosTexto,
        $mensaje,
        "Pendiente",
        $fecha
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en base de datos: " . $e->getMessage()]);
    exit;
}

// Configurar cuerpo del correo
$asunto = "TECHOVER - Nuevo mensaje de contacto";
$cuerpo = "Nombre: $nombre\n";
$cuerpo .= "Correo: $email\n";
$cuerpo .= "Teléfono: $telefono\n";
$cuerpo .= "Código de cliente: $codigoUnico\n";
$cuerpo .= "Servicios: $serviciosTexto\n";
$cuerpo .= "Mensaje:\n$mensaje\n";
$cuerpo .= "Fecha (Morelos): $fecha\n";

// Configurar PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '20233tn020@utez.edu.mx';
    $mail->Password   = 'djcdjqfanwmlasni';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('20233tn020@utez.edu.mx', 'TechOver');
    $mail->addAddress('chrisdomingo809@gmail.com', 'TechOver Soporte');

    $mail->isHTML(false);
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;

    $mail->send();

    echo json_encode(["success" => "Mensaje enviado correctamente. Código: $codigoUnico"]);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al enviar el mensaje: " . $mail->ErrorInfo]);
}
?>
