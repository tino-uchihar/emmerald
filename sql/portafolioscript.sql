CREATE DATABASE IF NOT EXISTS PortafolioArtistico CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE PortafolioArtistico;

CREATE TABLE IF NOT EXISTS Categoria (
    nCategoriaID INT AUTO_INCREMENT PRIMARY KEY,
    cCategoria VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Etiqueta (
    nEtiquetaID INT AUTO_INCREMENT PRIMARY KEY,
    cEtiqueta VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Usuarios (
    nUsuarioID INT AUTO_INCREMENT PRIMARY KEY,
    cNombre VARCHAR(48) NOT NULL,
    cUsuario VARCHAR(24) NOT NULL UNIQUE,
    cCorreo VARCHAR(100) NOT NULL UNIQUE,
    cPassword VARCHAR(255) NOT NULL,
    dRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tBiografia TEXT,
    tFotoPerfil TEXT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Proyecto (
    nProyectoID INT AUTO_INCREMENT PRIMARY KEY,
    cTitulo VARCHAR(100) NOT NULL,
    tDescripcion TEXT,
    dCreacion DATETIME,
    cUrl VARCHAR(255) NOT NULL,
    nUsuarioFK INT,
    nCategoriaFK INT,
    FOREIGN KEY (nUsuarioFK) REFERENCES Usuarios(nUsuarioID),
    FOREIGN KEY (nCategoriaFK) REFERENCES Categoria(nCategoriaID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Comentario (
    nComentarioID INT AUTO_INCREMENT PRIMARY KEY,
    nProyectoFK INT,
    nUsuarioFK INT,
    cTexto TEXT NOT NULL,
    dComentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nProyectoFK) REFERENCES Proyecto(nProyectoID),
    FOREIGN KEY (nUsuarioFK) REFERENCES Usuarios(nUsuarioID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Favorito (
    nFavoritoID INT AUTO_INCREMENT PRIMARY KEY,
    nUsuarioFK INT,
    nProyectoFK INT,
    FOREIGN KEY (nUsuarioFK) REFERENCES Usuarios(nUsuarioID),
    FOREIGN KEY (nProyectoFK) REFERENCES Proyecto(nProyectoID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Seguidor (
    nSeguidorID INT AUTO_INCREMENT PRIMARY KEY,
    nSeguidorFK INT,
    nSeguidoFK INT,
    FOREIGN KEY (nSeguidorFK) REFERENCES Usuarios(nUsuarioID),
    FOREIGN KEY (nSeguidoFK) REFERENCES Usuarios(nUsuarioID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Archivo (
    nArchivoID INT AUTO_INCREMENT PRIMARY KEY,
    nProyectoFK INT,
    tArchivo TEXT,
    FOREIGN KEY (nProyectoFK) REFERENCES Proyecto(nProyectoID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ProyectoEtiqueta (
    nProyectoEtiquetaID INT AUTO_INCREMENT PRIMARY KEY,
    nProyectoFK INT,
    nEtiquetaFK INT,
    FOREIGN KEY (nEtiquetaFK) REFERENCES Etiqueta(nEtiquetaID),
    FOREIGN KEY (nProyectoFK) REFERENCES Proyecto(nProyectoID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Moderador (
    nModeradorID INT AUTO_INCREMENT PRIMARY KEY,
    nUsuarioFK INT,
    cRol VARCHAR(50) NOT NULL,
    dAsignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nUsuarioFK) REFERENCES Usuario(nUsuarioID) ON DELETE CASCADE
) ENGINE=InnoDB;
