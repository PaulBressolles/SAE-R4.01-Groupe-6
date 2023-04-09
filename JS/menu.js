const boutonBarreToggler = document.querySelector(".menu")
const menuToggler = document.querySelector(".fondMenu")
;

const boutonBarre = e => {
  boutonBarreToggler.classList.toggle("open")
  menuToggler.classList.toggle("afficher")
}

boutonBarreToggler.addEventListener("click", boutonBarre)