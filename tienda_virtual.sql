
-- Crear la base de datos
CREATE DATABASE tienda_virtual;
USE tienda_virtual;

-- Tabla de usuarios (para login)
CREATE TABLE usuarios (
    usuario VARCHAR(50) PRIMARY KEY,
    contraseña VARCHAR(255) NOT NULL
);

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL
);

-- Tabla de productos
CREATE TABLE productos (
    referencia VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
    imagen VARCHAR (255) NOT NULL,
);

-- Tabla de compras (opcional)
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50),
    referencia_producto VARCHAR(20),
    fecha_compra DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario) REFERENCES usuarios(usuario),
    FOREIGN KEY (referencia_producto) REFERENCES productos(referencia)
);


