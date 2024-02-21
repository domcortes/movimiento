const fondo = document.querySelector('.fondo')
const loginLink = document.querySelector('.login-link')
const registrarLink = document.querySelector('.registrar-link')
const btn = document.querySelector('.btn')
const iconoCerrar = document.querySelector('.icono-cerrar')

registrarLink.addEventListener("click", () => {
    fondo.classList.add('active');
})

loginLink.addEventListener("click", () => {
    fondo.classList.remove('active');
})

btn.addEventListener("click", () => {
    fondo.classList.add('active-btn');
})

iconoCerrar.addEventListener("click", () => {
    fondo.classList.remove('active-btn');
})
