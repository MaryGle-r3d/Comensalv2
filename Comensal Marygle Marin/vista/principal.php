<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Sistema de Comedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container text-center mt-5">
    <h1 class="mb-4"><?= htmlspecialchars($mensaje) ?></h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Gestión de Comensales</h5>
            <p class="card-text">Administrar los datos de los comensales registrados.</p>
            <a href="comensales.php" class="btn btn-primary">Ir a Comensales</a>
        </div>
    </div>

    <!-- Más secciones si necesitas -->
</div>

</body>
</html>
