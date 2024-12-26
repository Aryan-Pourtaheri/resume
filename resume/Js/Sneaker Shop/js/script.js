const menu = document.querySelector('.menu')
const close = document.querySelector('.close')
const nav = document.querySelector('nav')

function ha1() {
    menu.addEventListener('click', () => {
        nav.classList.add('open-nav');
        
    })
    
    close.addEventListener('click', () => {
        nav.classList.add('close-nav');
        
    })
    
}

ha1();