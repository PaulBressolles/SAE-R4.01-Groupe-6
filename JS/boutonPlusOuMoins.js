/* JavaScript */
valeurDeBase = 0
valeurJeton = valeurDeBase
valeurSemaine = valeurDeBase
valeurJour = valeurDeBase
valeurHeure = valeurDeBase
document.getElementById("nombreJeton").innerHTML = valeurDeBase;
document.getElementById("nombreSemaine").innerHTML = valeurDeBase;
document.getElementById("nombreJour").innerHTML = valeurDeBase;
document.getElementById("nombreHeure").innerHTML = valeurDeBase;

function valeurJetons(valeur) {
    if (valeurJeton + valeur >= 0) {
        valeurJeton = valeurJeton + valeur
        document.getElementById("nombreJeton").innerHTML = valeurJeton;
    } 
}

function valeurSemaines(valeur) {
    if (valeurSemaine + valeur >= 0 && valeurSemaine + valeur <= 4) {
        valeurSemaine = valeurSemaine + valeur
        document.getElementById("nombreSemaine").innerHTML = valeurSemaine;
    } 
}

function valeurJours(valeur) {
    if (valeurJour + valeur >= 0 && valeurJour + valeur <= 7) {
        valeurJour = valeurJour + valeur
        document.getElementById("nombreJour").innerHTML = valeurJour;
    } 
}

function valeurHeures(valeur) {
    if (valeurHeure + valeur >= 0 && valeurHeure + valeur <= 24) {
        valeurHeure = valeurHeure + valeur
        document.getElementById("nombreHeure").innerHTML = valeurHeure;
    } 
}

function recuperationValeur(){

    // First get the value from the cronMDMtimer-span
    var nombreHeure = document.getElementById("nombreHeure").innerHTML;
    var nombreJeton = document.getElementById("nombreJeton").innerHTML;
    var nombreSemaine = document.getElementById("nombreSemaine").innerHTML;
    var nombreJour = document.getElementById("nombreJour").innerHTML;

    // Then store the extracted timerValue in a hidden form field
    document.getElementById("valeurHeureCache").value = nombreHeure;
    document.getElementById("valeurJourCache").value = nombreJour;
    document.getElementById("valeurSemaineCache").value = nombreSemaine;
    document.getElementById("valeurJetonCache").value = nombreJeton;

    // submit the form using it's ID "my-form"
    $("#formulaireHoraire").submit();
}

