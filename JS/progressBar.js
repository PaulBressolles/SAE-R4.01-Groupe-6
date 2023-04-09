document.getElementsByClassName('progressbar').width =  document.getElementById('barre').value;

var valeur = document.querySelector('.progressbar').getAttribute('value');;

document.querySelector('.progressbar').style.width = valeur +'%';