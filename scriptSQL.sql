CREATE DATABASE viviendas;
CREATE TABLE vivienda (
id		INT AUTO_INCREMENT,
tipo		VARCHAR(255),
zona		VARCHAR(255),
domicilio	VARCHAR(255),
dormitorios	INT,
precio		DOUBLE,
tamano		INT,
extras		VARCHAR(255),
foto		VARCHAR(255),
observaciones	VARCHAR(255),
CONSTRAINT pk_vivienda PRIMARY KEY (id)
);