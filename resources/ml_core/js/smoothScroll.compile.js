document.addEventListener('readystatechange', function(){
    if (document.readyState === 'complete') {
        initSmoothScroll();
    }
});

function initSmoothScroll(){
    let scroll = SmoothScroll('a[href^="#"]', {
        speed: 1000, // Integer. How fast to complete the scroll in milliseconds
        offset: 80, // Integer or Function returning an integer. How far to offset the scrolling anchor location in pixels
        easing: 'easeInOutCubic' // Easing pattern to use
    });
}
