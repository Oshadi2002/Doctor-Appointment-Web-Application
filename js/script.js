//navbar toggling
const navbarShowBtn = document.querySelector('.navbar-show-btn');
const navbarCollapseDiv=document.querySelector('.navbar-collapse');
const navbarHideBtn = document.querySelector('.navbar-hide-btn');

navbarShowBtn.addEventListener('click',function(){
    navbarCollapseDiv.classList.add('navbar-show');
});
navbarHideBtn.addEventListener('click',function(){
    navbarCollapseDiv.classList.remove('navbar-show');
});

//charging search icon image on window resize
window.addEventListener('resize',changeSearchIcon);
function changeSearchIcon(){
    let winSize = window.matchMedia("(min-width:1200px)");
    if(winSize.matches){
        document.querySelector('.search-icon img').src ="images/search-icon.png";
    }else{
        document.querySelector('.search-icon img').src ="images/search-icon-dark.png";
    }
}
changeSearchIcon();

//transition and animation and transition
let resizeTimer;
window.addEventListener('resize',() =>{
    document.body.classList.add('resize-animation-stopper');
    clearInterval(resizeTimer);
    resizeTimer = setTimeout(() => {
        document.body.classList.remove('resize-animation-stopper');
    })
})