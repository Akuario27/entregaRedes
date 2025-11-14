<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use phpseclib3\Net\SSH2;

$ip_switch = '192.168.2.30';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if ($usuario === '' || $contrasena === '') {
        die("Usuario y contraseña son obligatorios para probar la conexión SSH.");
    }

    try {
        $stmt = $pdo->prepare("SELECT contrasena_hash FROM usuarios_ssh WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $row = $stmt->fetch();

        if (!$row) {
            die("El usuario no está registrado en la base de datos.");
        }

        if (!password_verify($contrasena, $row['contrasena_hash'])) {
            die("La contraseña no coincide con la registrada en la base de datos.");
        }

        $ssh = new SSH2($ip_switch);

        if (!$ssh->login($usuario, $contrasena)) {
            die("No se pudo establecer conexión SSH con el switch.");
        }

        $output = $ssh->exec("show version");
        echo "<pre>" . htmlspecialchars($output) . "</pre>";
        echo "<br><a href=\"index.html\">Volver</a>";
    } catch (Exception $e) {
        die("Error en la conexión SSH: " . $e->getMessage());
    }
} else {
    echo "Método no permitido.";
}
