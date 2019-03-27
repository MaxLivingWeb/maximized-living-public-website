import navigation from '@maxliving/max-living-style-guide/src/scripts/navigation';

NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;

const jsSocialShares = document.querySelectorAll('[data-share-link]');
jsSocialShares.forEach(function (anchor) {
    anchor.addEventListener('click', (e) => {
        e.preventDefault();
        const height = 400;
        const width = 600;
        const left = (window.screen.availWidth / 2) - (width / 2);
        const top = (window.screen.availHeight / 2) - (height / 2);
        window.open(
            anchor.href,
            '',
            `menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=${width},height=${height},top=${top},left=${left}`
        );
    });
});


navigation();

window.dataLayer = window.dataLayer || [];

//phone event
document.querySelectorAll('[data-phone]').forEach(phone => {

    _googWcmGet('phoneNumberAW', phone.innerHTML);

    phone.addEventListener('click', function () {
        dataLayer.push({
            'event': 'phoneClick',
            'eventAction': phone.innerHTML,
            'eventLabel': window.location.pathname
        });
    });
});

//get directions event
const directionLink = document.querySelector('[data-direction]');
if (directionLink) {
    directionLink.addEventListener('click', function () {
        dataLayer.push({
            'event': 'btnClick',
            'eventAction': 'Get Directions - ' + directionLink.getAttribute('data-clinic-name'),
            'eventLabel': window.location.pathname

        });
    });
}

const ua = window.navigator.userAgent;
const iOS = !!ua.match(/iPad/i) || !!ua.match(/iPhone/i);
const webkit = !!ua.match(/WebKit/i);
const iOSSafari = iOS && webkit && !ua.match(/CriOS/i) && !ua.match(/OPiOS/i);

const mobileMenuButton = document.querySelector('.mobileMenuButton');
if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', checkSafari, false);
}

function checkSafari() {
    const body = document.querySelector('body');
    const ua = window.navigator.userAgent;
    const iOS = !!ua.match(/iPad/i) || !!ua.match(/iPhone/i);
    const webkit = !!ua.match(/WebKit/i);
    const iOSSafari = iOS && webkit && !ua.match(/CriOS/i) && !ua.match(/OPiOS/i);
    if (iOSSafari) {
        body.classList.toggle('safariNoScroll');
    }
}
