const nav = document.querySelector('.nav')
const menu = document.querySelector('.menu i')

function menuShow(){
    if(nav.classList.contains('open')){
        nav.classList.remove('open')
    } else{
        nav.classList.add('open')
    }
}