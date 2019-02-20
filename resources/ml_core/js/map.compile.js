'use strict';

import Handlebars from 'handlebars/lib/handlebars';

NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;

let map;
let markers = [];
let bounds;
let focusIcon;
let generalIcon;

const intervalInt = setInterval(function() {
    if (typeof window.google === 'undefined') {
        return;
    }
    if (typeof window.google.maps === 'undefined') {
        return;
    }
    searchMap();
    clearInterval(intervalInt);
}, 100);

Handlebars.registerHelper('toUpperCase', function (str) {
    return str.toUpperCase();
});

function searchMap() {

    focusIcon = {
        url: `${THEME_PATH}/images/Icon-Pin-Big.png`,
        anchor: new google.maps.Point(34, 50)
    };
    generalIcon = {
        url: `${THEME_PATH}/images/Icon-ML-Pin.png`,
        anchor: new google.maps.Point(30, 20)
    };

    const mapCanvas = document.getElementById('map');
    if (mapCanvas) {
        searchMapLoader(mapCanvas, mapCenterLat, mapCenterLng);
        boundsInit();
    }
    if (document.querySelector('#locationDetailsSection')) {
        return detailsMapLoader(mapCanvas, mapCenterLat, mapCenterLng);
    }
    if (document.querySelector('#eventConferenceMap')) {
        return eventConferenceMapLoader(mapCanvas, mapCenterLat, mapCenterLng);
    }

    let location = document.getElementById('locationSearchForm');
    if (location) {
        autoCompleteForm({form: location});
    }

    if (document.querySelector('#locationResultTemplate')) {
        locationResultsContent(GlobalMapLocations);
        locationsCounter(GlobalMapLocations.locations);
    }

    markersInit();
}


function markersInit() {
    const locationCards = document.querySelectorAll('.locationResultCard');
    locationCards.forEach(card => {
        card.addEventListener('click', function () {
            locationCardFocus(locationCards, card);
        });
    });
    markers.forEach(marker => {
        marker.addListener('click', function () {
            markerCardFocus(marker, locationCards);
        });
    });
}

function boundsInit() {
    if (markers.length < 1) {
        return;
    }
    bounds = new google.maps.LatLngBounds();
    markers.forEach(marker => {
        bounds.extend(marker.position);
    });
    zoomInit();

    map.fitBounds(bounds);
}

function zoomInit() {
    google.maps.event.addListener(map, 'zoom_changed', function () {
        let zoomChangeBoundsListener =
            google.maps.event.addListener(map, 'bounds_changed', function (event) {
                if (this.getZoom() > 13 && this.initialZoom == true) {
                    this.setZoom(13);
                    this.initialZoom = false;
                }
                google.maps.event.removeListener(zoomChangeBoundsListener);
            });
    });
    map.initialZoom = true;

}

//populating data into handlebars
function locationResultsContent(data) {
    const source = document.getElementById('locationResultTemplate');
    const template = Handlebars.compile(source.innerHTML);
    formatData(data);
    const html = template(data);
    document.getElementById('locationResultList').innerHTML = html;
}

function unformatNumber(data){
    return data.replace(/\D/g, '');
}

function formatData(data) {
    data.locations.forEach(location => {
        if ('addresses' in location) {
            location.location_name = location.name;
            location.location_telephone = location.telephone;
            location.zip_postal_code = location.addresses[0].zip_postal_code;
            location.latitude = location.addresses[0].latitude;
            location.longitude = location.addresses[0].longitude;
            location.address_1 = location.addresses[0].address_1;
            location.city_name = location.addresses[0].city[0].name;

            location.region_code = '';
            if(location.addresses[0].city[0].region[0].abbreviation != null)
            {
                location.region_code = location.addresses[0].city[0].region[0].abbreviation.toLowerCase();
            }

            location.country_code = '';
            if(location.addresses[0].city[0].region[0].country[0].abbreviation != null)
            {
                location.country_code = location.addresses[0].city[0].region[0].country[0].abbreviation.toLowerCase();
            }

            location.location_business_hours = formatBusinessHours(location.business_hours);
        }
        location.location_telephone_href = unformatNumber(location.location_telephone);
        location.location_telephone = formatTelephone(location.location_telephone);


        //the data comes through an an object on the ajax call, so this code only runs on the ajax call
        if (typeof location.location_business_hours === "object" && !Array.isArray(location.location_business_hours) ) {
            Object.keys(location.location_business_hours).map(function(objectKey, index) {
                location.location_business_hours[objectKey] = location.location_business_hours[objectKey].replace('<br />', ' ');
            });
        }
    });
}

function formatTelephone(data){
    data = unformatNumber(data);
    if(data.length === 10){
        return data = data.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
    }
    if(data.length === 11){
        return data = data.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, "+$1 $2-$3-$4");
    }
}

function formatBusinessHours(data) {
    if (data === '') {
        return '';
    }

    data = data.replace(/&#34;/g, '"');
    data = JSON.parse(data);
    let cleanArray = [];

    // creating array of current to next days to follow
    let todayArray = [];
    let today = new Date();
    today = today.getDay();
    for (let i = 0; i <= 6; i++) {
        todayArray.push(getCurrentDayIndex(today, i));
    }

    data.forEach(day => {
        let hours = '';
        if (day[1] === 'open') {
            let count = 1;
            let hoursArray = day[2];

            for (let key in hoursArray) {
                if (count > 1) {
                    hours = hours.concat(` & ${hoursArray[key].open} - ${hoursArray[key].closed}`);
                }
                if (count <= 1) {
                    hours = `${hoursArray[key].open}  -  ${hoursArray[key].closed}`;
                }
                count++;
            }
        }

        if (day[1] === 'appointment') {
            hours = 'By Appointment Only';
        }
        if (day[1] === 'closed') {
            hours = 'Closed';
        }

        //capitalize first letter of the day
        day[0] = day[0].charAt(0).toUpperCase() + day[0].slice(1);
        let k = 0;
        //match current days to hours
        todayArray.forEach(today => {
            //when date matches ordered array position
            if (day[0] === today) {
                cleanArray[k] = hours;
                cleanArray[today] = cleanArray[k];
                delete cleanArray[k];
            }
            k++;
        });
    });
    //set current day to "Today"
    for (let key in cleanArray) {
        if (key === todayArray[0]) {
            cleanArray['Today'] = cleanArray[key];
            delete cleanArray[key];
        }
    }

    return cleanArray;
}

function getCurrentDayIndex(today, index) {
    let dayNumber = today + index;

    if (dayNumber > 7) {
        dayNumber = dayNumber - 7;
    }

    const dayName = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    return dayName[dayNumber - 1];
}

function locationsCounter(data) {
    document.querySelector('#locationCount').innerHTML = data.length;
}

// Loading google map, setting markers - Results page
function searchMapLoader(mapCanvas, centerLat, centerLng) {
    map = new google.maps.Map(mapCanvas, {
        center: {lat: centerLat, lng: centerLng},
        zoom: 13,
        mapTypeControl: false,
        gestureHandling: 'cooperative'
    });

    if (document.querySelector('#locationResultTemplate')) {
        GlobalMapLocations.locations.forEach(location => {
            setGeneralMarkers(location);
        });
    }

    map.setOptions({styles: mapCustomStyles()});
}

// Loading google map, setting markers - Details page
function detailsMapLoader(mapCanvas, centerLat, centerLng) {
    map = new google.maps.Map(mapCanvas, {
        center: {lat: centerLat, lng: centerLng},
        zoom: 15,
        mapTypeControl: false,
        gestureHandling: 'cooperative',
        draggable: false
    });

    let marker = new google.maps.Marker({
        position: {
            lat: parseFloat(centerLat),
            lng: parseFloat(centerLng)
        },
        map: map,
        icon: focusIcon
    });

    // Add the circle for this city to the map.
    var markerCircle = new google.maps.Circle({
        strokeColor: '#58BFBA;',
        strokeOpacity: 0,
        strokeWeight: 0,
        fillColor: '#58BFBA',
        fillOpacity: 0.5,
        map: map,
        center: {
            lat: parseFloat(centerLat),
            lng: parseFloat(centerLng)
        },
        radius: 300
    });

    markers.push(marker);

    map.setOptions({styles: mapCustomStyles()});
}

// Loading google map, setting markers - Event Conference page
function eventConferenceMapLoader(mapCanvas, centerLat, centerLng) {
    map = new google.maps.Map(mapCanvas, {
        center: {lat: centerLat, lng: centerLng},
        zoom: 13,
        mapTypeControl: false,
        gestureHandling: 'cooperative',
        draggable: true
    });

    let marker = new google.maps.Marker({
        position: {
            lat: parseFloat(centerLat),
            lng: parseFloat(centerLng)
        },
        map: map,
        icon: focusIcon
    });

    // Add the circle for this city to the map.
    var markerCircle = new google.maps.Circle({
        strokeColor: '#58BFBA;',
        strokeOpacity: 0,
        strokeWeight: 0,
        fillColor: '#58BFBA',
        fillOpacity: 1,
        map: map,
        center: {
            lat: parseFloat(centerLat),
            lng: parseFloat(centerLng)
        },
        radius: 24
    });

    markers.push(marker);

    map.setOptions({styles: mapCustomStyles()});
}

// Click on card to focus on marker
function locationCardFocus(locationCards, card) {
    locationCards.forEach(c => {
        if (c.classList.contains('active')) {
            c.classList.remove('active');
        }
    });

    let lat = card.querySelector('.latitude').innerHTML;
    let lng = card.querySelector('.longitude').innerHTML;
    let cardName = card.querySelector('.locationName').innerHTML;

    markers.forEach(marker => {
        let name = marker.getTitle();
        if (name === cardName) {
            setMarker(marker);
        }
    });

    card.classList.add('active');

    lng = parseFloat(lng);
    lat = parseFloat(lat);

    centerMap(lat, lng);
}

// Click on marker to focus on card
function markerCardFocus(marker, locationCards) {
    let name = marker.getTitle();
    let lat = marker.getPosition().lat();
    let lng = marker.getPosition().lng();

    setMarker(marker);
    centerMap(lat, lng);

    locationCards.forEach(card => {
        if (card.classList.contains('active')) {
            card.classList.remove('active');
        }
        let cardName = card.querySelector('.locationName').innerHTML;

        if (name === cardName) {
            card.classList.add('active');
        }
    });
}

function setMarker(marker) {
    resetMarkers();
    setFocusMarkers(marker);
}

function centerMap(lat, lng) {
    map.panTo({lat: lat, lng: lng});
}

function clearMarkers() {
    markers.forEach(marker => {
        marker.setMap(null);
        markers = [];
    });
}

function resetMarkers() {
    markers.forEach(marker => {
        marker.setIcon(generalIcon);
    });
}

function setFocusMarkers(marker) {
    marker.setIcon(focusIcon);
}

function setGeneralMarkers(data) {
    let marker = new google.maps.Marker({
        position: {
            lat: parseFloat(data.latitude),
            lng: parseFloat(data.longitude)
        },
        map: map,
        title: data.location_name,
        icon: generalIcon
    });
    markers.push(marker);
}

function mapCustomStyles() {
    const styles = [
        {
            'featureType': 'administrative',
            'elementType': 'labels.text.fill',
            'stylers': [
                {
                    'color': '#444444'
                }
            ]
        },
        {
            'featureType': 'landscape',
            'elementType': 'all',
            'stylers': [
                {
                    'color': '#f2f2f2'
                }
            ]
        },
        {
            'featureType': 'poi',
            'elementType': 'all',
            'stylers': [
                {
                    'visibility': 'off'
                }
            ]
        },
        {
            'featureType': 'poi.business',
            'elementType': 'geometry.fill',
            'stylers': [
                {
                    'visibility': 'on'
                }
            ]
        },
        {
            'featureType': 'road',
            'elementType': 'all',
            'stylers': [
                {
                    'saturation': -100
                },
                {
                    'lightness': 45
                }
            ]
        },
        {
            'featureType': 'road.highway',
            'elementType': 'all',
            'stylers': [
                {
                    'visibility': 'simplified'
                }
            ]
        },
        {
            'featureType': 'road.arterial',
            'elementType': 'labels.icon',
            'stylers': [
                {
                    'visibility': 'off'
                }
            ]
        },
        {
            'featureType': 'transit',
            'elementType': 'all',
            'stylers': [
                {
                    'visibility': 'off'
                }
            ]
        },
        {
            'featureType': 'water',
            'elementType': 'all',
            'stylers': [
                {
                    'color': '#b4d4e1'
                },
                {
                    'visibility': 'on'
                }
            ]
        }
    ];
    return styles;
}

function autoCompleteForm({
    form = requiredParam('form')
} = {}) {
    const {
        location
    } = form;

    const autocomplete = new google.maps.places.Autocomplete(location, {
        types: ['geocode'],
        componentRestrictions: { country: ['us','ca','pr']}
    });

    const autocompleteService = new google.maps.places.AutocompleteService();
    const locationInput = document.querySelector('#locationSearch');
    const locationInputIcon = locationInput.parentNode.querySelector('.locationSearchIcon');

    google.maps.event.addDomListener(locationInput, 'keydown', initLocationSearch);
    google.maps.event.addDomListener(locationInputIcon, 'click', initLocationSearch);
    locationInput.addEventListener('change', removeLabel);

    function removeLabel(){
        let label = this.parentNode.querySelector('.locationSearchLabel');
        this.value = this.value.trim();
        if(this.value === ""){
            return label.classList.remove('active');
        }
        return label.classList.add('active');
    }

    function initLocationSearch(e){
        let input = this;
        if (input !== locationInput){
            input = this.parentNode.querySelector('#locationSearch');
        }

        if (
            input.value.match(/^[a-zA-Z][0-9][a-zA-Z]/g)
            && e.keyCode !== 8
            && e.keyCode !== 46
            && input.value.length < 4
        ) {
            input.value = input.value.concat(' ');
        }
        if (e.keyCode !== 13 && e.type !== 'click') {
            return;
        }
        e.preventDefault();
        e.stopPropagation();

        let place = autocomplete.getPlace(),
            address = input.value;
        if (place != undefined && place.formatted_address == address) {
            return;
        }

        autocompleteService.getPlacePredictions({
            input: address,
            types: ['(regions)'],
            componentRestrictions: {
                country: ['us','ca','pr']
            }
        }, (predictions, status) => {
            if (status != google.maps.places.PlacesServiceStatus.OK) {
                return;
            }

            const [
                {
                    description: address
                }
            ] = predictions;

            input.value = address;

            dataLayer.push({
                'event': 'locationSearch',
                'eventAction': address,
                'eventLabel': window.location.pathname
            });

            geocodeAddressAndUpdateAutocompleteValue(address);
        });
    }

    google.maps.event.addListener(autocomplete, 'place_changed', function () {

        let place = this.getPlace();

        if (!place.address_components || !place.geometry.location || !place.types) {
            return false;
        }

        //Getting Lat and Lng
        const lat = place.geometry.location.lat();
        const lng = place.geometry.location.lng();

        //Redirect & API Endpoint
        if (document.querySelector('.locationResults') !== null) {
            //Send to api endpoint

            const hostname = window.location.hostname;
            const protocol = window.location.protocol;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `${protocol}//${hostname}/wp-json/locations/api/filter_by_radius?latitude=${lat}&longitude=${lng}`);
            xhr.send();

            xhr.onreadystatechange = function () {
                const DONE = 4; // readyState 4 means the request is done.
                const OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        let data = JSON.parse(xhr.responseText);
                        // Clearing old markers from map
                        clearMarkers();
                        // Loading new locations sidebar results
                        locationResultsContent(data);
                        // Setting locations counter
                        locationsCounter(data.locations);
                        // Setting map Markers
                        for (var key in data) {
                            data[key].forEach(location => {
                                setGeneralMarkers(location);
                            });
                        }
                        // Init marker listeners
                        markersInit();
                        //Init bounds
                        if (markers.length > 0) {
                            return boundsInit();
                        }
                        // Centering map
                        return centerMap(lat, lng);
                    }
                }
            };
        }
        const mapCanvas = document.getElementById('map');
        if (!mapCanvas) {
            return window.location.href = '?lat=' + lat + '&long=' + lng;
        }
    });

    form.addEventListener('submit', e => {
        e.preventDefault();

        const {
            target
        } = e;

    });

    function geocodeAddressAndUpdateAutocompleteValue(address) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, (res, status) => {
            if (status != 'OK') {
                return;
            }

            const [place] = res;

            autocomplete.set('place', place); //activate the 'place_changed' event
        });
    }
}

function requiredParam(name) {
    throw new Error(`${name} is a required parameter`);
}
