CREATE TABLE Carreras (

ID VARCHAR(4) PRIMARY KEY,
carrera VARCHAR(100)

);

INSERT INTO Carreras VALUES
("ARQ",  "Arquitectura"),
("IAG",  "Ingeniería en Biosistemas Agroalimentarios"),
("IAL",  "Ingeniería en Alimentos"),
("IBT",  "Ingeniería en Biotecnología"),
("IC",   "Ingeniería Civil"),
("IDM",  "Ingeniería en Ciencia de Datos y Matemáticas"),
("IDS",  "Ingeniería en Desarrollo Sustentable"),
("IE",   "Ingeniería en Electrónica"),
("IFI",  "Ingeniería Física Industrial"),
("IID",  "Ingeniería en Innovación y Desarrollo"),
("IIS",  "Ingeniería Industrial y de Sistemas"),
("IM",   "Ingeniería Mecánica"),
("IMD",  "Ingeniería Biomédica"),
("IMT",  "Ingeniería en Mecatrónica"),
("INA",  "Ingeniería en Nanotecnología"),
("IQ",   "Ingeniería Química"),
("IRS",  "Ingeniería en Robótica y Sistemas Digitales"),
("ITC",  "Ingeniería en Tecnologías Computacionales"),
("ITD",  "Ingeniería en Transformación Digital de Negocios"),
("LAD",  "Licenciatura en Arte Digital"),
("LAE",  "Licenciatura en Estrategia y Transformación de Negocios"),
("LAF",  "Licenciatura en Finanzas"),
("LBC",  "Licenciatura en Biociencias"),
("LC",   "Licenciatura en Comunicación"),
("LCPF", "Licenciatura en Contaduría Pública y Finanzas"),
("LDE",  "Licenciatura en Emprendimiento"),
("LDI",  "Licenciatura en Diseño"),
("LDO",  "Licenciatura en Desarrollo de Talento y Cultura Organizacional"),
("LEC",  "Licenciatura en Economía"),
("LED",  "Licenciatura en Derecho"),
("LEI",  "Licenciatura en Innovación Educativa"),
("LEM",  "Licenciatura en Mercadotecnia"),
("LIN",  "Licenciatura en Negocios Internacionales"),
("LIT",  "Licenciatura en Inteligencia de Negocios"),
("LLE",  "Licenciatura en Letras Hispánicas"),
("LNB",  "Licenciatura en Nutrición y Bienestar Integral"),
("LPE",  "Licenciatura en Periodismo"),
("LPS",  "Licenciatura en Psicología Clínica y de la Salud"),
("LRI",  "Licenciatura en Relaciones Internacionales"),
("LTM",  "Licenciatura en Tecnología y Producción Musical"),
("LTP",  "Licenciatura en Gobierno y Transformación Pública"),
("LUB",  "Licenciatura en Urbanismo"),
("MC",   "Médico Cirujano"),
("MO",   "Médico Cirujano Odontólogo");

CREATE TABLE Tipos_maquina (

idType INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
tipo VARCHAR(50)

);

INSERT INTO Tipos_maquina(tipo) VALUES
("Cortadora Laser"),
("Impresora 3D"),
("Taladro");

CREATE TABLE Alumnos (

ID VARCHAR(9) NOT NULL PRIMARY KEY,
nombre VARCHAR(60),
correo VARCHAR(16),
carrera VARCHAR(4),

FOREIGN KEY (carrera) REFERENCES Carreras(ID) ON DELETE RESTRICT

);

INSERT INTO Alumnos VALUE ("Humberto Pérez Galindo", "A01732526", "A01732526@tec.mx", "ITC");

CREATE TABLE Tipos_usuario (

    id INT PRIMARY KEY,
    tipo VARCHAR(50)

);

INSERT INTO Tipos_usuario VALUES (3, "Administrador"), (2, "Administrador");

CREATE TABLE Usuarios (

    id VARCHAR(9) PRIMARY KEY,
    nombre VARCHAR(60),
    correo VARCHAR(16),
    clave VARCHAR(255),
    idType INT,

    FOREIGN KEY (idType) REFERENCES Tipos_usuario(id) ON DELETE RESTRICT

);

CREATE TABLE Maquinas (

ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
numSerie VARCHAR(100),
nombre VARCHAR(50),
tipoMaquina INT,
fechaRegistro DATE,
tiempoUso FLOAT,
estado INT,
funcionamiento INT,

FOREIGN KEY (tipoMaquina) REFERENCES Tipos_maquina(idType) ON DELETE RESTRICT

);

INSERT INTO Maquinas(numSerie, nombre, tipoMaquina, fechaRegistro, tiempoUso, estado, funcionamiento) VALUE ("156245", "Taladro", 3, "2024-12-12", 0.0, 0, 0);

CREATE TABLE Registro_uso_maquinas (

idMaquina INT,
tiempoInicio DATETIME,
tiempoFin DATETIME,

FOREIGN KEY (idMaquina) REFERENCES Maquinas(ID) ON DELETE RESTRICT

);

CREATE TABLE Reservas (

ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
idMaestro INT,
fechaInicio DATETIME,
fechaFinal DATETIME,
maquina INT,

FOREIGN KEY (idMaestro) REFERENCES Maestros(ID) ON DELETE RESTRICT,
FOREIGN KEY (maquina) REFERENCES Maquinas(ID) ON DELETE RESTRICT

);