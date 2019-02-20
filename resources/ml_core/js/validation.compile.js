import { Validation } from 'bunnyjs/src/Validation';
NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;
document.addEventListener('readystatechange', function(){
    if (document.readyState === 'complete') {
        initEvents();
    }
});

function initEvents(){
    document.querySelectorAll('form').forEach( form => {
        Validation.init(form, true);
    });

    listenForSubmit();
}

function listenForSubmit() {
    let forms = document.querySelectorAll('.contactFormContainer');
    forms.forEach( form =>{
        form.querySelector('.contactSubmit').addEventListener('submit', function(e) {
            e.preventDefault();
            checkValidation(form);
        });
    });
}

function checkValidation(form){
    const formName = form.querySelector('input[name="form_name"]').value;
    Validation.validateSection(form).then(result => {
        if (result === true) {
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                'event': 'formSubmission',
                'eventAction': formName,
                'eventLabel': window.location.pathname
            });
            form.submit();
        } else {
            // section invalid, result is array of invalid inputs
            Validation.focusInput(result[0]);
        }
    });
}
