<?php




/*#######################################################################*/
/*###############           BASE DE DONNEES               ###############*/
/*#######################################################################*/




function connexionBD(){
  try{
  $baseDeDonnee = new PDO('mysql:host=192.168.1.68;dbname=projett21;charset=utf8', 'test', 'password');
  }
  catch (Exception $erreur){
        die('Erreur : ' . $erreur->getMessage());
  }
  return $baseDeDonnee;
}




/*#######################################################################*/
/*###############             GESTION COMPTE              ###############*/
/*#######################################################################*/




function conversionHTML($tableauAConvertir){
    $tableauConverti = [];
    for($i = 0; $i < count($tableauAConvertir); ++$i) {
        $tableauConverti[$i] = htmlspecialchars($tableauAConvertir[$i]);
    }
    return $tableauConverti;
}

function connexionUtilisateur($identiteMembre){
  $baseDeDonnee = connexionBD();
  if(count($identiteMembre) > 0){
    $identiteMembreHTML = conversionHTML($identiteMembre);
    if(count($identiteMembreHTML) > 0){
      $verificationMembre = $baseDeDonnee->prepare('SELECT * FROM membre WHERE courriel = ?');
      $verificationMembre->execute(array($identiteMembre['0']));
      $baseDeDonnee = null;
      if($verificationMembre->rowCount() > 0){
        foreach ($verificationMembre as $row) {
          if(password_verify($identiteMembre['1'],$row['motDePasse'])) {
            $_SESSION['id'] = $row['idMembre'];
            $_SESSION['compteValide'] = $row['compteValide'];
            $_SESSION['coordinateur'] = $row['coordinateur'];
            return TRUE;
          } 
        }
      }else{
        return FALSE;
      }
    }else{
      return FALSE;
    }
  }else{
    return FALSE;
  }
}

function validationMotDePasse($motDePasse, $motDePasseConfirmation){
  if ($motDePasse == $motDePasseConfirmation && strlen($motDePasse) >= 5){
    return password_hash($motDePasse, PASSWORD_DEFAULT);
  }else{
    return FALSE;
  }
}

function validationCodePostal($codePostal){
  if(ctype_digit($codePostal) && strlen($codePostal) == 5){
    return TRUE;
  }else{
    return FALSE;
  }
}

function verificationPremiereInscription($membreIdentite){
  $baseDeDonnee = connexionBD();
  $recherchePresence = $baseDeDonnee->prepare('SELECT * FROM membre WHERE courriel = ?');
  $recherchePresence->execute(array($membreIdentite['7']));
  $baseDeDonnee = null;
  if($recherchePresence->rowCount() > 0){
    return FALSE;
  }else{
    return TRUE;
  }
}

function inscriptionMembre($membreIdentite){
  $baseDeDonnee = connexionBD();
  if(count($membreIdentite) > 0){
    $identiteMembreHTML = conversionHTML($membreIdentite);
    if($membreIdentite['6'] == 2){
      $role = 1;
    }else{
      $role = 0;
    }
    if(count($identiteMembreHTML) > 0){
      $ajoutUtilisateur = $baseDeDonnee->prepare('INSERT INTO membre(nom, prenom, adresse, codePostal, ville, courriel, dateNaissance, motDePasse, pro, compteValide) VALUES (?,?,?,?,?,?,?,?,?,?)');
      $ajoutUtilisateur->execute(array($identiteMembreHTML['0'], $identiteMembreHTML['1'], $identiteMembreHTML['3'], $identiteMembreHTML['4'], $identiteMembreHTML['5'], $identiteMembreHTML['7'], $identiteMembreHTML['2'], $identiteMembreHTML['8'], $role, 0));
      $baseDeDonnee = null;
      if($ajoutUtilisateur->rowCount() > 0){
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      return TRUE;
    }
  }else{
    return FALSE;
  }
}

function envoiMail($adresseMail, $nouveauMotDePasse){
  $destinataire = "someone@example.com";
  $sujet = "Mot de passe temporaire";
  $message = "Bonjour ! Voici votre nouveau mot de passe : ".$nouveauMotDePasse."<br> Vous pouvez le modifier en vous connectant dans votre espace compte.";
  $from = "sfodjojgoisfjho@gmail.com";
  $headers = "From:" . $from;
  mail($destinataire, $sujet,$message,$headers);
}




/*#######################################################################*/
/*###############             GESTION MEMBRE              ###############*/
/*#######################################################################*/




function rechercheMembreParId($idMembre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM membre WHERE idMembre = ?');
  $rechercheMembre->execute(array($idMembre));
  $baseDeDonnee = null;
  if($rechercheMembre->rowCount() > 0){
    foreach($rechercheMembre as $row){
      array_push($resultatRecherche, $row['nom'],  $row['prenom'],  $row['nom'],  $row['codePostal'],  $row['ville'],  $row['courriel'],  $row['dateNaissance']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function rechercheMembreParNom($nom){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM membre WHERE nom = ?');
  $rechercheMembre->execute(array($nom));
  $baseDeDonnee = null;
  if($rechercheMembre->rowCount() > 0){
    foreach($rechercheMembre as $row){
      array_push($resultatRecherche, $row['idMembre']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function listeEquipe($idEnfant){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheSuivi = $baseDeDonnee->prepare('SELECT * FROM suivre WHERE idEnfant = ? AND demandeValide = ?');
  $rechercheSuivi->execute(array($idEnfant, 1));
  $baseDeDonnee = null;
  if($rechercheSuivi->rowCount() > 0){
    foreach($rechercheSuivi as $row){
      array_push($resultatRecherche, $row['idMembre']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function roleEquipe($idMembre, $idEnfant){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheSuivi = $baseDeDonnee->prepare('SELECT * FROM suivre WHERE idEnfant = ? AND idMembre = ?');
  $rechercheSuivi->execute(array($idEnfant, $idMembre));
  $baseDeDonnee = null;
  if($rechercheSuivi->rowCount() > 0){
    foreach($rechercheSuivi as $row){
      return $row['role'];
    }
  }else{
    return FALSE;
  }
}

function demandeSuivi($idMembre, $idEnfant, $role){
  $baseDeDonnee = connexionBD();
  $date = date('y-m-d G:i:s');
  $sujetNotification = "demandeSuivi";
  $demandeSuivi = $baseDeDonnee->prepare('INSERT INTO suivre(idEnfant, idMembre, dateDemandeEquipe, role, demandeValide) VALUES (?,?,?,?,?)');
  if(demandeSuiviEnCours($idMembre, $idEnfant) == FALSE){
    $demandeSuivi->execute(array($idEnfant, $idMembre, $date, $role, 0));
  }
  $baseDeDonnee = null;
  if($demandeSuivi->rowCount() > 0){
      return TRUE;
  }else{
    return FALSE;
  }
}

function demandeSuiviEnCours($idMembre, $idEnfant){
  $baseDeDonnee = connexionBD();
  $demandeSuivi = $baseDeDonnee->prepare('SELECT * FROM suivre WHERE idMembre = ? AND idEnfant = ?');
  $demandeSuivi->execute(array($idMembre, $idEnfant));
  $baseDeDonnee = null;
  if($demandeSuivi->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  }
}

function idCoordinateur(){
  $baseDeDonnee = connexionBD();
  $date = date('y-m-d G:i:s');
  $coordinateur = $baseDeDonnee->prepare('SELECT * FROM membre WHERE coordinateur = ?');
  $coordinateur->execute(array(1));
  $baseDeDonnee = null;
  if($coordinateur->rowCount() > 0){
    foreach($coordinateur as $row){
      return $row['idMembre'];
    }
  }else{
    return FALSE;
  }
}

function validationSuivi($idMembre, $idEnfant){
  $baseDeDonnee = connexionBD();
  $accepterSuivi = $baseDeDonnee->prepare('UPDATE suivre SET demandeValide = ? WHERE idEnfant = ? AND idMembre = ?');
  $accepterSuivi->execute(array(1, $idEnfant, $idMembre));
  $baseDeDonnee = null;
}

function suppressionSuivi($idMembre, $idEnfant){
  $baseDeDonnee = connexionBD();
  $accepterSuivi = $baseDeDonnee->prepare('DELETE FROM suivre WHERE idEnfant = ? AND idMembre = ?');
  $accepterSuivi->execute(array($idEnfant, $idMembre));
  $baseDeDonnee = null;
}

function nombreMembreEquipe($idEnfant){
  $baseDeDonnee = connexionBD();
  $nombreMembre = $baseDeDonnee->prepare('SELECT * FROM suivre WHERE idEnfant = ?');
  $nombreMembre->execute(array($idEnfant));
  $baseDeDonnee = null;
  if($nombreMembre->rowCount() > 0){
    return $nombreMembre->rowCount();
  }else{
    return FALSE;
  }
}

function suiviAjoutCoordinateur($idMembre, $idEnfant, $role){
  $baseDeDonnee = connexionBD();
  $date = date('y-m-d G:i:s');
  $sujetNotification = "demandeSuivi";
  $demandeSuivi = $baseDeDonnee->prepare('INSERT INTO suivre(idEnfant, idMembre, dateDemandeEquipe, role, demandeValide) VALUES (?,?,?,?,?)');
  if(demandeSuiviEnCours($idMembre, $idEnfant) == FALSE){
    $demandeSuivi->execute(array($idEnfant, $idMembre, $date, $role, 1));
  }
  $baseDeDonnee = null;
  if($demandeSuivi->rowCount() > 0){
      return TRUE;
  }else{
    return FALSE;
  }

}




/*#######################################################################*/
/*###############          GESTION NOTIFICATION           ###############*/
/*#######################################################################*/




function notificationNombreMembre($idMembre){
  $baseDeDonnee = connexionBD();
  $notificationSuivi = $baseDeDonnee->prepare('SELECT * FROM notification WHERE idReceveur = ?');
  $notificationSuivi->execute(array($idMembre));
  $baseDeDonnee = null;
  if($notificationSuivi->rowCount() > 0){
    return $notificationSuivi->rowCount();
  }else{
    return FALSE;
  }
}

function notificationCoordinateur($idEmetteur, $sujet, $objetNotification, $idEnfant){
  $baseDeDonnee = connexionBD();
  $idCoordinateur = idCoordinateur();
  $notificationSuivi = $baseDeDonnee->prepare('INSERT INTO notification(idEmetteur, idReceveur, sujet, objetNotification, idEnfant) VALUES (?,?,?,?,?)');
  $notificationSuivi->execute(array($idEmetteur, $idCoordinateur, $sujet, $objetNotification, $idEnfant));
  $baseDeDonnee = null;
  if($notificationSuivi->rowCount() > 0){
     return TRUE;
  }else{
     return FALSE;
  }
}

function notificationMembre($idReceveur, $sujet, $objetNotification, $idEnfant, $reponse){
  $baseDeDonnee = connexionBD();
  $idCoordinateur = idCoordinateur();
  $notificationSuivi = $baseDeDonnee->prepare('INSERT INTO notification(idEmetteur, idReceveur, sujet, objetNotification, idEnfant, reponse) VALUES (?,?,?,?,?,?)');
  $notificationSuivi->execute(array($idCoordinateur, $idReceveur, $sujet, $objetNotification, $idEnfant, $reponse));
  $baseDeDonnee = null;
  if($notificationSuivi->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  }
}

function listeNotificationMembre($idMembre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $notificationSuivi = $baseDeDonnee->prepare('SELECT * FROM notification WHERE idReceveur = ?');
  $notificationSuivi->execute(array($idMembre));
  $baseDeDonnee = null;
  if($notificationSuivi->rowCount() > 0){
    foreach($notificationSuivi as $row){
      $resultatTableau = [];
      array_push($resultatTableau, $row['idEmetteur'], $row['sujet'], $row['objetNotification'], $row['reponse'], $row['idEnfant'], $row['idNotification']);
      array_push($resultatRecherche, $resultatTableau);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function informationNotification($idNotification){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $notificationSuivi = $baseDeDonnee->prepare('SELECT * FROM notification WHERE idNotification = ?');
  $notificationSuivi->execute(array($idNotification));
  $baseDeDonnee = null;
  if($notificationSuivi->rowCount() > 0){
    foreach($notificationSuivi as $row){
      array_push($resultatRecherche, $row['idEmetteur'], $row['sujet'], $row['objetNotification'], $row['reponse'], $row['idEnfant'], $row['idNotification']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function supprimeNotification($idNotification){
  $baseDeDonnee = connexionBD();
  $notification = $baseDeDonnee->prepare('DELETE FROM notification WHERE idNotification = ?');
  $notification->execute(array($idNotification));
  $baseDeDonnee = null;
}





/*#######################################################################*/
/*###############             GESTION ENFANT              ###############*/
/*#######################################################################*/




function ensembleEnfants(){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM enfant');
  $rechercheEnfant->execute();
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    foreach($rechercheEnfant as $row){
      array_push($resultatRecherche, $row['idEnfant']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function validationEnfantSuivi($idEnfant, $idMembre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM suivre where idEnfant = ? AND idMembre = ? AND demandeValide = ?');
  $rechercheEnfant->execute(array($idEnfant, $idMembre, 1));
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  }
}

function enfantSuivi($idMembre){
  $baseDeDonnee = connexionBD();
  $idMembre = htmlspecialchars($idMembre);
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM suivre WHERE idMembre = ? AND demandeValide = ?');
  $rechercheEnfant->execute(array($idMembre, 1));
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    foreach($rechercheEnfant as $row){
      array_push($resultatRecherche, $row['idEnfant']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function rechercheEnfant($nomEnfant){
  $baseDeDonnee = connexionBD();
  $nomEnfant = htmlspecialchars($nomEnfant);
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM enfant WHERE nom = ?');
  $rechercheEnfant->execute(array($nomEnfant));
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    foreach($rechercheEnfant as $row){
      array_push($resultatRecherche, $row['idEnfant']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function rechercheEnfantNomPrenom($nomEnfant, $prenomEnfant){
  $baseDeDonnee = connexionBD();
  $nomEnfant = htmlspecialchars($nomEnfant);
  $prenomEnfant = htmlspecialchars($prenomEnfant);
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM enfant WHERE nom = ? AND prenom = ?');
  $rechercheEnfant->execute(array($nomEnfant, $prenomEnfant));
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    foreach($rechercheEnfant as $row){
      return $row['idEnfant'];
    }
  }else{
    return FALSE;
  }
}

function rechercheEnfantId($idEnfant){
  $baseDeDonnee = connexionBD();
  $nomEnfant = htmlspecialchars($idEnfant);
  $resultatRecherche = [];
  $rechercheEnfant = $baseDeDonnee->prepare('SELECT * FROM enfant WHERE idEnfant = ?');
  $rechercheEnfant->execute(array($idEnfant));
  $baseDeDonnee = null;
  if($rechercheEnfant->rowCount() > 0){
    foreach($rechercheEnfant as $row){
      array_push($resultatRecherche, $row['idEnfant'], $row['nom'], $row['prenom'], $row['dateNaissance'], $row['lienJeton']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function rechercheEnfantSuiviParNom($nomEnfant, $idMembre, $coordinateur){
  $enfantTrouve = rechercheEnfant($nomEnfant);
  $resultatRecherche = [];
  if($enfantTrouve != FALSE){
    for($i=0; $i<count($enfantTrouve); $i++){ 
      if(validationEnfantSuivi($enfantTrouve[$i], $idMembre) == TRUE OR $coordinateur == 1){
        array_push($resultatRecherche, $enfantTrouve[$i]);
      }
    }
    return $resultatRecherche;
  }
  return FALSE; 
}

function nombreObjectifEnCours($idEnfant){
  $baseDeDonnee = connexionBD();
  $compteur = 0;
  $rechercheNombre = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE idEnfant = ? AND valide = ? AND termine = ?');
  $rechercheNombre->execute(array($idEnfant, 1, 0));
  $baseDeDonnee = null;
  if($rechercheNombre->rowCount() > 0){
    foreach($rechercheNombre as $row){
      $compteur += 1;
    }
    return $compteur;
  }else{
    return FALSE;
  }
}





/*#######################################################################*/
/*###############              GESTION JETON              ###############*/
/*#######################################################################*/




function listerTousJetons(){
  $jetonDossier = '../Image/Jeton';
  $dossier = opendir($jetonDossier);
  $resultatRecherche = [];
  while($fichier = readdir($dossier)){
    if($fichier != '.' && $fichier != '..'){
      array_push($resultatRecherche, $fichier);
    }
  }
  closedir($dossier);
  return $resultatRecherche;
}

function changerJeton($jeton, $idEnfant){
  $baseDeDonnee = connexionBD();
  $compteur = 0;
  $jetonLien = "../Image/Jeton/".$jeton;
  $modifierJeton = $baseDeDonnee->prepare('UPDATE enfant SET lienJeton = ? WHERE idEnfant = ?');
  $modifierJeton->execute(array($jetonLien, $idEnfant));
  $baseDeDonnee = null;
  if($modifierJeton->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  } 
}

function nombreJetonObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $compteur = 0;
  $nombreJeton = $baseDeDonnee->prepare('SELECT * FROM placer_jeton WHERE idObjectif = ?');
  $nombreJeton->execute(array($idObjectif));
  $baseDeDonnee = null;
  if($nombreJeton->rowCount() > 0){
    foreach($nombreJeton as $row){
      $compteur += 1;
    }
    return $compteur;
  }else{
    return FALSE;
  } 
}

function listeJetonPourObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $tousJeton = $baseDeDonnee->prepare('SELECT * FROM placer_jeton WHERE idObjectif = ?');
  $tousJeton->execute(array($idObjectif));
  $baseDeDonnee = null;
  if($tousJeton->rowCount() > 0){
    foreach($tousJeton as $row){
      $informationJeton = [];
      array_push($informationJeton, $row['dateHeure'], $row['idMembre']);
      array_push($resultatRecherche, $informationJeton);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }   
}

function ajoutJeton($idObjectif, $idMembre){
  $baseDeDonnee = connexionBD();
  $date = date('y-m-d G:i:s');
  $ajoutJeton = $baseDeDonnee->prepare('INSERT INTO placer_jeton(idObjectif, dateHeure, idMembre) VALUES (?,?,?)');
  $ajoutJeton->execute(array($idObjectif, $date, $idMembre));
  $baseDeDonnee = null;
}

function supprimeJeton($date, $idMembre, $idObjectif){
  $baseDeDonnee = connexionBD();
  $jeton = $baseDeDonnee->prepare('DELETE FROM placer_jeton WHERE idObjectif = ? AND dateHeure = ? AND idMembre = ?');
  $jeton->execute(array( $idObjectif, $date, $idMembre));
  $baseDeDonnee = null;
}

function listeJetonMembreObjectif($idObjectif, $idMembre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $tousJeton = $baseDeDonnee->prepare('SELECT * FROM placer_jeton WHERE idObjectif = ? AND idMembre = ?');
  $tousJeton->execute(array($idObjectif, $idMembre));
  $baseDeDonnee = null;
  if($tousJeton->rowCount() > 0){
    foreach($tousJeton as $row){
      array_push($resultatRecherche, $row['dateHeure']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }   
}




/*#######################################################################*/
/*###############            GESTION RECOMPENSE           ###############*/
/*#######################################################################*/




function recuperationToutesRecompenses(){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $recompense = $baseDeDonnee->prepare('SELECT * FROM recompense');
  $recompense->execute();
  $baseDeDonnee = null;
  if($recompense->rowCount() > 0){
    foreach($recompense as $row){
      array_push($resultatRecherche, $row['idRecompense']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function recompenseParId($idRecompense){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $recompense = $baseDeDonnee->prepare('SELECT * FROM recompense WHERE idRecompense = ?');
  $recompense->execute(array($idRecompense));
  $baseDeDonnee = null;
  if($recompense->rowCount() > 0){
    foreach($recompense as $row){
      array_push($resultatRecherche, $row['intitule'], $row['lienImage']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function recompenseParImage($lien){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $recompense = $baseDeDonnee->prepare('SELECT * FROM recompense WHERE lienImage = ?');
  $recompense->execute(array($lien));
  $baseDeDonnee = null;
  if($recompense->rowCount() > 0){
    foreach($recompense as $row){
      return $row['idRecompense'];
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function lierRecompenseObjectif($idObjectif, $idRecompense){
  $baseDeDonnee = connexionBD();
  $lier = $baseDeDonnee->prepare('INSERT INTO lier(idObjectif, idRecompense) VALUES (?,?)');
  if(rechercheLiaison($idObjectif) == FALSE){
    $lier->execute(array($idObjectif, $idRecompense));
  }
  $baseDeDonnee = null;
}

function rechercheLiaison($idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $lier = $baseDeDonnee->prepare('SELECT * FROM lier WHERE idObjectif = ?');
  $lier->execute(array($idObjectif));
  $baseDeDonnee = null;
  if($lier->rowCount() > 0){
    foreach($lier as $row){
      array_push($resultatRecherche, $row['idObjectif'], $row['idRecompense']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}



/*#######################################################################*/
/*###############             GESTION OBJECTIF            ###############*/
/*#######################################################################*/




function demandeCreationObjectif($idMembre, $idEnfant, $titre, $nbJeton, $lienImage, $semaine, $jour, $heure, $coordinateur){
  $baseDeDonnee = connexionBD();
  $titre = htmlspecialchars($titre);
  $lienImage = htmlspecialchars($lienImage);
  $duree = $semaine * 168 + $jour * 24 + $heure;
  $ajoutObjectif = $baseDeDonnee->prepare('INSERT INTO objectif(intitule, nbJetons, lienImage, duree, idMembre, idEnfant, travaille, termine, valide) VALUES (?,?,?,?,?,?,?,?,?)');
  $ajoutObjectif->execute(array($titre, $nbJeton, $lienImage, $duree, $idMembre, $idEnfant, 0, 0, $coordinateur));
  if($ajoutObjectif->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  } 
}

function rechercheObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE idObjectif = ?');
  $objectif->execute(array($idObjectif));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      array_push($resultatRecherche, $row['intitule'], $row['lienImage'], $row['nbJetons'], $row['duree'], $row['travaille']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function verificationDoublonObjectif($intitule, $idEnfant){
  $baseDeDonnee = connexionBD();
  $intitule = htmlspecialchars($intitule);
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE intitule = ? AND termine = ? AND idEnfant = ?');
  $objectif->execute(array($intitule, 0, $idEnfant));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    return FALSE;
  }else{
    return TRUE;
  }
}


function listerToutesImagesObjectif(){
  $objectifDossier = '../Image/Objectif';
  $dossier = opendir($objectifDossier);
  $resultatRecherche = [];
  while($fichier = readdir($dossier)){
    if($fichier != '.' && $fichier != '..'){
      array_push($resultatRecherche, $fichier);
    }
  }
  closedir($dossier);
  return $resultatRecherche;
}

function listeObjectifEnCours($idEnfant){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE valide = ? AND termine = ? AND idEnfant = ?');
  $objectif->execute(array(1, 0, $idEnfant));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      array_push($resultatRecherche, $row['idObjectif']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function annulationObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $modifierObjectif = $baseDeDonnee->prepare('UPDATE objectif SET termine = ? WHERE idObjectif = ?');
  $modifierObjectif->execute(array(1, $idObjectif));
  $baseDeDonnee = null;
  if($modifierObjectif->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  } 
}

function objectifTravaille($idObjectif){
  $baseDeDonnee = connexionBD();
  $modifierObjectif = $baseDeDonnee->prepare('UPDATE objectif SET travaille = ?, termine = ? WHERE idObjectif = ?');
  $modifierObjectif->execute(array(1, 1, $idObjectif));
  $baseDeDonnee = null;
  if($modifierObjectif->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  } 
}

function listeObjectifNonTermine(){
  $baseDeDonnee = connexionBD();
  $modifierObjectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE travaille = ?');
  $modifierObjectif->execute(array(1, $idObjectif));
  $baseDeDonnee = null;
  if($modifierObjectif->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  } 
}

function listeObjectifTermine($idEnfant){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE valide = ? AND termine = ? AND idEnfant = ?');
  $objectif->execute(array(1, 1, $idEnfant));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      array_push($resultatRecherche, $row['idObjectif']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function listeObjectifTermineUnique($idEnfant){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $titreUtilise = [];
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE valide = ? AND termine = ? AND idEnfant = ?');
  $objectif->execute(array(1, 1, $idEnfant));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      if(!in_array($row['intitule'], $titreUtilise)){
        array_push($titreUtilise, $row['intitule']);
        array_push($resultatRecherche, $row['idObjectif']);
      } 
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function listeObjectifParNom($titre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $titre = htmlspecialchars($titre);
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE intitule = ? AND termine = ?');
  $objectif->execute(array($titre, 1));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      array_push($resultatRecherche, $row['idObjectif']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function supprimeObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $jeton = $baseDeDonnee->prepare('DELETE FROM placer_jeton WHERE idObjectif = ?');
  $jeton->execute(array($idObjectif));
  $recompense = $baseDeDonnee->prepare('DELETE FROM lier WHERE idObjectif = ?');
  $recompense->execute(array($idObjectif));
  $message = $baseDeDonnee->prepare('DELETE FROM message WHERE idObjectif = ?');
  $message->execute(array($idObjectif));
  $objectif = $baseDeDonnee->prepare('DELETE FROM objectif WHERE idObjectif = ?');
  $objectif->execute(array($idObjectif));
}

function objectifNotification($idEnfant, $titre){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE valide = ? AND idEnfant = ? AND intitule = ?');
  $objectif->execute(array(0, $idEnfant, $titre));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      array_push($resultatRecherche, $row['idObjectif']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function validationObjectif($idObjectif){
  $baseDeDonnee = connexionBD();
  $validationObjectif = $baseDeDonnee->prepare('UPDATE objectif SET valide = ? WHERE idObjectif = ?');
  $validationObjectif->execute(array(1, $idObjectif));
  $baseDeDonnee = NULL;
}


function rechercheObjectifAjout($titre, $idEnfant, $idMembre){
  $baseDeDonnee = connexionBD();
  $objectif = $baseDeDonnee->prepare('SELECT * FROM objectif WHERE termine = ? AND idEnfant = ? AND intitule = ? AND idMembre = ? AND travaille = ?');
  $objectif->execute(array(0, $idEnfant, $titre, $idMembre, 0));
  $baseDeDonnee = null;
  if($objectif->rowCount() > 0){
    foreach($objectif as $row){
      return $row['idObjectif'];
    }
    
  }else{
    return FALSE;
  }
}



/*#######################################################################*/
/*###############               GESTION DATE              ###############*/
/*#######################################################################*/




function conversionDureeHeure($dureeHeure){
  $nombreSemaine = 0; 
  $nombreJour = 0;  
  $nombreHeure = 0;   
  if(intval($dureeHeure/168) >= 1 ){
    $nombreSemaine = intval($dureeHeure/168);
    $dureeRestante = $dureeHeure - ($nombreSemaine * 168);
  }else{
    $dureeRestante = $dureeHeure;
  }
  if(intval($dureeRestante/24) >= 1)  {
    $nombreJour = intval($dureeRestante/24);
    $dureeRestante = $dureeRestante - ($nombreJour * 24);
  }
  $nombreHeure = $dureeRestante;
  $resultat = array(1 => $nombreSemaine, 2 => $nombreJour, 3 => $nombreHeure);
  return $resultat;
}

function conversionDureeSeconde($dureeSeconde){
  $nombreSemaine = 0; 
  $nombreJour = 0;  
  $nombreHeure = 0;   
  $nombreMinute = 0;
  $nombreSeconde = 0;
  if(intval($dureeSeconde/604800) >= 1 ){
    $nombreSemaine = intval($dureeSeconde/604800);
    $dureeRestante = $dureeSeconde - ($nombreSemaine * 604800);
  }else{
    $dureeRestante = $dureeSeconde;
  }
  if(intval($dureeRestante/86400) >= 1)  {
    $nombreJour = intval($dureeRestante/86400);
    $dureeRestante = $dureeRestante - ($nombreJour * 86400);
  }
  if(intval($dureeRestante/3600) >= 1)  {
    $nombreHeure = intval($dureeRestante/3600);
    $dureeRestante = $dureeRestante - ($nombreHeure * 3600);
  }
  if(intval($dureeRestante/60) >= 1)  {
    $nombreMinute = intval($dureeRestante/60);
    $dureeRestante = $dureeRestante - ($nombreMinute * 60);
  }
  $nombreSeconde = $dureeRestante;
  $resultat = array(1 => $nombreSemaine, 2 => $nombreJour, 3 => $nombreHeure, 4 => $nombreMinute, 5 => $nombreSeconde);
  return $resultat;
}

// function tempRestant($datePremierJeton, $duree){
//   $dateActuelle = date_create(date("Y-m-d H:i:s"));
//   $dateDepart = date_create($datePremierJeton);
//   $calculArrive = date('Y-m-d H:i:s', strtotime($dateDepart->format("Y-m-d H:i:s").'+'.$duree .'Hour'*/));
//   $arrive = date_create($calculArrive); 
//   $interval = $arrive->format('U') - $dateActuelle->format('U');
//   if($interval > 0){
//     return conversionDureeSeconde($interval);
//   }else{
//     return FALSE;
//   }
// }

function conversionDureeTexte($tableauDuree){
  if(!empty($tableauDuree)){
    $chaineDeCaractere = "";
    if($tableauDuree[1] > 0){
      $chaineDeCaractere = $tableauDuree[1]." s";
    }
    if($tableauDuree[2] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[2]." j";
    }
    if($tableauDuree[3] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[3]." h";
    }
    if($tableauDuree[4] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[4]." m";
    }
    if($tableauDuree[5] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[5]." s";
    }
    return $chaineDeCaractere;
  }else{
    return FALSE;
  }
}

function conversionDureeFini($tableauDuree){
  if(!empty($tableauDuree)){
    $chaineDeCaractere = "";
    if($tableauDuree[1] > 0){
      $chaineDeCaractere = $tableauDuree[1]." semaines";
    }
    if($tableauDuree[2] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[2]." jours";
    }
    if($tableauDuree[3] > 0){
      $chaineDeCaractere = $chaineDeCaractere." ".$tableauDuree[3]." heures";
    }
    return $chaineDeCaractere;
  }else{
    return FALSE;
  }
}




/*#######################################################################*/
/*###############              GESTION MESSAGE            ###############*/
/*#######################################################################*/




function envoiMessage($idObjectif, $idMembre,$message){
  $date = date('y-m-d G:i:s');
  $message = htmlspecialchars($message);
  $baseDeDonnee = connexionBD();
  $ajoutMessage = $baseDeDonnee->prepare('INSERT INTO message(corps, dateHeure, idObjectif, idMembre) VALUES (?,?,?,?)');
  $ajoutMessage->execute(array($message, $date, $idObjectif, $idMembre));
  $baseDeDonnee = null;
  if($ajoutMessage->rowCount() > 0){
    return TRUE;
  }else{
    return FALSE;
  }
}

function rechercheMessage($idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $message = $baseDeDonnee->prepare('SELECT * FROM message WHERE idObjectif = ?');
  $message->execute(array($idObjectif));
  $baseDeDonnee = null;
  if($message->rowCount() > 0){
    foreach($message as $row){
      $informationMessage = [];
      array_push($informationMessage, $row['dateHeure'], $row['corps'], $row['idMembre'] );
      array_push($resultatRecherche, $informationMessage);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}

function supprimerMessage($idMessage){
  $baseDeDonnee = connexionBD();
  $message = $baseDeDonnee->prepare('DELETE FROM message WHERE idMessage = ?');
  $message->execute(array($idMessage));
  $baseDeDonnee = null;
}

function rechercheDernierMessage($idMembre, $idObjectif){
  $baseDeDonnee = connexionBD();
  $resultatRecherche = [];
  $message = $baseDeDonnee->prepare('SELECT * FROM message WHERE idMembre = ? AND idObjectif = ?');
  $message->execute(array($idMembre, $idObjectif));
  $baseDeDonnee = null;
  if($message->rowCount() > 0){
    foreach($message as $row){
      array_push($resultatRecherche, $row['idMessage']);
    }
    return $resultatRecherche;
  }else{
    return FALSE;
  }
}
?>