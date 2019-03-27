let nav;

NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;

document.addEventListener('readystatechange', function(){
    if (document.readyState === 'complete') {
        initPromo();
    }
});

function initPromo(){
    nav = document.querySelector('#site-navigation');
    document.querySelectorAll('.myFutureHero').forEach( container => {
        window.addEventListener('scroll', function () {
            findHeight(container, nav);
        });
    });
}


function findHeight(container, nav){
    const promoCTA = container.querySelector('#myFutureCTA');
    if(container.clientHeight < window.pageYOffset){
        nav.classList.add('promo');
        return promoCTA.classList.add('active');
    }
    nav.classList.remove('promo');
    return promoCTA.classList.remove('active');
}
