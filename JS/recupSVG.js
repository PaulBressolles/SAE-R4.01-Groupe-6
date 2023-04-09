const popup = document.querySelector('.overlayJS');
const affichePopupBouton = document.querySelector('.boutonAjoutImage');
const enlevePopupBouton = document.getElementsByClassName('boutonCacheRecompense');

function recuperation(lienRecompense){
  document.getElementById('afficheImage').src = lienRecompense;
  document.getElementById('lienImage').value = lienRecompense;
};

const affichePoppup = e => {
  popup.classList.toggle("visible")
}

const enlevePoppup = e => {
   popup.classList.remove("visible")
}

for(var i = 0;i < enlevePopupBouton.length;i++){
    enlevePopupBouton[i].addEventListener("click", enlevePoppup)
};
  
  affichePopupBouton.addEventListener("click", affichePoppup)
 
  