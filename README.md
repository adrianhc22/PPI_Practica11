# Práctica 11: HTML + PHP + SQL + Bootstrap

Mini-sistema de registro de libros para una librería (preámbulo del proyecto final).

**Repositorio:** https://github.com/adrianhc22/PPI_Practica11

## Páginas
- **Inicio** (`index.php`): bienvenida y navegación.
- **Registro** (`registro.php`): formulario para agregar un libro (autor, título, fecha y portada).
- **Consulta** (`consulta.php`): muestra todos los libros registrados con su portada.

## Requisitos
- Docker Desktop instalado y **abierto** (corriendo).

## Cómo ejecutarla
```bash
cd ~/Downloads/ProgParaInternet/Practicas/Practica11_Libros_Bootstrap
docker compose up -d --build
```
Luego abre en el navegador:
**http://localhost:8080/index.php**

Para detenerla:
```bash
docker compose down
```

## Tecnologías
- **PHP 8.2** (mysqli + gd) sobre Apache.
- **MariaDB 11** en un contenedor.
- **Bootstrap 5** (CDN) para todos los elementos de las 3 páginas.
- La portada se guarda como **BLOB** en la base de datos y se muestra con un
  `data:image/jpeg;base64,...` generado desde PHP.

## Estructura
```
Practica11_Libros_Bootstrap/
├── Dockerfile            # PHP + Apache + mysqli + gd
├── docker-compose.yml    # web + db (MariaDB)
├── init.sql              # crea la tabla libros
├── volcado.sql           # volcado de la base de datos
├── reporte.html          # reporte con pantallazos
└── html/
    ├── conexion.php      # conexión común a la BD
    ├── index.php         # Inicio
    ├── registro.php      # Registro (con subida de imagen BLOB)
    └── consulta.php      # Consulta (tarjetas con portada)
```
