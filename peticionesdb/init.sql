CREATE DATABASE peticiones;
use peticiones;

CREATE TABLE usuarios (
    usuario varchar(255) NOT NULL,
    nombre varchar(255),
    rol enum('admin', 'validador'),
    password varchar(255),
    primary key(usuario)
);

CREATE TABLE clientes (
    cc varchar(255) NOT NULL,
    password varchar(255),
    primary key(cc)
);

CREATE TABLE peticiones (
    id int(11) NOT NULL auto_increment,
    cccliente VARCHAR(255) NOT NULL,
    ccarchivo VARCHAR(255) NOT NULL,
    tiposervicio VARCHAR(255) NOT NULL,
    bancocliente VARCHAR(255) NOT NULL,
    fechahorasolicitud timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuariovalidador VARCHAR(255),
    nombrevalidador VARCHAR(255),
    estado VARCHAR(255),
    fechahorarevision datetime,
    primary key(id)
);

