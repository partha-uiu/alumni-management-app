/**
 * Created by sohel on 2/19/18.
 */

function registerServiceWorker() {
    if ('serviceWorker' in navigator) {
        console.log("Will the service worker register?");
        navigator.serviceWorker.register('service-worker.js')
            .then(function(reg){
                console.log("Service worker registered");
            }).catch(function(err) {
            console.log("No it didn't. This happened: ", err)
        });
    }
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }

    if (/android/i.test(userAgent)) {
        return "Android";
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "unknown";
}

function isChrome() {
    return /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
}

registerServiceWorker();

if(!isChrome()){
    addToHomescreen();
}