<?php
// ============================================================
// consulta.php - Desplegar los libros registrados
// ============================================================
require "conexion.php";

// Traemos todos los libros (los más recientes primero)
$sql = "SELECT id, autor, titulo, fecha_publicacion, portada
        FROM libros
        ORDER BY id DESC";

$resultado = mysqli_query($con, $sql);

if ($resultado === false) {
    die("Error en la consulta: " . mysqli_error($con));
}

$total = mysqli_num_rows($resultado);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Librería - Consulta</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Librería</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Inicio</a>
                <a class="nav-link" href="registro.php">Registro</a>
                <a class="nav-link active" href="consulta.php">Consulta</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Libros registrados</h1>
            <span class="badge bg-primary fs-6"><?php echo $total; ?> libro(s)</span>
        </div>

        <?php if ($total == 0) { ?>

            <div class="alert alert-info" role="alert">
                Todavía no hay libros registrados.
                <a href="registro.php" class="alert-link">Registra el primero</a>.
            </div>

        <?php } else { ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

                <?php while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">

                            <?php if (!empty($fila["portada"])) { ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($fila["portada"]); ?>"
                                    class="card-img-top" alt="Portada de <?php echo htmlspecialchars($fila["titulo"]); ?>"
                                    style="height: 260px; object-fit: cover;">
                            <?php } else { ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="height: 260px;">
                                    Sin portada
                                </div>
                            <?php } ?>

                            <div class="card-body">
                                <h2 class="h6 card-title mb-1">
                                    <?php echo htmlspecialchars($fila["titulo"]); ?>
                                </h2>
                                <p class="card-text text-muted mb-2">
                                    <?php echo htmlspecialchars($fila["autor"]); ?>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($fila["fecha_publicacion"]); ?>
                                    </small>
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0">
                                <span class="badge bg-light text-dark">ID: <?php echo $fila["id"]; ?></span>
                            </div>

                        </div>
                    </div>
                <?php } ?>

            </div>

        <?php } ?>

        <div class="mt-4">
            <a href="registro.php" class="btn btn-primary">Registrar otro libro</a>
        </div>

    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <small>Práctica 11 - HTML + PHP + SQL + Bootstrap</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
