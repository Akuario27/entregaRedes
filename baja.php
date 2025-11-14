<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';

    if ($usuario === '') {
        die("Debe indicar el usuario a eliminar.");
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios_ssh WHERE usuario = ?");
        $stmt->execute([$usuario]);

        if ($stmt->rowCount() > 0) {
            echo "El usuario " . htmlspecialchars($usuario) . " fue eliminado correctamente.";
        } else {
            echo "No se encontró el usuario " . htmlspecialchars($usuario) . " en la base de datos.";
        }

        echo "<br><a href=\"index.html\">Volver</a>";
    } catch (PDOException $e) {
        die("Error al eliminar el usuario: " . $e->getMessage());
    }
} else {
    echo "Método no permitido.";
}
