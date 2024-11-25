CREATE DATABASE if not exists PortafolioArtistico;
USE PortafolioArtistico;

#Categorías  - -  pintura, escultura, arquitectura, música, baile, literatura y fotografia
CREATE TABLE if not exists TCategorias (
    iCategoria_id INT AUTO_INCREMENT PRIMARY KEY,
    cCategoria VARCHAR(50) NOT NULL
)engine=InnoDB;

#Etiquetas  - -  hashtags : digital, tradicional, 3d, etc
CREATE TABLE if not exists TEtiquetas ( 
    iEtiqueta_id INT AUTO_INCREMENT PRIMARY KEY,
    cEtiqueta VARCHAR(50) NOT NULL
)engine=InnoDB;


#Usuarios  - - 
CREATE TABLE if not exists TUsuarios (
    iUsuario_id INT AUTO_INCREMENT PRIMARY KEY,
    cNombre VARCHAR(48) NOT NULL,
    cUsuario VARCHAR(24) NOT NULL UNIQUE,
    cCorreo VARCHAR(100) NOT NULL UNIQUE,
    cPassword VARCHAR(255) NOT NULL,
    dRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tBiografia TEXT,
    tFoto_perfil text
)engine=InnoDB;


#Proyectos
CREATE TABLE if not exists TProyectos (
    iProyecto_id INT AUTO_INCREMENT PRIMARY KEY,
    cTitulo VARCHAR(100) NOT NULL,
    tDescripcion TEXT,
    dCreacion DATETIME,
    cUrl VARCHAR(255) NOT NULL,
	iUsuario_id INT,
    iCategoria_id INT,
	FOREIGN KEY (iUsuario_id) REFERENCES TUsuarios(iUsuario_id),
    FOREIGN KEY (iCategoria_id) REFERENCES TCategorias(iCategoria_id)
)engine=InnoDB;


#Comentarios
CREATE TABLE if not exists TComentarios (
    iComentario_id INT AUTO_INCREMENT PRIMARY KEY,
    iProyecto_id INT,
    iUsuario_id INT,
    cTexto TEXT NOT NULL,
    dComentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (iProyecto_id) REFERENCES TProyectos(iProyecto_id),
    FOREIGN KEY (iUsuario_id) REFERENCES TUsuarios(iUsuario_id)
)engine=InnoDB;

#Favoritos
CREATE TABLE if not exists TFavoritos (
    iFavorito_id INT AUTO_INCREMENT PRIMARY KEY,
    iUsuario_id INT,
    iProyecto_id INT,
    FOREIGN KEY (iUsuario_id) REFERENCES TUsuarios(iUsuario_id),
    FOREIGN KEY (iProyecto_id) REFERENCES TProyectos(iProyecto_id)
)engine=InnoDB;


#Seguidores  
CREATE TABLE TFollows (
    iFollows_id INT AUTO_INCREMENT PRIMARY KEY,
    iSeguidor_id INT,
    iSeguido_id INT,
    FOREIGN KEY (iSeguidor_id) REFERENCES TUsuarios(iUsuario_id),
    FOREIGN KEY (iSeguido_id) REFERENCES TUsuarios(iUsuario_id)
)engine=InnoDB;


CREATE TABLE if not exists TArchivos (
    iArchivo_id INT AUTO_INCREMENT PRIMARY KEY,
    iProyecto_id INT,
    tArchivo TEXT,
    FOREIGN KEY (iProyecto_id) REFERENCES TProyectos(iProyecto_id)
)engine=InnoDB;


#Grupo etiquetas de la publicacion
CREATE TABLE if not exists Tetpubli (
    iEtpubli_id INT AUTO_INCREMENT PRIMARY KEY,
    iProyecto_id INT,
    iEtiqueta_id int,
    FOREIGN KEY (iEtiqueta_id) REFERENCES TEtiquetas (iEtiqueta_id),
    FOREIGN KEY (iProyecto_id) REFERENCES TProyectos (iProyecto_id)
)engine=InnoDB;


#Moderadores
CREATE TABLE if not exists TModeradores (
iModerador_id INT AUTO_INCREMENT PRIMARY KEY,
iUsuario_id INT,
CRol VARCHAR(50) NOT NULL,
dAsignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (iUsuario_id) REFERENCES TUsuarios (iUsuario_id) ON DELETE CASCADE
)engine=InnoDB;