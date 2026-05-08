
-- 0. Creation et connexion de l'user

CREATE USER eduligne IDENTIFIED BY eduligne123;
GRANT DBA, CONNECT, RESOURCE, CREATE SESSION TO eduligne;
CONNECT eduligne / eduligne123;


-- 1. Creation des tables

CREATE TABLE ETUDIANT (id NUMBER PRIMARY KEY, nom VARCHAR2(20), prenom VARCHAR2(50), niveau_academique VARCHAR2(20), mot_de_passe VARCHAR2(60), specialite VARCHAR2(30) );

CREATE TABLE COURS (id NUMBER PRIMARY KEY, statut VARCHAR2(10), sujet VARCHAR2(20), heure_debut VARCHAR2(20), heure_fin VARCHAR2(20), date_debut DATE, formateur_id NUMBER, nbr_inscrits NUMBER, capacite_max NUMBER);

CREATE TABLE FORMATEUR (id NUMBER PRIMARY KEY, nom VARCHAR2(20), prenom VARCHAR2(50), domaine_enseignement VARCHAR2(20), mot_de_passe VARCHAR2(60), distinction VARCHAR2(20));

CREATE TABLE INSCRIPTION(id_etudiant NUMBER, id_cours NUMBER, date_inscription DATE);


-- 2. Contraintes

ALTER TABLE INSCRIPTION ADD CONSTRAINT pk_inscription PRIMARY KEY (id_etudiant, id_cours );

ALTER TABLE INSCRIPTION ADD CONSTRAINT fk_etudiant FOREIGN KEY (id_etudiant) REFERENCES ETUDIANT(id);

ALTER TABLE INSCRIPTION ADD CONSTRAINT fk_cours FOREIGN KEY (id_cours) REFERENCES COURS(id);

ALTER TABLE COURS ADD CONSTRAINT fk_formateur FOREIGN KEY (formateur_id) REFERENCES FORMATEUR(id);

ALTER TABLE COURS ADD CONSTRAINT chk_capacite CHECK (nbr_inscrits <= capacite_max);

ALTER TABLE COURS ADD CONSTRAINT chk_statut CHECK (statut IN ('Disponible', 'En cours', 'Termine', 'Annule'));


-- 3. Sequences Implementation autoIncrementation

CREATE SEQUENCE seq_etudiant START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_formateur START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_cours START WITH 1 INCREMENT BY 1;


-- 4. Triggers

CREATE OR REPLACE TRIGGER trg_etudiant_id
BEFORE INSERT ON ETUDIANT
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        :NEW.id := seq_etudiant.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_formateur_id
BEFORE INSERT ON FORMATEUR
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        :NEW.id := seq_formateur.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_cours_id
BEFORE INSERT ON COURS
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        :NEW.id := seq_cours.NEXTVAL;
    END IF;
END;
/

-- verifier que la date d'inscription ne soit pas dans le futur

CREATE OR REPLACE TRIGGER chk_date_inscription
BEFORE INSERT OR UPDATE ON INSCRIPTION
FOR EACH ROW
BEGIN
   IF :NEW.date_inscription > SYSDATE THEN
      RAISE_APPLICATION_ERROR(-20001, 'Date d''inscription ne peut pas être dans le futur.');
   END IF;
END;
/  


-- 5. Procedures
 

--construction de la procedure d'inscription securisee

CREATE OR REPLACE PROCEDURE PRC_INSCRIPTION_SECURISEE(
    p_id_etudiant IN NUMBER,
    p_id_cours    IN NUMBER
) AS
    v_nbr_inscrits  NUMBER;
    v_capacite_max  NUMBER;
BEGIN
    -- Récupérer les infos du cours
    SELECT nbr_inscrits, capacite_max
    INTO v_nbr_inscrits, v_capacite_max
    FROM COURS
    WHERE id = p_id_cours;

    -- Vérifier la capacité
    IF v_nbr_inscrits >= v_capacite_max THEN
        RAISE_APPLICATION_ERROR(-20002, 'Cours complet : capacité maximale atteinte.');
    END IF;

    -- Insérer l'inscription
    INSERT INTO INSCRIPTION (id_etudiant, id_cours, date_inscription)
    VALUES (p_id_etudiant, p_id_cours, SYSDATE);

    -- Mettre à jour le nombre d'inscrits
    UPDATE COURS
    SET nbr_inscrits = nbr_inscrits + 1
    WHERE id = p_id_cours;

    COMMIT;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RAISE_APPLICATION_ERROR(-20003, 'Cours introuvable.');
END;
/


-- Créer un étudiant
CREATE OR REPLACE PROCEDURE PRC_CREER_ETUDIANT(
    p_nom               IN VARCHAR2,
    p_prenom            IN VARCHAR2,
    p_niveau            IN VARCHAR2,
    p_mot_de_passe      IN VARCHAR2,
    p_specialite        IN VARCHAR2
) AS
BEGIN
    INSERT INTO ETUDIANT (nom, prenom, niveau_academique, mot_de_passe, specialite)
    VALUES (p_nom, p_prenom, p_niveau, p_mot_de_passe, p_specialite);
    COMMIT;
END;
/

-- Créer un formateur
CREATE OR REPLACE PROCEDURE PRC_CREER_FORMATEUR(
    p_nom               IN VARCHAR2,
    p_prenom            IN VARCHAR2,
    p_domaine           IN VARCHAR2,
    p_mot_de_passe      IN VARCHAR2,
    p_distinction       IN VARCHAR2
) AS
BEGIN
    INSERT INTO FORMATEUR (nom, prenom, domaine_enseignement, mot_de_passe, distinction)
    VALUES (p_nom, p_prenom, p_domaine, p_mot_de_passe, p_distinction);
    COMMIT;
END;
/

-- Créer un cours
CREATE OR REPLACE PROCEDURE PRC_CREER_COURS(
    p_statut        IN VARCHAR2,
    p_sujet         IN VARCHAR2,
    p_heure_debut   IN VARCHAR2,
    p_heure_fin     IN VARCHAR2,
    p_date_debut    IN DATE,
    p_formateur_id  IN NUMBER,
    p_capacite_max  IN NUMBER
) AS
BEGIN
    INSERT INTO COURS (statut, sujet, heure_debut, heure_fin, date_debut, formateur_id, nbr_inscrits, capacite_max)
    VALUES (p_statut, p_sujet, p_heure_debut, p_heure_fin, p_date_debut, p_formateur_id, 0, p_capacite_max);
    COMMIT;
END;
/

-- 6. Fonctions


CREATE OR REPLACE FUNCTION FNC_TAUX_REMPLISSAGE(
    p_id_cours IN NUMBER
) RETURN NUMBER AS
    v_nbr_inscrits NUMBER;
    v_capacite_max NUMBER;
BEGIN
    SELECT nbr_inscrits, capacite_max
    INTO v_nbr_inscrits, v_capacite_max
    FROM COURS
    WHERE id = p_id_cours;

    IF v_capacite_max = 0 THEN
        RETURN 0;
    END IF;

    RETURN ROUND((v_nbr_inscrits / v_capacite_max) * 100, 2);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN -1;
END;
/


