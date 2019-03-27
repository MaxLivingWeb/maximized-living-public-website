NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;
document.addEventListener('readystatechange', function(){
    if (document.readyState === 'complete') {
        initFaq();
    }
});

function initFaq(){
    document.querySelectorAll('.faqTitle').forEach( faqItem => {
        faqItem.addEventListener('click', function(e){
            e.preventDefault();
            faqToggle(faqItem);
        });
    });
}

function faqToggle(faqItem){
    faqItem.parentElement.classList.toggle('active');
}
