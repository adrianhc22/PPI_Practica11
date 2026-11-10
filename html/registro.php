<?php
// ============================================================
// registro.php - Registrar un libro nuevo
// ============================================================
require "conexion.php";

$error = "";
$exito = "";

// Valores para volver a pintar el formulario si hay error
$autor = "";
$titulo = "";
$fecha = "";

// ------------------------------------------------------------
// Función: comprime/redimensiona la portada para que quepa en
// la columna BLOB (máximo 64 KB) y la deja en formato JPEG.
// ------------------------------------------------------------
function comprimirPortada($tmp, $maxBytes = 65000)
{
    // Las imágenes grandes necesitan más memoria para procesarse
    ini_set("memory_limit", "512M");

    $info = getimagesize($tmp);

    if ($info === false) {
        return false;
    }

    // Elegimos la función de carga según el tipo de imagen
    $funciones = array(
        IMAGETYPE_JPEG => "imagecreatefromjpeg",
        IMAGETYPE_PNG => "imagecreatefrompng",
        IMAGETYPE_GIF => "imagecreatefromgif",
        IMAGETYPE_WEBP => "imagecreatefromwebp"
    );

    if (!isset($funciones[$info[2]])) {
        return false;
    }

    $funcion = $funciones[$info[2]];

    if (!function_exists($funcion)) {
        return false;
    }

    $img = $funcion($tmp);

    if ($img === false) {
        return false;
    }

    // Redimensionamos si es más grande que 500 px
    $ancho = imagesx($img);
    $alto = imagesy($img);
    $maxDim = 500;

    if ($ancho > $maxDim || $alto > $maxDim) {
        $ratio = $maxDim / max($ancho, $alto);
        $nuevoAncho = (int) ($ancho * $ratio);
        $nuevoAlto = (int) ($alto * $ratio);

        $nueva = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagecopyresampled($nueva, $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        $img = $nueva;
    }

    // Bajamos la calidad de JPEG hasta que quepa en 64 KB
    $calidad = 85;
    $datos = "";

    do {
        ob_start();
        imagejpeg($img, null, $calidad);
        $datos = ob_get_clean();
        $calidad = $calidad - 10;
    } while (strlen($datos) > $maxBytes && $calidad >= 25);

    return $datos;
}

// ------------------------------------------------------------
// Procesamiento del formulario
// ------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $autor = trim($_POST["autor"] ?? "");
    $titulo = trim($_POST["titulo"] ?? "");
    $fecha = $_POST["fecha"] ?? "";

    if ($autor === "" || $titulo === "" || $fecha === "") {
        $error = "Completa el autor, el título y la fecha de publicación.";

    } elseif (!isset($_FILES["portada"]) || $_FILES["portada"]["error"] !== UPLOAD_ERR_OK) {
        $error = "Selecciona una imagen de portada (JPG, PNG, GIF o WEBP).";

    } else {

        $imagen = comprimirPortada($_FILES["portada"]["tmp_name"]);

        if ($imagen === false) {
            $error = "La imagen no es válida. Usa un archivo JPG, PNG, GIF o WEBP.";

        } else {

            // Consulta preparada para insertar también los datos binarios
            $sql = "INSERT INTO libros (autor, titulo, fecha_publicacion, portada)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $sql);

            if ($stmt === false) {
                $error = "Error en la consulta: " . mysqli_error($con);
            } else {
                // Los datos binarios (BLOB) se envían con send_long_data
                $nulo = null;
                mysqli_stmt_bind_param($stmt, "sssb", $autor, $titulo, $fecha, $nulo);
                mysqli_stmt_send_long_data($stmt, 3, $imagen);

                $ok = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                if ($ok) {
                    $exito = "El libro se registró correctamente.";
                    $autor = "";
                    $titulo = "";
                    $fecha = "";
                } else {
                    $error = "No se pudo guardar el libro: " . mysqli_error($con);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Librería - Registro</title>

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
                <a class="nav-link active" href="registro.php">Registro</a>
                <a class="nav-link" href="consulta.php">Consulta</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <h1 class="h2 mb-4">Registrar un libro</h1>

                <?php if ($error !== "") { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php } ?>

                <?php if ($exito !== "") { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($exito); ?>
                        <a href="consulta.php" class="alert-link">Ver libros registrados</a>.
                    </div>
                <?php } ?>

                <div class="card shadow-sm">
                    <div class="card-body">

                        <form method="post" action="registro.php" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="autor" class="form-label">Autor</label>
                                <input type="text" class="form-control" id="autor" name="autor"
                                    value="<?php echo htmlspecialchars($autor); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    value="<?php echo htmlspecialchars($titulo); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de publicación</label>
                                <input type="date" class="form-control" id="fecha" name="fecha"
                                    value="<?php echo htmlspecialchars($fecha); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="portada" class="form-label">Imagen de portada</label>
                                <input type="file" class="form-control" id="portada" name="portada"
                                    accept="image/jpeg,image/png,image/gif,image/webp" required>
                                <div class="form-text">
                                    Se guarda en la base de datos como BLOB (se comprime automáticamente).
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Guardar libro</button>
                                <a href="consulta.php" class="btn btn-outline-secondary">Ver registrados</a>
                            </div>

                        </form>

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
