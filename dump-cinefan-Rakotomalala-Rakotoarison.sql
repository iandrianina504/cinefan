--
-- Drop tables
--

DROP TABLE IF EXISTS utilisateur CASCADE;
DROP TABLE IF EXISTS favoris CASCADE;
DROP TABLE IF EXISTS galerie CASCADE;
DROP TABLE IF EXISTS ActeurRealisateur CASCADE;
DROP TABLE IF EXISTS FilmSerie CASCADE;
DROP TABLE IF EXISTS realiser CASCADE;
DROP TABLE IF EXISTS jouer CASCADE;
DROP TABLE IF EXISTS genre CASCADE;
DROP TABLE IF EXISTS saisonvolet CASCADE;
DROP TABLE IF EXISTS OeuvreAppartientGenre CASCADE;
DROP TABLE IF EXISTS commente CASCADE;



CREATE TABLE utilisateur (
    pseudo varchar(25) primary key,
    mdp varchar(50) NOT NULL,
    moderateur int CONSTRAINT df_moderateur DEFAULT 0,
    email varchar(320) UNIQUE
);


CREATE TABLE ActeurRealisateur(
    id_personne serial primary key,
    nom varchar(50) NOT NULL,
    prenom varchar(50) NOT NULL,
    date_naissance date NOT NULL,
    nationalite varchar(50) NOT NULL
);


CREATE TABLE FilmSerie(
    id_oeuvre serial primary key,
    titre varchar(130) NOT NULL,
    date_sortie date NOT NULL,
    type_oeuvre varchar (6) NOT NULL,
    dure interval CONSTRAINT df_sv_dure DEFAULT '0:00',
    descriptif text CONSTRAINT df_filmserie DEFAULT 'Ce/cette film/série n''a pas encore de description sur le site.',
    idOeuvre_prec int,
    FOREIGN KEY (idOeuvre_prec) REFERENCES FilmSerie(id_oeuvre)
    ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE favoris(
    id_saisonvolet int REFERENCES saisonvolet(id_saisonvolet),
    pseudo  varchar(25) REFERENCES utilisateur(pseudo),
    primary key(id_saisonvolet, pseudo)
);


CREATE TABLE genre(
    NomGenre varchar(15) primary key
);


CREATE TABLE realiser(
    id_personne int REFERENCES ActeurRealisateur(id_personne),
    id_oeuvre int REFERENCES FilmSerie(id_oeuvre),
    primary key (id_personne, id_oeuvre)

);


CREATE TABLE saisonvolet (
    id_saisonvolet serial primary key,
    titre_SaisonVolet varchar(130) CONSTRAINT df_saisonv_titre DEFAULT 'Titre inconnu',
    date_sortie date CONSTRAINT df_sv_date DEFAULT '9999-01-01',
    dure interval CONSTRAINT df_sv_dure DEFAULT '0:00',
    id_oeuvre int,
    descriptif text CONSTRAINT df_sv_descr DEFAULT 'Description inconnue',
    FOREIGN KEY (id_oeuvre) REFERENCES FilmSerie(id_oeuvre)
    ON DELETE CASCADE ON UPDATE CASCADE
    
);


CREATE TABLE jouer(
    id_saisonvolet int REFERENCES saisonvolet(id_saisonvolet),
    id_personne int REFERENCES ActeurRealisateur(id_personne),
    id_oeuvre int REFERENCES FilmSerie(id_oeuvre),
    acteur_role varchar(50) CONSTRAINT df_joue_role DEFAULT 'Rôle inconnu',
    primary key (id_personne, id_oeuvre, id_saisonvolet),
    CONSTRAINT coupleUnique UNIQUE (id_Oeuvre,id_saisonVolet)
    
);


CREATE TABLE OeuvreAppartientGenre(
    NomGenre varchar(15) REFERENCES genre(NomGenre),
    id_oeuvre int REFERENCES FilmSerie(id_oeuvre),
    primary key (NomGenre, id_oeuvre)
);


CREATE TABLE galerie(
    id_galerie serial primary key,
    id_personne int REFERENCES ActeurRealisateur(id_personne),
    id_saisonvolet int REFERENCES saisonvolet(id_saisonvolet),
    lien varchar(2048) NOT NULL
    
);


CREATE TABLE commente(
    commentaire TEXT,
    note int,
    id_oeuvre int REFERENCES FilmSerie(id_oeuvre),
    pseudo varchar(25) REFERENCES utilisateur(pseudo),
    id_saisonvolet int REFERENCES saisonvolet(id_saisonvolet),
    primary key (id_oeuvre, pseudo, id_saisonvolet)
);
