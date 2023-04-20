<?php

include_once("connexion.inc.php");
include_once("variables.php");

function liste_option_personne($ActeurRealisateur){
    $personne = "";
    foreach($ActeurRealisateur as $ligne){
        $personne .= "\n<option value = ".$ligne['id_personne'].'>'.$ligne['prenom']." ".$ligne['nom'].'</option>';
    }
    return $personne;
}


function liste_personne($type,$liste_personne_opt){
    if ($type =="realisateur"){
        $personne = "<label> Réalisateur</label>\n<select name='realisateur'>";
    }
    else{
        $personne = "<label> Acteur </label>\n<select name='acteur'>";
    }
    $personne .= "\n<option value=''>--Please choose an option--</option>";
    $personne .= $liste_personne_opt;
    $personne .= "</select>";
    return $personne;
}

function liste_genre($genre){
    $genre_lst = "<label> Genre </label>\n<select name='genre'>";
    $genre_lst .= "\n<option value=''> ex : Action </option>";
    foreach($genre as $ligne){
        $genre_lst .= "\n<option value = ".$ligne['nomgenre'].'>'.$ligne['nomgenre'].'</option>';
    }
    $genre_lst .= "</select>";
    return $genre_lst;
}

function liste_oeuvre($filmserie){
    $filmserie_lst = "<label> Film/Série dans laquelle est cette saison/volet </label>\n<select name='appartien_oeuvre'>";
    $filmserie_lst .= "\n<option value=''> ex : Titanic </option>";
    foreach($filmserie as $ligne){
        $filmserie_lst .= "\n<option value = ".$ligne['id_oeuvre'].'>'.$ligne['titre'].'</option>';
    }
    $filmserie_lst .= "</select>";
    return $filmserie_lst;
}

function ajout_image($NomPhoto){
    $extensions = array('jpg','jpeg','gif','png');
    $file = $_FILES[$NomPhoto];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileExt = explode('.',$fileName);
    if ($NomPhoto == 'portrait'){
        $filePath = 'images/portrait/'.$fileName;
    }
    elseif($NomPhoto == 'photo'){
        $filePath = 'images/photo/'.$fileName;
    }
    
    if (!in_array($fileExt[1],$extensions)){
        echo "Erreur le fichier n'est pas une photo";
        die();
    }

    if ($file['error']){
        echo "Erreur le fichier n'as pas pu être upload";
        die();
    }
    else{
        move_uploaded_file($fileTmpName,$filePath);
    }
    return $filePath;
}

