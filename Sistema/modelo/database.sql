CREATE DATABASE ProgramacionDocentev3;

USE ProgramacionDocentev3;

CREATE TABLE Profesor(
	idProf INT NOT NULL UNIQUE AUTO_INCREMENT,
	noEconomico INT,
	nombre VARCHAR(125),
    correo_uam VARCHAR(45),
	correo_personal VARCHAR(45),
    
    PRIMARY KEY(idProf)
);

CREATE TABLE Solicitud_profesor(
	idSolProf INT NOT NULL auto_increment,
    idProf INT,
    noGrupos INT,
    observaciones VARCHAR(555),
    
    PRIMARY KEY(idSolProf)
);

CREATE TABLE UEA(
	idUEA INT NOT NULL UNIQUE AUTO_INCREMENT,
	claveUEA INT,
	nombre VARCHAR(125),
    idArea INT,
    
    PRIMARY KEY(idUEA)
);



CREATE TABLE AreaUEA(
	idAreaUEA INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(45),
    
    PRIMARY KEY(idAreaUEA)
);

CREATE TABLE solicitud_uea(
	idSol_uea INT NOT NULL AUTO_INCREMENT,
	idProf INT,
    idUEA INT,
    prioridad INT,
    
    PRIMARY KEY(idSol_uea)
);

CREATE TABLE Horario( -- DIAS_HORAS
	idHorario INT NOT NULL AUTO_INCREMENT,
    dia VARCHAR(25),
    horaInicio TIME,
    horaFin TIME,
    
	PRIMARY KEY(idHorario)
);

CREATE TABLE Grupo(
	idGrupo INT NOT NULL AUTO_INCREMENT,
	claveGrupo VARCHAR(25),
	cupo INT,
    idUEA INT,
    
    PRIMARY KEY(idGrupo)
);

CREATE TABLE Grupo_Horario(
	idGrupoHor INT NOT NULL AUTO_INCREMENT,
	idHorario INT,
    idGrupo INT,
    
    PRIMARY KEY(idGrupoHor)
);

CREATE TABLE solicitud_horario(
	idSolHor INT NOT NULL AUTO_INCREMENT,
	idProf INT,
    idHorario INT,
    
	PRIMARY KEY(idSolHor)
); 

CREATE TABLE Programacion(
	idProg INT NOT NULL AUTO_INCREMENT,
    idGrupo INT,
    idProf INT,
    
	PRIMARY KEY(idProg)
);

CREATE TABLE Usuario(
	idUsuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(125),
    pwd VARCHAR(35),
    
	PRIMARY KEY(idUsuario)
);


-- Foreign key de solicitud_profesor
ALTER TABLE solicitud_profesor ADD CONSTRAINT FK_idProfe FOREIGN KEY (idProf) references Profesor(idProf);

-- Foreign key de UEA
ALTER TABLE UEA ADD CONSTRAINT FK_area FOREIGN KEY (idArea) references AreaUEA(idAreaUEA);

-- Foreign key de solicitud_uea
ALTER TABLE solicitud_uea ADD CONSTRAINT FK_prof FOREIGN KEY (idProf) references Profesor(idProf);
ALTER TABLE solicitud_uea ADD CONSTRAINT FK_uea FOREIGN KEY (idUEA) references UEA(idUEA);

-- Foreign key Grupo
ALTER TABLE Grupo ADD CONSTRAINT FK_ueag FOREIGN KEY (idUEA) references UEA(idUEA);

-- Foreign key Grupo_horario
ALTER TABLE Grupo_Horario ADD CONSTRAINT FK_grupo FOREIGN KEY (idGrupo) references Grupo(idGrupo);
ALTER TABLE Grupo_Horario ADD CONSTRAINT FK_diag FOREIGN KEY (idHorario) references Horario(idHorario);

-- Foreign key solicitud_horario
ALTER TABLE solicitud_horario ADD CONSTRAINT FKidProf FOREIGN KEY (idProf) references Profesor(idProf);
ALTER TABLE solicitud_horario ADD CONSTRAINT FK_diap FOREIGN KEY (idHorario) references Horario(idHorario);

-- Foreign key Programación
ALTER TABLE Programacion ADD CONSTRAINT FK_profe FOREIGN KEY (idProf) references Profesor(idProf);
ALTER TABLE Programacion ADD CONSTRAINT FK_grup FOREIGN KEY (idGrupo) references Grupo(idGrupo);

/* *********** INSERCIONES ********* */

-- USUARIO PRUEBA
INSERT INTO Usuario (nombre,pwd) VALUES
('claudia','12345_');
INSERT INTO Usuario (nombre,pwd) VALUES
('glory','20glor21'),('uriel','20urie21'),('rafa','20rafa21');

INSERT INTO Horario (dia,horaInicio,horaFin) VALUES
('Lunes','07:00:00','08:30:00'),('Martes','07:00:00','08:30:00'),('Miércoles','07:00:00','08:30:00'),
('Jueves','07:00:00','08:30:00'),('Viernes','07:00:00','08:30:00'),
('Lunes','08:30:00','10:00:00'),('Martes','08:30:00','10:00:00'),('Miércoles','08:30:00','10:00:00'),
('Jueves','08:30:00','10:00:00'),('Viernes','08:30:00','10:00:00'),
('Lunes','10:00:00','11:30:00'),('Martes','10:00:00','11:30:00'),('Miércoles','10:00:00','11:30:00'),
('Jueves','10:00:00','11:30:00'),('Viernes','10:00:00','11:30:00'),
('Lunes','11:30:00','13:00:00'),('Martes','11:30:00','13:00:00'),('Miércoles','11:30:00','13:00:00'),
('Jueves','11:30:00','13:00:00'),('Viernes','11:30:00','13:00:00'),
('Lunes','13:00:00','14:30:00'),('Martes','13:00:00','14:30:00'),('Miércoles','13:00:00','14:30:00'),
('Jueves','13:00:00','14:30:00'),('Viernes','13:00:00','14:30:00'),
('Lunes','14:30:00','16:00:00'),('Martes','14:30:00','16:00:00'),('Miércoles','14:30:00','16:00:00'),
('Jueves','14:30:00','16:00:00'),('Viernes','14:30:00','16:00:00'),
('Lunes','16:00:00','17:30:00'),('Martes','16:00:00','17:30:00'),('Miércoles','16:00:00','17:30:00'),
('Jueves','16:00:00','17:30:00'),('Viernes','16:00:00','17:30:00'),
('Lunes','17:30:00','19:00:00'),('Martes','17:30:00','19:00:00'),('Miércoles','17:30:00','19:00:00'),
('Jueves','17:30:00','19:00:00'),('Viernes','17:30:00','19:00:00'),
('Lunes','19:00:00','20:30:00'),('Martes','19:00:00','20:30:00'),('Miércoles','19:00:00','20:30:00'),
('Jueves','19:00:00','20:30:00'),('Viernes','19:00:00','20:30:00'),
('Lunes','07:00:00','10:00:00'),('Martes','07:00:00','10:00:00'),('Miércoles','07:00:00','10:00:00'),
('Jueves','07:00:00','10:00:00'),('Viernes','07:00:00','10:00:00'),
('Lunes','10:00:00','13:00:00'),('Martes','10:00:00','13:00:00'),('Miércoles','10:00:00','13:00:00'),
('Jueves','10:00:00','13:00:00'),('Viernes','10:00:00','13:00:00'),
('Lunes','13:00:00','16:00:00'),('Martes','13:00:00','16:00:00'),('Miércoles','13:00:00','16:00:00'),
('Jueves','13:00:00','16:00:00'),('Viernes','13:00:00','16:00:00'),
('Lunes','16:00:00','19:00:00'),('Martes','16:00:00','19:00:00'),('Miércoles','16:00:00','19:00:00'),
('Jueves','16:00:00','19:00:00'),('Viernes','16:00:00','19:00:00'),
('Lunes','19:00:00','22:00:00'),('Martes','19:00:00','22:00:00'),('Miércoles','19:00:00','22:00:00'),
('Jueves','19:00:00','22:00:00'),('Viernes','19:00:00','22:00:00'),
('Lunes','07:00:00','09:00:00'),('Martes','07:00:00','09:00:00'),('Miércoles','07:00:00','09:00:00'),
('Jueves','07:00:00','09:00:00'),('Viernes','07:00:00','09:00:00'),
('Lunes','09:00:00','11:00:00'),('Martes','09:00:00','11:00:00'),('Miércoles','09:00:00','11:00:00'),
('Jueves','09:00:00','11:00:00'),('Viernes','09:00:00','11:00:00'),
('Lunes','11:00:00','13:00:00'),('Martes','11:00:00','13:00:00'),('Miércoles','11:00:00','13:00:00'),
('Jueves','11:00:00','13:00:00'),('Viernes','11:00:00','13:00:00'),
('Lunes','11:30:00','13:30:00'),('Martes','11:30:00','13:30:00'),('Miércoles','11:30:00','13:30:00'),
('Jueves','11:30:00','13:30:00'),('Viernes','11:30:00','13:30:00'),
('Lunes','13:00:00','15:00:00'),('Martes','13:00:00','15:00:00'),('Miércoles','13:00:00','15:00:00'),
('Jueves','13:00:00','15:00:00'),('Viernes','13:00:00','15:00:00'),
('Lunes','15:00:00','17:00:00'),('Martes','15:00:00','17:00:00'),('Miércoles','15:00:00','17:00:00'),
('Jueves','15:00:00','17:00:00'),('Viernes','15:00:00','17:00:00'),
('Lunes','17:00:00','19:00:00'),('Martes','17:00:00','19:00:00'),('Miércoles','17:00:00','19:00:00'),
('Jueves','17:00:00','19:00:00'),('Viernes','17:00:00','19:00:00'),
('Lunes','19:00:00','21:00:00'),('Martes','19:00:00','21:00:00'),('Miércoles','19:00:00','21:00:00'),
('Jueves','19:00:00','21:00:00'),('Viernes','19:00:00','21:00:00'),
('Lunes','16:00:00','18:00:00'),('Martes','16:00:00','18:00:00'),('Miércoles','16:00:00','18:00:00'),
('Jueves','16:00:00','18:00:00'),('Viernes','16:00:00','18:00:00'),
('Lunes','15:00:00','18:00:00'),('Martes','15:00:00','18:00:00'),('Miércoles','15:00:00','18:00:00'),
('Jueves','15:00:00','18:00:00'),('Viernes','15:00:00','18:00:00'),
('Lunes','18:00:00','21:00:00'),('Martes','18:00:00','21:00:00'),('Miércoles','18:00:00','21:00:00'),
('Jueves','18:00:00','21:00:00'),('Viernes','18:00:00','21:00:00'),
('Lunes','07:00:00','08:00:00'),('Martes','07:00:00','08:00:00'),('Miércoles','07:00:00','08:00:00'),
('Jueves','07:00:00','08:00:00'),('Viernes','07:00:00','08:00:00'),
('Lunes','08:00:00','09:00:00'),('Martes','08:00:00','09:00:00'),('Miércoles','08:00:00','09:00:00'),
('Jueves','08:00:00','09:00:00'),('Viernes','08:00:00','09:00:00'),
('Lunes','08:30:00','09:30:00'),('Martes','08:30:00','09:30:00'),('Miércoles','08:30:00','09:30:00'),
('Jueves','08:30:00','09:30:00'),('Viernes','08:30:00','09:30:00'),
('Lunes','09:00:00','10:00:00'),('Martes','09:00:00','10:00:00'),('Miércoles','09:00:00','10:00:00'),
('Jueves','09:00:00','10:00:00'),('Viernes','09:00:00','10:00:00'),
('Lunes','10:00:00','11:00:00'),('Martes','10:00:00','11:00:00'),('Miércoles','10:00:00','11:00:00'),
('Jueves','10:00:00','11:00:00'),('Viernes','10:00:00','11:00:00'),
('Lunes','11:00:00','12:00:00'),('Martes','11:00:00','12:00:00'),('Miércoles','11:00:00','12:00:00'),
('Jueves','11:00:00','12:00:00'),('Viernes','11:00:00','12:00:00'),
('Lunes','11:30:00','12:30:00'),('Martes','11:30:00','12:30:00'),('Miércoles','11:30:00','12:30:00'),
('Jueves','11:30:00','12:30:00'),('Viernes','11:30:00','12:30:00'),
('Lunes','12:00:00','13:00:00'),('Martes','12:00:00','13:00:00'),('Miércoles','12:00:00','13:00:00'),
('Jueves','12:00:00','13:00:00'),('Viernes','12:00:00','13:00:00'),
('Lunes','13:00:00','14:00:00'),('Martes','13:00:00','14:00:00'),('Miércoles','13:00:00','14:00:00'),
('Jueves','13:00:00','14:00:00'),('Viernes','13:00:00','14:00:00'),
('Lunes','14:00:00','16:00:00'),('Martes','14:00:00','16:00:00'),('Miércoles','14:00:00','16:00:00'),
('Jueves','14:00:00','16:00:00'),('Viernes','14:00:00','16:00:00'),
('Lunes','08:30:00','11:30:00'),('Martes','08:30:00','11:30:00'),('Miércoles','08:30:00','11:30:00'),
('Jueves','08:30:00','11:30:00'),('Viernes','08:30:00','11:30:00'),
('Lunes','18:00:00','19:30:00'),('Martes','18:00:00','19:30:00'),('Miércoles','18:00:00','19:30:00'),
('Jueves','18:00:00','19:30:00'),('Viernes','18:00:00','19:30:00'),
('Lunes','07:00:00','09:15:00'),('Martes','07:00:00','09:15:00'),('Miércoles','07:00:00','09:15:00'),
('Jueves','07:00:00','09:15:00'),('Viernes','07:00:00','09:15:00'),
('Lunes','08:30:00','10:45:00'),('Martes','08:30:00','10:45:00'),('Miércoles','08:30:00','10:45:00'),
('Jueves','08:30:00','10:45:00'),('Viernes','08:30:00','10:45:00'),
('Lunes','11:30:00','13:45:00'),('Martes','11:30:00','13:45:00'),('Miércoles','11:30:00','13:45:00'),
('Jueves','11:30:00','13:45:00'),('Viernes','11:30:00','13:45:00'),
('Lunes','14:30:00','16:45:00'),('Martes','14:30:00','16:45:00'),('Miércoles','14:30:00','16:45:00'),
('Jueves','14:30:00','16:45:00'),('Viernes','14:30:00','16:45:00'),
('Lunes','10:00:00','12:15:00'),('Martes','10:00:00','12:15:00'),('Miércoles','10:00:00','12:15:00'),
('Jueves','10:00:00','12:15:00'),('Viernes','10:00:00','12:15:00'),
('Lunes','13:00:00','15:15:00'),('Martes','13:00:00','15:15:00'),('Miércoles','13:00:00','15:15:00'),
('Jueves','13:00:00','15:15:00'),('Viernes','13:00:00','15:15:00'),
('Lunes','16:00:00','18:15:00'),('Martes','16:00:00','18:15:00'),('Miércoles','16:00:00','18:15:00'),
('Jueves','16:00:00','18:15:00'),('Viernes','16:00:00','18:15:00'),
('Lunes','17:30:00','19:45:00'),('Martes','17:30:00','19:45:00'),('Miércoles','17:30:00','19:45:00'),
('Jueves','17:30:00','19:45:00'),('Viernes','17:30:00','19:45:00');

INSERT INTO AreaUEA (nombre) VALUES
('Matemáticas'),('Física'),('Química'),('Tronco Inter y Multidisciplinar');

-- Procedimiento para almacenar la preferencia de un docente dentro de Solicitud_horario
-- recibirá los datos del formulario docentes.php a través de insertarDatosDocentes.php 
DELIMITER //
	CREATE PROCEDURE INSERTA_SOL_PROF(_noEco int,_noGrupos int,_obs varchar(555))
	BEGIN
		DECLARE X INT;
		SELECT idProf INTO X FROM Profesor WHERE Profesor.noEconomico = _noEco;
		INSERT INTO solicitud_profesor VALUES (NULL,X,_noGrupos,_obs);
	END//
 DELIMITER ;   

DELIMITER //
	CREATE PROCEDURE INSERTA_SOL_HOR(_noEco int,_idHorario int)
	BEGIN
		DECLARE X, Y, uno INT;
        DECLARE W TIME;
        DECLARE Z VARCHAR(25);
        SELECT idProf INTO X FROM Profesor WHERE Profesor.noEconomico = _noEco;
		SELECT idHorario,horaInicio,dia INTO Y,W,Z FROM Horario WHERE idHorario = _idHorario;
        SELECT idHorario INTO uno FROM Horario WHERE horaInicio = W 
				AND horaFin = (adddate(horaInicio, INTERVAL '1' hour)) AND dia = Z;
		INSERT INTO solicitud_horario VALUES (NULL,X,Y),(NULL,X,uno);
	END//
 DELIMITER ;   
 
 DELIMITER //
	CREATE PROCEDURE INSERTA_SOL_HOR_ESPECIAL(_noEco int,_idHorarioUno int)
	BEGIN
		DECLARE X INT; -- idProf
        DECLARE Z VARCHAR(25); -- dia
        DECLARE Y TIME; -- horaInicio
        DECLARE tres, dos, mediaUno,mediaDos,mediaTres,horaUno,horaDos, cuarto INT; -- idHorarios
        SELECT idProf INTO X FROM Profesor WHERE Profesor.noEconomico = _noEco;
		SELECT horaInicio, dia INTO Y, Z FROM Horario WHERE idHorario = _idHorarioUno;
        SELECT idHorario INTO tres FROM Horario WHERE horaInicio = Y 
				AND horaFin = (adddate(horaInicio, INTERVAL '3' hour)) AND dia = Z;
		SELECT idHorario INTO dos FROM Horario WHERE horaInicio = Y 
				AND horaFin = (adddate(horaInicio, INTERVAL '2' hour)) AND dia = Z;
		SELECT idHorario INTO cuarto FROM Horario WHERE horaInicio = Y
				AND horaFin = (SELECT adddate(horaInicio, INTERVAL '2 15' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		SELECT idHorario INTO mediaUno FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '0 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '1 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		SELECT idHorario INTO mediaDos FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '0 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '2 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		SELECT idHorario INTO mediaTres FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '0 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '2' hour)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		SELECT idHorario INTO horaUno FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '1' hour)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '2' hour)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		SELECT idHorario INTO horaDos FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '1' hour)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '3' hour)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		INSERT INTO solicitud_horario VALUES 
        (null,X,tres),(null,X,dos),(null,X,mediaUno),(null,X,mediaDos),(null,X,mediaTres),
        (null,X,horaUno),(null,X,horaDos),(null,X,cuarto);
	END//
 DELIMITER ; 
-- DROP PROCEDURE INSERTA_SOL_HOR_ESPECIAL;
 
 DELIMITER //
	CREATE PROCEDURE INSERTA_SOL_HOR_ESPECIAL_DOS(_noEco int,_idHorarioUno int)
	BEGIN
		DECLARE X INT; -- idProf
        DECLARE Z VARCHAR(25); -- dia
        DECLARE Y TIME; -- horaInicio
        DECLARE mediaTres INT; -- idHorarios
        SELECT idProf INTO X FROM Profesor WHERE Profesor.noEconomico = _noEco;
		SELECT horaInicio, dia INTO Y, Z FROM Horario WHERE idHorario = _idHorarioUno;
        SELECT idHorario INTO mediaTres FROM Horario WHERE horaInicio = (SELECT adddate(horaInicio, INTERVAL '0 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND horaFin = (SELECT adddate(horaInicio, INTERVAL '3 30' hour_minute)
                FROM Horario WHERE idHorario = _idHorarioUno) AND dia=Z;
		INSERT INTO solicitud_horario VALUES (null,X,mediaTres);
	END//
 DELIMITER ; 
 

 DELIMITER //
	CREATE PROCEDURE INSERTA_SOL_UEA(_noEco int,_claveUEA int,_prioridad int)
	BEGIN
		DECLARE X INT;
        DECLARE Y INT;
        SELECT idProf INTO X FROM Profesor WHERE Profesor.noEconomico = _noEco;
		SELECT idUEA INTO Y FROM UEA WHERE claveUEA = _claveUEA;
        INSERT INTO solicitud_uea VALUES (NULL,X,Y,_prioridad);
	END//
 DELIMITER ;  

 DELIMITER //
	CREATE PROCEDURE INSERTA_GRUPO(_claveUEA int,_grupo varchar(25),_cupo int)
	BEGIN
		DECLARE X INT;
		SELECT idUEA INTO X FROM UEA WHERE UEA.claveUEA = _claveUEA;
        INSERT INTO grupo VALUES (NULL,_grupo,_cupo,X);
	END//
 DELIMITER ;  
 
 DELIMITER //
	CREATE PROCEDURE INSERTA_GRUPO_HOR(_Dia varchar(25),_horaInicio time,_horaFin time)
	BEGIN
		DECLARE X INT;
        DECLARE Z INT;
        SELECT MAX(idGrupo) INTO X FROM Grupo;
        SELECT idHorario INTO Z FROM Horario WHERE Horario.horaInicio=_horaInicio AND Horario.horaFin=_horaFin AND 
        Horario.Dia=_Dia ORDER BY horaInicio;
        INSERT INTO grupo_horario VALUES (NULL,Z,X);
	END//
 DELIMITER ;  

DELIMITER //
	CREATE PROCEDURE CREA_TABLA_HORARIO_UEA(_idUEA int)
	BEGIN
		DROP TABLE IF EXISTS horario_uea;
		CREATE TABLE horario_uea 
		SELECT Grupo.idGrupo,Grupo.claveGrupo,Horario.idHorario,Horario.dia,Horario.horaInicio,Horario.horaFin 
        FROM (((Grupo INNER JOIN UEA ON Grupo.idUEA=UEA.idUEA) 
        INNER JOIN Grupo_horario ON Grupo.idGrupo=Grupo_horario.idGrupo)
        INNER JOIN Horario ON Grupo_horario.idHorario=Horario.idHorario)
        WHERE UEA.idUEA=_idUEA;
	END//
 DELIMITER ;  
 
 DELIMITER //
	CREATE PROCEDURE RECUPERA_GRUPO_HORARIO(_idUEA int)
	BEGIN
		DECLARE X INT;
        DECLARE Y INT;
        DECLARE Z INT;
        SELECT idUEA INTO X FROM UEA WHERE claveUEA=_claveUEA;
        SELECT idGrupo,claveGrupo INTO Y,Z FROM (Grupo INNER JOIN UEA ON Grupo.idUEA=UEA.idUEA) WHERE Grupo.idUEA=X;
	END//
 DELIMITER ;  
 
 DELIMITER //
	CREATE PROCEDURE PROGRAMAR(_idGrupo int,_idProf int)
	BEGIN
		DECLARE X INT;
        DECLARE Y INT;
        SELECT idProg INTO X FROM Programacion WHERE idGrupo=_idGrupo;
        SELECT IFNULL(X,0) INTO Y;
        IF (Y = 0) THEN
			INSERT INTO Programacion (idGrupo,idProf) VALUES(_idGrupo,_idProf);
		ELSE
			UPDATE Programacion SET idProf = _idProf WHERE idGrupo = _idGrupo;
		END IF;
	END//
 DELIMITER ;  
-- DROP PROCEDURE PROGRAMAR;

DELIMITER //
	CREATE PROCEDURE VISTA_PROGRAMACION_ACTUAL()
	BEGIN
		CREATE OR REPLACE VIEW Programacion_actual AS
		SELECT programacion.idProf,grupo.idUEA,UEA.nombre,grupo.idGrupo,grupo_horario.idHorario 
		FROM ((((Programacion
			INNER JOIN grupo ON Programacion.idGrupo = grupo.idGrupo)
            INNER JOIN UEA ON grupo.idUEA = UEA.idUEA)
            INNER JOIN grupo_horario ON grupo.idGrupo = grupo_horario.idGrupo)
			INNER JOIN profesor ON programacion.idProf = profesor.idProf);
	END//
 DELIMITER ;  

--
-- Dumping data for table `profesor`
--

INSERT INTO `profesor` VALUES (1,39375,'ODRIOZOLA PREGO GERARDO MIGUEL','godriozo@azc.uam.mx',NULL),(2,29462,'CRUZ BARRIGUETE VICTOR ALBERTO','vacb@azc.uam.mx',NULL),(3,40158,'GARCIA VILLARREAL LUIS ANGEL',NULL,'lgvangel@gmail.com'),(4,23069,'MARTINEZ DELGADILLO  SERGIO ALEJANDRO','samd@azc.uam.mx',NULL),(5,38470,'CRUZ PEREGRINO FIDEL','fcruz@azc.uam.mx',NULL),(6,15898,'ADUNA ESPINOSA ENRIQUE','eae@azc.uam.mx',NULL),(7,12143,'AGUILAR PLIEGO JULIA','apj@azc.uam.mx',NULL),(8,446,'ALCANTARA MONTES SAMUEL',NULL,'sammotion@hotmail.com'),(9,5720,'ALCANTARA MORENO FELIX','feam@azc.uam.mx',NULL),(10,4828,'ALVAREZ GARCIA ARTURO','aag@azc.uam.mx',NULL),(11,6388,'AMEZCUA GOMEZ RAUL','rag@azc.uam.mx',NULL),(12,3987,'ANDREU IBARRA MARIA EUGENIA GUADALUPE','mai@azc.uam.mx',NULL),(13,24865,'ANGELES BELTRAN DEYANIRA','dab@azc.uam.mx',NULL),(14,23083,'ANZALDO MENESES ALFONSO MOISES',NULL,'ANSWALD@YMAIL.COM'),(15,6864,'ARELLANO BALDERAS SALVADOR','sab@azc.uam.mx',NULL),(16,13870,'ARELLANO PERAZA JUAN SALVADOR','jsap@azc.uam.mx',NULL),(17,4796,'ARENAS ENRIQUEZ LUIS','laam28@hotmail.com','lae@azc.uam.mx'),(18,11101,'AVILA JIMENEZ MIGUEL','miaj@azc.uam.mx',NULL),(19,20427,'BAEZ JUAREZ MARIA GABRIELA','gbaez@azc.uam.mx',NULL),(20,657,'BARCELO QUINTAL ICELA DAGMAR',NULL,'ibarceloq@gmail.com'),(21,16966,'BARRON ROMERO CARLOS','cbarron@azc.uam.mx',NULL),(22,11294,'BASTIEN MONTOYA GUSTAVO MAURICIO','mbastien@azc.uam.mx',NULL),(23,20889,'BASURTO URIBE EDUARDO','ebasurto@azc.uam.mx',NULL),(24,6865,'BECERRIL ESPINOSA JOSE VENTURA','jvbe@azc.uam.mx',NULL),(25,2346,'BECERRIL HERNANDEZ HUGO SERGIO',NULL,'hugosergiobecerril@gmail.com'),(26,10996,'BENITEZ MARQUEZ ELIA','ebmarquez@azc.uam.mx',NULL),(27,21735,'CARDOSO CORTES JOSE LUIS','jlcc@azc.uam.mx',NULL),(28,4684,'CASTAÑEDA BRIONES MARIA TERESA','tcb@azc.uam.mx',NULL),(29,16120,'CASTRO LOPEZ FIDEL',NULL,'fidelcastrotese@hotmail.com'),(30,475,'CERVANTES CUEVAS HUMBERTO','hcc@azc.uam.mx',NULL),(31,25076,'CHAVEZ LOMELI LAURA ELENA','lelc@azc.uam.mx',NULL),(32,14721,'CHAVEZ MARTINEZ MARGARITA','cmm@azc.uam.mx',NULL),(33,15307,'CID REBORIDO ALICIA',NULL,'aliciacid@yahoo.com.mx'),(34,8156,'CORONA CORONA GULMARO','ccg@azc.uam.mx',NULL),(35,12583,'COXTINICA AGUILAR LUCIA',NULL,'lsa12583@hotmail.com'),(36,13413,'CRUZ COLIN MARIA DEL ROCIO','ccmr@azc.uam.mx',NULL),(37,17755,'CRUZ GALINDO HILARION SIMON','hscg@azc.uam.mx',NULL),(38,18681,'CUETO HERNANDEZ ARTURO','arch@azc.uam.mx',NULL),(39,5438,'DE LA PORTILLA MALDONADO LEANDRO CESAR',NULL,'cesardelaportilla7@yahoo.com.mx'),(40,19834,'DIAZ LEAL GUZMAN HECTOR','hdlg@azc.uam.mx','hdiazleal@hotmail.com'),(41,13398,'ELIZARRARAZ MARTINEZ DAVID','dem@azc.uam.mx',NULL),(42,14378,'ELORZA GUERRERO MARIA EUGENIA','melorza@azc.uam.mx',NULL),(43,939,'ESPINOSA HERRERA ERNESTO JAVIER','ejeh@azc.uam.mx',NULL),(44,14720,'ESTRADA GUERRERO JOSE MA. DANIEL','jmdeg@azc.uam.mx',NULL),(45,2470,'FERNANDEZ SANCHEZ LILIA','lfs@azc.uam.mx',NULL),(46,22668,'FLORES MORENO JORGE LUIS','jflores@azc.uam.mx',NULL),(47,1313,'FLORES VALVERDE ERASMO','efv@azc.uam.mx',NULL),(48,4329,'FUENTES VILLASEÑOR RAMON','rfv@azc.uam.mx',NULL),(49,23160,'GARCIA ALBORTANTE JULISA',NULL,'julygaal@yahoo.com.mx'),(50,7295,'GARCIA CRUZ LUZ MARIA','lmgc@azc.uam.mx',NULL),(51,13487,'GARCIA MARTINEZ CESAREO','cgarcia@azc.uam.mx',NULL),(52,15509,'GARCIA MARTINEZ CIRILO','gmc@azc.uam.mx',NULL),(53,18140,'GONZALEZ CORTES MARIA DEL CARMEN','mcgc@azc.uam.mx',NULL),(54,18677,'GONZALEZ VELEZ VIRGINIA','vgv@azc.uam.mx',NULL),(55,4377,'GRABINSKY STEIDER JAIME','jags@azc.uam.mx',NULL),(56,8083,'GRANADOS SAMANIEGO JAIME ALEJANDRO PAULINO',NULL,'jalgras@yahoo.com'),(57,16930,'GUILLAUMIN ESPAÑA ELISA','ege@azc.uam.mx',NULL),(58,27034,'GUTIERREZ ARZALUZ MIRELLA','gam@azc.uam.mx',NULL),(59,10494,'GUZMAN GOMEZ MARISELA','mgg@azc.uam.mx',NULL),(60,34786,'HARO PEREZ CATALINA ESTHER','cehp@azc.uam.mx',NULL),(61,9608,'HERNANDEZ MARTINEZ LEONARDO','hml@azc.uam.mx',NULL),(62,13030,'HERNANDEZ MORALES MARIA GUADALUPE','gpe@azc.uam.mx',NULL),(63,14562,'HERNANDEZ PEREZ ISAIAS','ihp@azc.uam.mx',NULL),(64,21569,'HERNANDEZ SALDAÑA HUGO','hhs@azc.uam.mx',NULL),(65,4808,'HERRERA AGUIRRE ROGELIO',' rha@azc.uam.mx',NULL),(66,10345,'HUERTA FLORES JOSE LUIS','hfjl@azc.uam.mx',NULL),(67,19389,'KOJAKHMETOVA CEIDEJANOVA NOURLAN','nkc@azc.uam.mx',NULL),(68,21565,'KUNOLD BELLO ALEJANDRO','akb@azc.uam.mx',NULL),(69,3876,'LADINO LUNA DELFINO','dll@azc.uam.mx',NULL),(70,34214,'LOERA SERNA SANDRA','sls@azc.uam.mx',NULL),(71,24351,'LOPEZ PEREZ LIDIA','llp@azc.uam.mx',NULL),(72,19662,'LORETO GOMEZ CARMEN ESTELA','lgce@azc.uam.mx',NULL),(73,13168,'LUEVANO ENRIQUEZ JOSE RUBEN','jrle@azc.uam.mx',NULL),(74,2414,'LUNA GARCIA HECTOR MARTIN','lghm@azc.uam.mx',NULL),(75,14177,'MARTINEZ HERNANDEZ GUADALUPE','gmh@azc.uam.mx',' gmh567@gmail.com'),(76,27609,'MARTINEZ JIMENEZ ANATOLIO','amartinez@azc.uam.mx',NULL),(77,12858,'MARTINEZ MELENDEZ ANGEL','amm@azc.uam.mx',NULL),(78,940,'MAUBERT FRANCO ANA MARISELA','amf@azc.uam.mx',NULL),(79,26155,'MAY LOZANO MARCOS','mml@azc.uam.mx',NULL),(80,10906,'MEJIA HUGUET VIRGILIO JANITZIO',NULL,'vjanitzio@yahoo.com.mx'),(81,13378,'MELENDEZ LIRA MIGUEL ANGEL',NULL,'mlira@fis.cinvestav.mx'),(82,14417,'MERCHAND HERNANDEZ TERESA','mht@azc.uam.mx',NULL),(83,4037,'MOLNAR DE LA PARRA RENE','rmdp@azc.uam.mx',NULL),(84,23651,'MONROY MENDIETA MARIA MAGDALENA',NULL,'monroymendieta@yahoo.com.mx'),(85,13099,'MONROY PEREZ RAFAEL FELIPE','fmp@azc.uam.mx',NULL),(86,25837,'MORALES GUZMAN JACINTO DIONISIO','jdmg@azc.uam.mx',NULL),(87,8702,'MUGICA ALVAREZ VIOLETA','vma@azc.uam.mx',NULL),(88,10557,'MYSZKOWSKI PODKOWKA ANDRZEJ','mpa@azc.uam.mx',NULL),(89,23041,'NAVARRO FUENTES JAIME','jnfu@azc.uam.mx',NULL),(90,1895,'NEGRON SILVA GUILLERMO ENRIQUE','gns@azc.uam.mx',NULL),(91,25485,'NOREÑA FRANCO LUIS ENRIQUE','lnf@azc.uam.mx',NULL),(92,14412,'OLVERA AMADOR MARIA DE LA LUZ',NULL,'molvera@cinvestav.mx'),(93,25979,'OLVERA NERIA OSCAR',NULL,'oscolv@yahoo.com.mx'),(94,11582,'OMAÑA PULIDO MARIA JUDITH','mjop@azc.uam.mx',NULL),(95,6370,'OVANDO ZUÑIGA GERARDO ANTONIO','gaoz@azc.uam.mx',NULL),(96,14416,'PAEZ HERNANDEZ RICARDO TEODORO','phrt@azc.uam.mx',NULL),(97,4341,'PAVIA Y MILLER CARLOS GERMAN','cgpm@azc.uam.mx',NULL),(98,18248,'PEÑA GIL JOSE JUAN','jjpg@azc.uam.mx',NULL),(99,4606,'PEREYRA PADILLA PEDRO','ppereyra@azc.uam.mx',NULL),(100,12035,'PEREYRA RAMOS CARLOS','cpr@azc.uam.mx',NULL),(101,17206,'PEREZ FLORES RAFAEL','pfr@azc.uam.mx',NULL),(102,162,'PEREZ RICARDEZ ALEJANDRO','pra@azc.uam.mx',NULL),(103,4038,'PLATA PEREZ ERASMO NETZAHUALCOYOTL','ppe@azc.uam.mx',NULL),(104,11903,'PORTILLA PINEDA MARGARITA','mpp@azc.uam.mx',NULL),(105,27102,'POULAIN GARCIA ENRIQUE GABRIEL','enro@azc.uam.mx',NULL),(106,27699,'RAMIREZ QUIROS YARA','yararq@azc.uam.mx',NULL),(107,14717,'RAMIREZ ROJAS ALEJANDRO','arr@azc.uam.mx',NULL),(108,16283,'RESENDIS OCAMPO LINO FELICIANO','lfro@azc.uam.mx',NULL),(109,12407,'RIVERA VALLADARES IRENE LEONOR','ilrv@azc.uam.mx',NULL),(110,8181,'ROA LIMAS JOSE CARLOS FEDERICO','roalimas@gmail.com',NULL),(111,19560,'ROA NERI JOSE ANTONIO EDUARDO','rnjae@azc.uam.mx',NULL),(112,10382,'ROBLEDO MARTINEZ ARTURO','arm@azc.uam.mx',NULL),(113,4811,'RODRIGUEZ SANCHEZ MARIA GUADALUPE','rsmg@azc.uam.mx',NULL),(114,9434,'ROMERO MELENDEZ CUTBERTO SALVADOR','cutberto@azc.uam.mx',NULL),(115,26274,'RUBIO PONCE ALBERTO','arp@azc.uam.mx',NULL),(116,12535,'SALAS BRITO ALVARO LORENZO','asb@azc.uam.mx','alvarosalasbrito@gmail.com'),(117,14541,'SALAZAR ANTUNEZ MARINA','msalazar@azc.uam.mx',NULL),(118,4812,'SALAZAR VELASCO FRANCISCO RAMON','frsv@azc.uam.mx',NULL),(119,6539,'SERRANO DOMINGUEZ VICTOR GERARDO','','victorgserranod@gmail.com'),(120,553,'SOLIS CORREA HUGO EDUARDO',NULL,'hsoliscorrea@yahoo.com.mx'),(121,22644,'SOTO PORTAS MARIA LIDICE','masp@azc.uam.mx',NULL),(122,1312,'SOTO TELLEZ MARIA DE LA LUZ','mlst@azc.uam.mx',NULL),(123,1360,'ULIN JIMENEZ CARLOS ANTONIO','cauj@azc.uam.mx',NULL),(124,14877,'VARGAS CARLOS ALEJANDRO','cvargas@azc.uam.mx',NULL),(125,4681,'VARGAS ESTRADA MA. DEL CARMEN',NULL,'mvcarmenvargas10@gmail.com'),(126,2639,'VAZQUEZ ROJAS JORGE HECTOR',NULL,'jorgehectorvazquezrojas@yahoo.com.mx'),(127,6362,'VELAZQUEZ ARCOS JUAN MANUEL','jmva@azc.uam.mx',NULL),(128,3641,'ZUBIETA BADILLO CARLOS','czb@azc.uam.mx',NULL),(129,35464,'GONZALEZ REYES LEONARDO',NULL,'quarkkz@yahoo.com.mx'),(130,29366,'DOMINGUEZ SORIA VICTOR DANIEL','vdds@azc.uam.mx',NULL),(131,34355,'GARCIA HERNANDEZ VICTOR CUAUHTEMOC',NULL,'vc.garci@gmail.com'),(132,28447,'GOMEZ VIEYRA ARMANDO','agvte@azc.uam.mx','agvtex@gmail.com'),(133,36992,'SALAZAR PELAEZ MONICA LILIANA',NULL,'monsalazarp@gmail.com'),(134,28650,'AGUILAR ZAVOZNIK ALEJANDRO','aaz@azc.uam.mx',NULL),(135,37492,'ESPINOLA ROCHA JESUS ADRIAN','jaer@azc.uam.mx','jaer.cimat.mx@gmail.com'),(136,27821,'GAVITO TICOZZI SILVIA CLAUDIA','sgt@azc.uam.mx',NULL),(137,7487,'VALLADARES RODRIGUEZ MARIA RITA','vrmr@azc.uam.mx','mariaritauam@gmail.com'),(138,26426,'ESPINDOLA HEREDIA RODOLFO',NULL,'rodolfoespiher@yahoo.com.mx'),(139,34592,'SANTANA CRUZ ALEJANDRA','sca@azc.uam.mx',NULL),(140,38832,'SIGALOTTI DIAZ LEONARDO DI GIROLAMO',NULL,'leonardo.sigalotti@gmail.com'),(141,38956,'ESPINOZA CASTAÑEDA MARISOL','maesca@azc.uam.mx',NULL),(142,32420,'FLORES OLMEDO ENRIQUE','','enrique22809@gmail.com'),(143,3359,'FALCON HERNANDEZ NICOLAS','nfh@azc.uam.mx',NULL),(144,36082,'CHAVEZ ESQUIVEL GERARDO','','gche@xanum.uam.mx'),(145,29040,'NAVARRETE LOPEZ ALEJANDRA MONTSERRAT','','amnavalopez@gmail.com'),(146,41339,'BAISÓN OLMO ANTONIO LUIS','','baison_al@hotmail.com'),(147,42026,'VALLE HERNÁNDEZ BRENDA LIZ','blvh@azc.uam.mx','brendalizvh@atmosfera.unam.mx'),(148,31449,'BELTRÁN CONDE HIRAM ISAAC','hibc@azc.uam.mx','hbeltran75@gmail.com'),(149,42720,'SANCHEZ ELEUTERIO ALMA','','marsanele635@hotmail.com'),(150,43332,'RAMIREZ DOMINGUEZ ELSIE','','erddominguez@gmail.com'),(151,35032,'HIDALGO GONZALEZ JULIO CESAR ','','juliowero@gmail.com'),(152,31154,'JANETH ANABELLE MAGAÑA ZAPATA','jamz@azc.uam.mx',NULL),(153,11423,'ORTIZ ROMERO VARGAS MARIA ELBA','meorv@azc.uam.mx',NULL);

--
-- Dumping data for table `uea`
--

INSERT INTO `uea` VALUES (1,1112005,'Cálculo de Varias Variables',1),(2,1112043,'Cálculo Diferencial',1),(3,1112029,'Cálculo Integral',1),(4,1112041,'Cálculo Vectorial y sus Aplicaciones',1),(5,1112035,'Combinatoria',1),(6,1112013,'Complementos de Matemáticas',1),(7,1112036,'Criptografía',1),(8,1112030,'Ecuaciones Diferenciales Ordinarias',1),(9,1112032,'Introducción a las Ecuaciones Diferenciales Parciales',1),(10,1112017,'Introducción al Álgebra Lineal',1),(11,1112042,'Introducción al Cálculo',1),(12,1112034,'Lenguajes y Autómatas',1),(13,1112022,'Lógica',1),(14,1112015,'Matemáticas Aplicadas para Ingeniería',1),(15,1112033,'Matemáticas Discretas',1),(16,1112031,'Series, Transformadas y Ecuaciones Diferenciales',1),(17,1112038,'Temas Selectos de Matemáticas Discretas',1),(18,1112037,'Teoría de la Computación',1),(19,1112040,'Transformada de Laplace y Análisis de Fourier',1),(20,1112016,'Variable Compleja',1),(21,1111053,'Acústica',2),(22,1111085,'Análisis Vectorial',2),(23,1111044,'Aplicaciones del Electromagnetismo',2),(24,1111079,'Cinemática y Dinámica de Partículas',2),(25,1111013,'Dinámica Aplicada',2),(26,1111081,'Dinámica del Cuerpo Rígido',2),(27,1111043,'Electromagnetismo',2),(28,1111045,'Estática del Cuerpo Deformable',2),(29,1111077,'Física Contemporánea',2),(30,1111032,'Física del Estado Sólido',2),(31,1111048,'Física Moderna',2),(32,1111091,'Funciones Especiales',2),(33,1111057,'Imágenes',2),(34,1111090,'Inducción y Ondas Electromagnéticas',2),(35,1111059,'Ingeniería Óptica',2),(36,1111058,'Instrumentación y Equipo II',2),(37,1111083,'Introducción a la Electrostática y Magnetostática',2),(38,1111078,'Introducción a la Física',2),(39,1111094,'Laboratorio de Electricidad y Magnetismo',2),(40,1111088,'Laboratorio de Física Atómica y Molecular',2),(41,1111087,'Laboratorio de Física Moderna',2),(42,1111092,'Laboratorio de Movimiento de una Partícula',2),(43,1111069,'Laboratorio de Óptica',2),(44,1111093,'Laboratorio del Cuerpo Rígido y Oscilaciones',2),(45,1111070,'Laboratorio Interdisciplinario',2),(46,1111019,'Mecánica Estadística',2),(47,1111055,'Óptica',2),(48,1111095,'Optoelectrónica',2),(49,1111060,'Principios de Diseño y Construcción de Equipos e Instrumentos',2),(50,1111034,'Propiedades Eléctricas y Magnéticas de los Materiales',2),(51,1111054,'Sensores, Transductores y Detectores',2),(52,1111052,'Temas Selectos de Ingeniería Física I',2),(53,1111066,'Temas Selectos de Ingeniería Física II',2),(54,1111067,'Temas Selectos de Ingeniería Física III',2),(55,1113088,'Aplicaciones Industriales de Catalizadores Heterogéneos',3),(56,1113078,'Cinética y Catálisis',3),(57,1113057,'Contaminación Ambiental',3),(58,1113092,'Efecto Invernadero y Cambio Climático',3),(59,1113097,'Electroquímica',3),(60,1113099,'Equilibrio Químico',3),(61,1113084,'Estructura Atómica y Enlace Químico',3),(62,1113086,'Estructura y Propiedades de los Materiales en Ingeniería',3),(63,1113091,'Fenómenos de Superficie',3),(64,1113069,'Fisicoquímica de los Materiales',3),(65,1113096,'Fundamentos de Química Orgánica y Bioquímica',3),(66,1113090,'Introducción a la Bioquímica',3),(67,1113093,'Inventarios de Emisiones Atmosféricas',3),(68,1113079,'Laboratorio de Cinética y Catálisis',3),(69,1113087,'Laboratorio de Estructura y Propiedades de los Materiales',3),(70,1113070,'Laboratorio de Fisicoquímica de los Materiales',3),(71,1113077,'Laboratorio de Microbiología Aplicada',3),(72,1113073,'Laboratorio de Química Analítica',3),(73,1113048,'Laboratorio de Química Inorgánica I',3),(74,1113050,'Laboratorio de Química Inorgánica II',3),(75,1113019,'Laboratorio de Química Orgánica I',3),(76,1113021,'Laboratorio de Química Orgánica II',3),(77,1113085,'Laboratorio de Reacciones Químicas',3),(78,1113082,'Microbiología Aplicada',3),(79,1113095,'Química Ambiental',3),(80,1113071,'Química Física Aplicada',3),(81,1113047,'Química Inorgánica I',3),(82,1113049,'Química Inorgánica II',3),(83,1113018,'Química Orgánica I',3),(84,1113024,'Química Orgánica II',3),(85,1113023,'Química Orgánica III',3),(86,1113089,'Síntesis, Caracterización y Evaluación de Materiales Catalíticos',3),(87,1113053,'Técnicas de Medición de Composición',3),(88,1113080,'Temas Selectos de Química',3),(89,1113046,'Termodinámica',3),(90,1100038,'Introducción al Desarrollo Sustentable',4),(91,1100041,'Retos del Desarrollo Nacional',4),(92,1100096,'Taller de Expresión Oral y Escrita',4);
