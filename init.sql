-- ============================================================
-- Práctica 11: HTML + PHP + SQL + Bootstrap
-- Base de datos "libreria" para el registro de libros
-- ============================================================

USE libreria;

CREATE TABLE libros (
    id INT(11) NOT NULL AUTO_INCREMENT,
    autor VARCHAR(100) NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    fecha_publicacion DATE,
    -- La portada se guarda como datos binarios (BLOB)
    portada BLOB,
    PRIMARY KEY (id)
) ENGINE=InnoDB;
