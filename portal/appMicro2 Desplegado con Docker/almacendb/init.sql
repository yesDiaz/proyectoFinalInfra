CREATE DATABASE almacen;
use almacen;

CREATE TABLE ordenes (
    id int(11) NOT NULL auto_increment,
    nombreCliente varchar(50),
    emailCliente varchar(50) NOT NULL,
    totalCuenta decimal(10,2),
    fechahora datetime DEFAULT CURRENT_TIMESTAMP,
    primary key(id)
);

CREATE TABLE usuarios (
    nombre varchar(50),
    email varchar(50),
    usuario varchar(20) NOT NULL,
    password varchar(20),
    primary key(usuario)
);

CREATE TABLE productos (
    id int(11) NOT NULL auto_increment,
    nombre varchar(50),
    precio decimal(10,2),
    inventario int(11),
    primary key(id)
);

INSERT INTO usuarios (nombre,email,usuario,password)
VALUES('Usuario Admin', 'admin@correo.com','admin','123456'),
  ('prueba', 'pruebas4@correo.com','pruebas48','987654'),
  ('Usuario Uno', ' usuario1@correo.com','usuario1','123456');

INSERT INTO productos (nombre,precio,inventario)
VALUES('Televisor', 6000.99,20),
  ('Nevera', 1000.99,20);