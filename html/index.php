<?php
// index.php - Página de bienvenida del sistema de librería
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Librería - Inicio</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Librería</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="index.php">Inicio</a>
                <a class="nav-link" href="registro.php">Registro</a>
                <a class="nav-link" href="consulta.php">Consulta</a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Bienvenido a la Librería</h1>
            <p class="lead text-muted">
                Sistema para registrar y consultar los libros de la librería.
                Elige una sección para comenzar.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-md-5">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="h4 card-title">Registrar un libro</h2>
                        <p class="card-text text-muted">
                            Agrega un libro nuevo con su autor, título, fecha de
                            publicación y la imagen de su portada.
                        </p>
                        <a href="registro.php" class="btn btn-primary">Ir a Registro</a>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="h4 card-title">Consultar libros</h2>
                        <p class="card-text text-muted">
                            Revisa todos los libros que se han registrado en la
                            base de datos, con su portada.
                        </p>
                        <a href="consulta.php" class="btn btn-success">Ir a Consulta</a>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <small>Práctica 11 - HTML + PHP + SQL + Bootstrap</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
