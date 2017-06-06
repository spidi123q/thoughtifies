/**
 * Created by suraj on 6/6/17.
 */

var applicationServerPublicKey = 'BAQZq2fU0WXMO8algZPK3X_I0gQalpPgiZtDNQkRZt8KMixVo0QNFGebvXvpLPm7V2foc3ITykg4WVc8X-pUuCA';


var isSubscribed = false;
var swRegistration = null;

function urlB64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
if ('serviceWorker' in navigator && 'PushManager' in window) {
    //console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register(BASE_URL+'sw.js')
        .then(function(swReg) {
           // console.log('Service Worker is registered', swReg);
            swRegistration = swReg;
            initialiseUI();
        })
        .catch(function(error) {
           // console.error('Service Worker Error', error);
        });
} else {
    //console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push Not Supported';
}
function initialiseUI() {

    // Set the initial subscription value
    swRegistration.pushManager.getSubscription()
        .then(function(subscription) {
            isSubscribed = !(subscription === null);

            if (isSubscribed) {
                //console.log('User IS subscribed.');
            } else {
               // console.log('User is NOT subscribed.');
                subscribeUser();
            }

        });
}

function subscribeUser() {
    var applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then(function(subscription) {
           // console.log('User is subscribed.');

            updateSubscriptionOnServer(subscription);

            isSubscribed = true;


        })
        .catch(function(err) {
            //console.log('Failed to subscribe the user: ', err);
        });
}
function updateSubscriptionOnServer(subscription) {
    // TODO: Send subscription to application server


    if (subscription) {
        //document.querySelector('body').innerText = JSON.stringify(subscription);
        var data = JSON.stringify(subscription);
        //console.log(data);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "subscribe/webpush", true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(data);
    } else {
        //console.log('Failed to subscribe the ');
    }
}
