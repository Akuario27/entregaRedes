<?php
require_once __DIR__ . '/conexion.php';

try {
    $stmt = $pdo->query("SELECT usuario, fecha_registro FROM usuarios_ssh ORDER BY fecha_registro DESC");
    $usuarios = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener usuarios: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Credenciales SSH</title>
</head>
<body>
    <h1>Gestión de Credenciales SSH</h1>

    <h2>Usuarios registrados</h2>
    <?php if (count($usuarios) === 0): ?>
        <p>No hay usuarios registrados.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Usuario</th>
                <th>Fecha de registro</th>
            </tr>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['usuario']); ?></td>
                    <td><?php echo htmlspecialchars($u['fecha_registro']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="index.html">Volver al ABM</a>
</body>
</html>
