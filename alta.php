<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario   = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if ($usuario === '' || $contrasena === '') {
        die("Usuario y contraseña son obligatorios.");
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios_ssh WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $existe = $stmt->fetch();

        if ($existe) {
            die("El usuario ya existe. Elija otro nombre.");
        }

        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO usuarios_ssh (usuario, contrasena_hash) VALUES (?, ?)"
        );
        $stmt->execute([$usuario, $hash]);

        echo "Alta realizada con éxito para el usuario: " . htmlspecialchars($usuario);
        echo "<br><a href=\"index.html\">Volver</a>";
    } catch (PDOException $e) {
        die("Error al dar de alta el usuario: " . $e->getMessage());
    }
} else {
    echo "Método no permitido.";
}
