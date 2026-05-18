-- Script généré par WinDev le 19/03/2018 16:49:57
-- Tables de l'analyse campagnemangue2.wda
-- pour Oracle

-- CréatiON BOOKING.de la table ATTRIBUTION_TC
CREATE TABLE BOOKING.ATTRIBUTION_TC (
    IDATTRIBUTION_TC NUMERIC(10,0)  PRIMARY KEY ,
    IDBOOKING_CONTENEUR NUMERIC(19,0)  NOT NULL ,
    NO_TC VARCHAR2(13)  NOT NULL ,
    PLOMB1 VARCHAR2(12)  NOT NULL ,
    PLOMB2 VARCHAR2(12) ,
    idclipon VARCHAR2(7)  NOT NULL ,
    qte_appro REAL NOT NULL ,
    CODEUSER_SAISI VARCHAR2(20)  NOT NULL ,
    dateh_saisie DATE ,
    dateh_modif DATE ,
    CODEUSER_MODIF VARCHAR2(20) ,
    IDLIEU_APPRO NUMERIC(19,0)  NOT NULL );

--
-- AUTO_INCREMENT pour la table a_attribution_reefer
--

CREATE SEQUENCE booking.a_attribution_reefer_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.a_attribution_reefer_bir 
BEFORE INSERT ON booking.a_attribution_reefer 
FOR EACH ROW
BEGIN
  SELECT booking.a_attribution_reefer_seq.NEXTVAL
  INTO   :new.ida_attribution_reefer
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table A_ETAPE_BOOKING
CREATE TABLE BOOKING.A_ETAPE_BOOKING (
    CODEETAPE_SUIVI_BOOKING VARCHAR2(5)  NOT NULL ,
    IDDEMANDE_BOOKING NUMERIC(19,0)  NOT NULL ,
    dateetape DATE  NOT NULL ,
    ID_AGENT NUMERIC(10,0)  NOT NULL );



-- CréatiON BOOKING.de la table ACTIVITES
CREATE TABLE BOOKING.ACTIVITES (
    IDACTIVITES NUMERIC(10,0)  PRIMARY KEY ,
    lib_activite VARCHAR2(50) );

--
-- AUTO_INCREMENT pour la table activites
--

CREATE SEQUENCE booking.activites_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.activites_bir 
BEFORE INSERT ON booking.activites 
FOR EACH ROW
BEGIN
  SELECT booking.activites_seq.NEXTVAL
  INTO   :new.idactivites
  FROM   dual;
END;
/



-- CréatiON BOOKING.de la table BON_PHYSIQUE
CREATE TABLE BOOKING.BON_PHYSIQUE (
    IDPOSITIONNEMENT NUMERIC(19,0)  NOT NULL ,
    IDSORTIE VARCHAR2(9)  NOT NULL );



-- CréatiON BOOKING.de la table BOOKING_CONTENEURS
CREATE TABLE BOOKING.BOOKING_CONTENEUR (
    IDBOOKING_CONTENEUR NUMERIC(19,0)  PRIMARY KEY ,
    IDDEMANDE_BOOKING NUMERIC(19,0) ,
    CODETYPE_TC VARCHAR2(5),
    nb_tcs NUMERIC(3,0) DEFAULT 0,
	date_posit_souhait DATE);

--
-- AUTO_INCREMENT pour la table booking_conteneur
--

CREATE SEQUENCE booking.booking_conteneur_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.booking_conteneur_bir 
BEFORE INSERT ON booking.booking_conteneur 
FOR EACH ROW
BEGIN
  SELECT booking.booking_conteneur_seq.NEXTVAL
  INTO   :new.idbooking_conteneur
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table BOOKING_FINAL_TC
CREATE TABLE BOOKING.BOOKING_FINAL_TC (
    IDBOOKING_FINAL_TC NUMERIC(19,0)  PRIMARY KEY ,
    IDDEMANDE_BOOKING NUMERIC(19,0) ,
    no_declaratiON VARCHAR2(10) ,
    poids_brut FLOAT DEFAULT 0,
    volume FLOAT DEFAULT 0,
    nobookingfin VARCHAR2(20) ,
    plomb1 VARCHAR2(10) ,
    plomb2 VARCHAR2(10) ,
    plein_vide NUMERIC(3,0) DEFAULT 0);

--
-- AUTO_INCREMENT pour la table booking_final_tc
--

CREATE SEQUENCE booking.booking_final_tc_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.booking_final_tc_bir 
BEFORE INSERT ON booking.booking_final_tc 
FOR EACH ROW
BEGIN
  SELECT booking.booking_final_tc_seq.NEXTVAL
  INTO   :new.idbooking_final_tc
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table CHAUFFEUR
CREATE TABLE BOOKING.CHAUFFEUR (
    IDCHAUFFEUR NUMERIC(19,0)  PRIMARY KEY ,
    IDTRANSPORTEUR NUMERIC(19,0),
    nom_chauffeur VARCHAR2(50) ,
    prenom_chauffeur VARCHAR2(50) ,
    tel_mob VARCHAR2(50));

--
-- AUTO_INCREMENT pour la table chauffeur
--

CREATE SEQUENCE booking.chauffeur_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.chauffeur_bir 
BEFORE INSERT ON booking.chauffeur 
FOR EACH ROW
BEGIN
  SELECT booking.chauffeur_seq.NEXTVAL
  INTO   :new.idchauffeur
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table EMB_CONTENEUR
CREATE TABLE BOOKING.EMB_CONTENEUR (
    IDEMB_CONTENEUR NUMERIC(10,0)  PRIMARY KEY ,
    IDRETOUR_CONTENEUR NUMERIC(10,0),
    NOESCALE VARCHAR2(10),
    dateh_emb DATE );

--
-- AUTO_INCREMENT pour la table emb_conteneur
--

CREATE SEQUENCE booking.emb_conteneur_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.emb_conteneur_bir 
BEFORE INSERT ON booking.emb_conteneur 
FOR EACH ROW
BEGIN
  SELECT booking.emb_conteneur_seq.NEXTVAL
  INTO   :new.idemb_conteneur
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table EMPOTAGE_TC_POSIT
CREATE TABLE BOOKING.EMPOTAGE_TC_POSIT (
    IDEMPOTAGE_TC NUMERIC(19,0)  PRIMARY KEY ,
    datehdeb_empot DATE ,
    datehfin_empot DATE ,
    si_depassement_facture NUMERIC(3,0) DEFAULT 0,
    observation VARCHAR2(100) ,
    IDPOSITIONNEMENT NUMERIC(19,0) ,
    CODESTATION_EMPOTAGE VARCHAR2(50) );

--
-- AUTO_INCREMENT pour la table empotage_tc_posit
--

CREATE SEQUENCE booking.empotage_tc_posit_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.empotage_tc_posit_bir 
BEFORE INSERT ON booking.empotage_tc_posit 
FOR EACH ROW
BEGIN
  SELECT booking.empotage_tc_posit_seq.NEXTVAL
  INTO   :new.idempotage_tc
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table ETAPE_SUIVI_BOOKING
CREATE TABLE BOOKING.ETAPE_SUIVI_BOOKING (
    CODEETAPE_SUIVI_BOOKING VARCHAR2(5) PRIMARY KEY ,
    ORDRE_ETAPE NUMERIC(5,0) NOT NULL,
    libelle_etape VARCHAR2(50) );




-- CréatiON BOOKING.de la table FIN_POSIT_TC
CREATE TABLE BOOKING.FIN_POSIT_TC (
    IDFIN_POSIT_TC NUMERIC(19,0)  PRIMARY KEY ,
    dateh_arrive DATE ,
    compteur_arriv NUMERIC(10,0) DEFAULT 0,
    IDPOSITIONNEMENT NUMERIC(19,0) ,
    AGENT_COM VARCHAR2(20) ,
    confirm_intrant NUMERIC(3,0) DEFAULT 0,
    dateh_saisie DATE ,
    dateh_modif DATE ,
    CODEUSER_MODIF VARCHAR2(20));

--
-- AUTO_INCREMENT pour la table fin_posit_tc
--

CREATE SEQUENCE booking.fin_posit_tc_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.fin_posit_tc_bir 
BEFORE INSERT ON booking.fin_posit_tc 
FOR EACH ROW
BEGIN
  SELECT booking.fin_posit_tc_seq.NEXTVAL
  INTO   :new.idfin_posit_tc
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table FIN_RETOUR_TC
CREATE TABLE BOOKING.FIN_RETOUR_TC (
    IDFIN_RETOUR_TC NUMERIC(19,0)  PRIMARY KEY ,
    dateh_arrive_cam DATE ,
    compteur_arriv_cam NUMERIC(10,0) DEFAULT 0,
    qte_appro_arrive_cam REAL DEFAULT 0,
    qte_appro_arrive_clipon REAL DEFAULT 0,
    IDRETOUR_CONTENEUR NUMERIC(10,0) ,
    IDLIEU_APPRO_CLI_ARR NUMERIC(19,0) ,
    IDLIEU_APPRO_CAM NUMERIC(19,0) ,
    agent_trans VARCHAR2(20) ,
    dateh_saisie DATE ,
    dateh_modif DATE ,
    CODEUSER_MODIF VARCHAR2(20) );

--
-- AUTO_INCREMENT pour la table fin_retour_tc
--

CREATE SEQUENCE booking.fin_retour_tc_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.fin_retour_tc_bir 
BEFORE INSERT ON booking.fin_retour_tc 
FOR EACH ROW
BEGIN
  SELECT booking.fin_retour_tc_seq.NEXTVAL
  INTO   :new.idfin_retour_tc
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table LIEU_APPRO
CREATE TABLE BOOKING.LIEU_APPRO (
    IDLIEU_APPRO NUMERIC(19,0) PRIMARY KEY ,
    Libelle_lieu_appro VARCHAR2(50) ,
    IDLIEU VARCHAR2(5));

--
-- AUTO_INCREMENT pour la table lieu_appro
--

CREATE SEQUENCE booking.lieu_appro_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.lieu_appro_bir 
BEFORE INSERT ON booking.lieu_appro 
FOR EACH ROW
BEGIN
  SELECT booking.lieu_appro_seq.NEXTVAL
  INTO   :new.idlieu_appro
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table MOTIF_REFUS_BOOKING
CREATE TABLE BOOKING.MOTIF_REFUS_BOOKING (
    IDMOTIF_REFUS NUMERIC(19,0)  PRIMARY KEY ,
    lib_motif VARCHAR2(50) ,
    IDDEMANDE_BOOKING NUMERIC(19,0) ,
    saisie_par VARCHAR2(50) ,
    saisie_le DATE );

--
-- AUTO_INCREMENT pour la table motif_refus_booking
--

CREATE SEQUENCE booking.motif_refus_booking_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.motif_refus_booking_bir 
BEFORE INSERT ON booking.motif_refus_booking 
FOR EACH ROW
BEGIN
  SELECT booking.motif_refus_booking_seq.NEXTVAL
  INTO   :new.idmotif_refus
  FROM   dual;
END;
/





-- CréatiON BOOKING.de la table OT_POSIT_TC
CREATE TABLE BOOKING.OT_POSITIONNEMENT_TC (
    IDPOSITIONNEMENT NUMERIC(19,0)  NOT NULL ,
    IDOT VARCHAR2(7)  NOT NULL );



-- CréatiON BOOKING.de la table P_DEMANDE_BOOKING
CREATE TABLE BOOKING.P_DEMANDE_BOOKING (
    IDDEMANDE_BOOKING NUMERIC(19,0)  PRIMARY KEY ,
    no_booking VARCHAR2(20) ,
    saisie_le DATE ,
    modif_le DATE ,
    IDUTILISATEUR_CLIENT NUMERIC(19,0) DEFAULT 0,
    si_valider NUMERIC(1,0) DEFAULT 0,
    CT_NUM VARCHAR2(10) ,
    PAYEURFRET VARCHAR2(10) ,
    si_transporteur_eolis NUMERIC(1,0) DEFAULT 0,
    date_demande DATE ,
--    CODEETAPE_SUIVI_BOOKING VARCHAR2(5)  NOT NULL ,
    PRODUIT VARCHAR2(6) );

--
-- AUTO_INCREMENT pour la table p_demande_booking
--

CREATE SEQUENCE booking.p_demande_booking_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.p_demande_booking_bir 
BEFORE INSERT ON booking.p_demande_booking 
FOR EACH ROW
BEGIN
  SELECT booking.p_demande_booking_seq.NEXTVAL
  INTO   :new.iddemande_booking
  FROM   dual;
END;
/



-- CréatiON BOOKING.de la table PARAM_TC_REEFER
CREATE TABLE BOOKING.PARAM_TC_REEFER (
    IDPARAM_TC_REEFER NUMERIC(19,0)  PRIMARY KEY ,
    IDBOOKING_CONTENEUR NUMERIC(19,0) ,
    setpoint FLOAT DEFAULT 0,
    volet NUMERIC(3,0) DEFAULT 0);

--
-- AUTO_INCREMENT pour la table param_tc_reefer
--

CREATE SEQUENCE booking.param_tc_reefer_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.param_tc_reefer_bir 
BEFORE INSERT ON booking.param_tc_reefer 
FOR EACH ROW
BEGIN
  SELECT booking.param_tc_reefer_seq.NEXTVAL
  INTO   :new.idparam_tc_reefer
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table POSITIONNEMENT_TC
CREATE TABLE BOOKING.POSITIONNEMENT_TC (
    IDPOSITIONNEMENT NUMERIC(19,0)  PRIMARY KEY ,
    dateh_depart DATE ,
    IDTRANSPORTEUR NUMERIC(19,0) NOT NULL ,
    IDCHAUFFEUR NUMERIC(19,0)  NOT NULL  ,
    IDCAMION VARCHAR2(7)  NOT NULL  ,
    IDREMORQUE VARCHAR2(7) ,
    compteur_depart NUMERIC(10,0) DEFAULT 0,
    intrant NUMERIC(1,0) DEFAULT 0,
    dateh_saisie DATE ,
    qte_appro REAL DEFAULT 0,
    USER_SAISI VARCHAR2(20) ,
    USER_MODIF VARCHAR2(20) ,
    dateh_modif DATE ,
    IDACTIVITES NUMERIC(10,0) ,
    IDLIEU_DEPART VARCHAR2(5)  NOT NULL  ,
    IDLIEU_ARRIVE VARCHAR2(5)  NOT NULL  ,
    IDATTRIBUTION_TC NUMERIC(10,0)  NOT NULL  ,
    IDLIEU_APPRO NUMERIC(19,0) );

--
-- AUTO_INCREMENT pour la table positionnement_tc
--

CREATE SEQUENCE booking.positionnement_tc_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.positionnement_tc_bir 
BEFORE INSERT ON booking.positionnement_tc 
FOR EACH ROW
BEGIN
  SELECT booking.positionnement_tc_seq.NEXTVAL
  INTO   :new.idpositionnement
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table R_LIEU
-- CREATE TABLE BOOKING.R_LIEU (
--    IDLIEU NUMERIC(10,0)  PRIMARY KEY ,
--    lib_lieu VARCHAR2(50) ,
--    CODE_ZONE VARCHAR2(2) );

--
-- AUTO_INCREMENT pour la table r_lieu
--

-- CREATE SEQUENCE booking.r_lieu_seq START WITH 1;
-- CREATE OR REPLACE TRIGGER booking.r_lieu_bir 
-- BEFORE INSERT ON booking.r_lieu 
-- FOR EACH ROW
-- BEGIN
--  SELECT booking.r_lieu_seq.NEXTVAL
--  INTO   :new.idlieu
--  FROM   dual;
-- END;
-- /




-- CréatiON BOOKING.de la table RETOUR_CONTENEUR
CREATE TABLE BOOKING.RETOUR_CONTENEUR (
    IDRETOUR_CONTENEUR NUMERIC(10,0)  PRIMARY KEY ,
--    dateh_retour DATE ,
    IDREMORQUE VARCHAR2(7) ,
    IDCAMIon VARCHAR2(7) ,
    IDCHAUFFEUR NUMERIC(19,0) ,
    IDTRANSPORTEUR NUMERIC(19,0) ,
    IDPOSITIONNEMENT NUMERIC(19,0) ,
    bon_appro_cam VARCHAR2(20),
    bon_appro_clip VARCHAR2(20),
    qte_appro_cam REAL DEFAULT 0,
    qte_appro_clip REAL DEFAULT 0,
    dateh_sorti_cam DATE ,
    compteur_sorti_cam NUMERIC(10,0) DEFAULT 0,
    num_plom_tc VARCHAR2(15) ,
    dateh_saisie DATE ,
    dateh_modif DATE ,
    USER_SAISI VARCHAR2(20) ,
    USER_MODIF VARCHAR2(20) ,
    IDCLIPon VARCHAR2(7) ,
    IDLIEU_APPRO_CAM NUMERIC(19,0) ,
    IDLIEU_APPRO_CLIP NUMERIC(19,0) );

--
-- AUTO_INCREMENT pour la table retour_conteneur
--

CREATE SEQUENCE booking.retour_conteneur_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.retour_conteneur_bir 
BEFORE INSERT ON booking.retour_conteneur 
FOR EACH ROW
BEGIN
  SELECT booking.retour_conteneur_seq.NEXTVAL
  INTO   :new.idretour_conteneur
  FROM   dual;
END;
/



-- CréatiON BOOKING.de la table SORTIE_ATTRIBUTION_TC
CREATE TABLE BOOKING.SORTIE_ATTRIBUTION_TC (
    IDATTRIBUTION_TC NUMERIC(10,0)  NOT NULL ,
    IDSORTIE VARCHAR2(9)  NOT NULL );



-- CréatiON BOOKING.de la table SORTIE_RETOUR_CONTENEUR
CREATE TABLE BOOKING.SORTIE_RETOUR_CONTENEUR (
    IDRETOUR_CONTENEUR NUMERIC(10,0)  NOT NULL ,
    IDSORTIE VARCHAR2(9)  NOT NULL );



-- CréatiON BOOKING.de la table SORTIE_RETOUR_CONTENEUR
CREATE TABLE BOOKING.SORTIE_FIN_RETOUR_TC (
    IDFIN_RETOUR_TC NUMERIC(10,0)  NOT NULL ,
    IDSORTIE VARCHAR2(9)  NOT NULL );



-- CréatiON BOOKING.de la table STATION_EMPOTAGE
CREATE TABLE BOOKING.STATION_EMPOTAGE (
    CODESTATION_EMPOTAGE VARCHAR2(50)  PRIMARY KEY ,
    lib_station VARCHAR2(50) ,
    IDLIEU VARCHAR2(5));



-- CréatiON BOOKING.de la table TRANSPORTEUR
CREATE TABLE BOOKING.TRANSPORTEUR (
    IDTRANSPORTEUR NUMERIC(19,0)  PRIMARY KEY ,
    lib_transporteur VARCHAR2(50) );

--
-- AUTO_INCREMENT pour la table transporteur
--

CREATE SEQUENCE booking.transporteur_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.transporteur_bir 
BEFORE INSERT ON booking.transporteur 
FOR EACH ROW
BEGIN
  SELECT booking.transporteur_seq.NEXTVAL
  INTO   :new.idtransporteur
  FROM   dual;
END;
/




-- CréatiON BOOKING.de la table UTILISATEUR_CLIENT
-- CREATE TABLE BOOKING.USERS (
--     ID NUMERIC(19,0)  PRIMARY KEY ,
--     username VARCHAR2(50) ,
--     name varchar2(255)  NOT NULL,
--     email varchar2(255)  NOT NULL,
--     password varchar2(255)  NOT NULL,
--     remember_token varchar2(100)  DEFAULT NULL,
--     created_at DATE,
--     updated_at DATE,
--     etat_compte VARCHAR2(50) );

--
-- AUTO_INCREMENT pour la table users
--

CREATE SEQUENCE booking.users_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.users_bir 
BEFORE INSERT ON booking.users 
FOR EACH ROW
BEGIN
  SELECT booking.users_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/

--
-- Contenu de la table users
--

-- INSERT INTO BOOKING.users (username, name, email, passw, remember_token, created_at, updated_at, etat_compte) VALUES
-- ('INFO', 'TAJY', 'arsene.ta@eolis.ci', '$2y$10$/Pp7A6ypjig9yzdTZWpUVOBBKr0s3QI1mmslihjrS9fvqr0C8bcr6', 'GT6RQG93btZST9WQDSVINBcjfdEAmDkfJo7ibQvOiAqBiazYz0uysOuXod1Z', TO_DATE('2018-03-08 19:32:57', 'YYYY-MM-DD HH24:MI:SS'), TO_DATE('2018-03-08 19:32:57', 'YYYY-MM-DD HH24:MI:SS'), '');





-- CréatiON BOOKING.de la table UTILISATEUR_CLIENT_F_COMPTET
CREATE TABLE BOOKING.PAYEUR_FRET_TIER (
    CT_NUM VARCHAR2(10) NOT NULL ,
    PAYEUR_FRET VARCHAR2(10) NOT NULL );






--
-- Structure de la table password_resets
--

-- CREATE TABLE BOOKING.PASSWORD_RESETS (
--   email varchar2(255)  NOT NULL,
--   token varchar2(255)  NOT NULL,
--   created_at DATE
-- );

--
-- Contenu de la table password_resets
--

-- INSERT INTO BOOKING.PASSWORD_RESETS (email, token, created_at) VALUES
-- ('arsene.ta@eolis.ci', '$2y$10$YzZ4qpcVo50cDP/R0zDa2e7/FmdlWZSPbFg.zXPHPIlWotmSWDfW2', TO_DATE('2018-03-13 08:54:15', 'YYYY-MM-DD HH24:MI:SS') );

-- --------------------------------------------------------

--
-- Structure de la table permissions
--

-- CREATE TABLE BOOKING.PERMISSIONS (
--   id NUMERIC(10,0)  PRIMARY KEY ,
--   name varchar2(255)  NOT NULL,
--   created_at DATE,
--   updated_at DATE
-- );

--
-- AUTO_INCREMENT pour la table permissions
--

CREATE SEQUENCE booking.permissions_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.permissions_bir 
BEFORE INSERT ON booking.permissions 
FOR EACH ROW
BEGIN
  SELECT booking.permissions_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/


-- --------------------------------------------------------

--
-- Structure de la table roles
--

-- CREATE TABLE BOOKING.ROLES (
--   id NUMERIC(10,0)  PRIMARY KEY ,
--   name varchar2(255)  NOT NULL,
--   created_at DATE,
--   updated_at DATE
-- );

--
-- AUTO_INCREMENT pour la table roles
--

CREATE SEQUENCE booking.roles_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.roles_bir 
BEFORE INSERT ON booking.roles 
FOR EACH ROW
BEGIN
  SELECT booking.roles_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/


-- --------------------------------------------------------

--
-- Structure de la table role_has_permissions
--

-- CREATE TABLE BOOKING.ROLE_HAS_PERMISSIONS (
--   permission_id NUMERIC(10,0) NOT NULL,
--   role_id NUMERIC(10,0) NOT NULL
-- );

-- --------------------------------------------------------

--
-- Structure de la table user_has_permissions
--

-- CREATE TABLE BOOKING.user_has_permissions (
--   user_id NUMERIC(10,0) NOT NULL,
--   permission_id NUMERIC(10,0) NOT NULL
-- );

-- --------------------------------------------------------

--
-- Structure de la table user_has_roles
--

-- CREATE TABLE BOOKING.user_has_roles (
--   role_id NUMERIC(10,0) NOT NULL,
--   user_id NUMERIC(10,0) NOT NULL
-- );

CREATE table "BOOKING"."ATTRIBUTION_CLIPON" (
    "IDATTRIBUTION_TC" NUMBER(10,0) NOT NULL,
    "IDCLIPON"               VARCHAR2(7) NOT NULL,
    "IDLIEU_APPRO"           NUMBER(19,0) NOT NULL,
    "QTE_APPRO"              FLOAT
)
/


CREATE table "BOOKING"."ATTRIBUTION_CLIPON_RETOUR" (
    "IDRETOUR_CONTENEUR" NUMBER(10,0),
    "IDCLIPON"           VARCHAR2(7),
    "IDLIEU_APPRO_CLIP"  NUMBER(19,0),
    "BON_APPRO_CLIP"     VARCHAR2(20),
    "QTE_APPRO_CLIP"     FLOAT,
    constraint  "BOOKING"."ATTRIBUTION_CLIPON_RETOUR_PK" primary key ("IDRETOUR_CONTENEUR")
)
/



-- CréatiON BOOKING.de la table PANNES
CREATE TABLE BOOKING.PANNES (
    IDPANNE NUMERIC(19,0)  PRIMARY KEY ,
    lib_panne VARCHAR2(50) );

--
-- AUTO_INCREMENT pour la table panne
--

CREATE SEQUENCE booking.panne_seq START WITH 1;
CREATE OR REPLACE TRIGGER booking.panne_bir 
BEFORE INSERT ON booking.pannes 
FOR EACH ROW
BEGIN
  SELECT booking.panne_seq.NEXTVAL
  INTO   :new.idpanne
  FROM   dual;
END;
/



-- CréatiON BOOKING.de la table PANNES
CREATE TABLE BOOKING.PANNES_TYPENGIN (
    IDPANNE NUMERIC(19,0) NOT NULL ,
    CODETYPE VARCHAR2(4) NOT NULL 
);



-- CréatiON BOOKING.de la table INCIDENTS
CREATE TABLE BOOKING.INCIDENTS (
    ID NUMERIC(19,0)  PRIMARY KEY ,
    nobooking VARCHAR2(20),
    no_tc VARCHAR2(13),
    type_incident_id NUMERIC(19,0),
    codetype VARCHAR2(4),
    date_incident DATE NOT NULL,
    commentaire VARCHAR2(255),
    act NUMERIC(19,0), --  0 = Annuler, 1 = Recommencer
    old_data VARCHAR2 (23767) CONSTRAINT ensure_json CHECK (old_data IS JSON),
    model_id VARCHAR2(50),
    model_type VARCHAR2(255)
);

--
-- AUTO_INCREMENT pour la table incident
--

CREATE SEQUENCE booking.incident_seq START WITH 1;
DELIMITER @@
CREATE OR REPLACE TRIGGER BOOKING.incident_bir
BEFORE INSERT ON booking.incidents
FOR EACH ROW
BEGIN
  SELECT booking.incident_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END; @@
DELIMITER ; 



-- CréatiON BOOKING.de la table appro_carburants
CREATE TABLE BOOKING.appro_carburants (
    ID NUMERIC(19,0)  PRIMARY KEY ,
    idengin VARCHAR2(7) NOT NULL,
    bon_appro VARCHAR2(20),
    qte_appro REAL NOT NULL,
    date_appro DATE NOT NULL,
    idlieu_appro NUMERIC(19,0) NOT NULL,
    model_id VARCHAR2(50),
    model_type VARCHAR2(255)
);

--
-- AUTO_INCREMENT pour la table appro_carburant
--

CREATE SEQUENCE booking.appro_carburant_seq START WITH 1;
DELIMITER @@
CREATE OR REPLACE TRIGGER BOOKING.appro_carburant_bir
BEFORE INSERT ON booking.appro_carburants
FOR EACH ROW
BEGIN
  SELECT booking.appro_carburant_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END; @@
DELIMITER ; 



-- CréatiON BOOKING.de la table type_incidents
CREATE TABLE BOOKING.type_incidents (
    ID NUMERIC(19,0)  PRIMARY KEY ,
    libelle VARCHAR2(50) NOT NULL
);

--
-- AUTO_INCREMENT pour la table type_incidents
--

CREATE SEQUENCE booking.type_incident_seq START WITH 1;
DELIMITER @@
CREATE OR REPLACE TRIGGER BOOKING.type_incident_bir
BEFORE INSERT ON booking.type_incidents
FOR EACH ROW
BEGIN
  SELECT booking.type_incident_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END; @@
DELIMITER ; 








