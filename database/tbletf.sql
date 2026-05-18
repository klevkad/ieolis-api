

-- CréatiON BOOKING.de la table BOOKING_CONTENEURS
CREATE TABLE etf.suivi_index_engin (
    id NUMERIC(19,0) PRIMARY KEY,
    idengin NUMERIC(10,0),
    curdate DATE,
    prev_date_id NUMERIC(19,0) DEFAULT 0,
    cptkm NUMERIC(19,0),
    nbrtcv NUMERIC(3,0),
    nbrtcp NUMERIC(3,0),
    qtecarb NUMERIC(3,0),
    nbrhrtrav NUMERIC(2,0),
    created_at DATE NULL,
    updated_at DATE NULL,
    deleted_at DATE NULL,
    created_by NUMERIC(19,0) NULL,
    updated_by NUMERIC(19,0) NULL,
    deleted_by NUMERIC(19,0) NULL
);

--
-- AUTO_INCREMENT pour la table booking_conteneur
--

CREATE SEQUENCE etf.suivi_index_engin_seq START WITH 1;

DELIMITER @@
CREATE OR REPLACE TRIGGER etf.suivi_index_engin_bir
BEFORE INSERT ON etf.suivi_index_engin 
FOR EACH ROW
BEGIN
  SELECT etf.suivi_index_engin_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END; @@
DELIMITER ; 


ALTER TABLE etf.suivi_index_engin ADD FOREIGN KEY (idengin) REFERENCES etf.engin (idengin);
--ALTER TABLE etf.suivi_index_engin ADD FOREIGN KEY (prev_date_id) REFERENCES etf.suivi_index_engin (id);

