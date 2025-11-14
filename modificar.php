<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario    = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if ($usuario === '' || $contrasena === '') {
        die("Usuario y nueva contraseña son obligatorios.");
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios_ssh WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $existe = $stmt->fetch();

        if (!$existe) {
            die("El usuario no existe. No se puede modificar.");
        }

        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "UPDATE usuarios_ssh SET contrasena_hash = ? WHERE usuario = ?"
        );
        $stmt->execute([$hash, $usuario]);

        echo "La contraseña de " . htmlspecialchars($usuario) . " fue actualizada correctamente.";
        echo "<br><a href=\"index.html\">Volver</a>";
    } catch (PDOException $e) {
        die("Error al modificar la contraseña: " . $e->getMessage());
    }
} else {
    echo "Método no permitido.";
}
