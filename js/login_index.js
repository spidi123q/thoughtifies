/**
 * Created by suraj on 5/28/17.
 */

function toggleBlur() {
    var d = document.querySelector('.blur-content');
    var chrome = document.querySelector('#chromebutton');

    if(d.className === 'blur-content blur'){
        d.className = 'blur-content';
    }else {
        d.className += ' blur';
    }
    if (chrome.className === 'flex-container hide'){
        chrome.className = 'flex-container';
    }
    else {
        chrome.className += ' hide';
    }
    window.scrollTo(0,document.body.scrollHeight);

}
function hideBlur() {
    var d = document.querySelector('.blur-content');
    if(d.className === 'blur-content blur'){
        d.className = 'blur-content';
    }

}
function hideChrome() {
    var chrome = document.querySelector('#chromebutton');
    if(chrome.className === 'flex-container'){
        chrome.className = 'flex-container hide';
    }
}

const applicationServerPublicKey = 'BO___6QnI00BCjCSf8xtjWwdvB_4ytzlHyuPEB4PV6eddcrk97C6NuVZqpf2vsMdjrRAE2gF3Ad3q0HSUsoYgtc';


let isSubscribed = false;
let swRegistration = null;

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('sw.js')
        .then(function(swReg) {
            console.log('Service Worker is registered', swReg);
            swRegistration = swReg;
            initialiseUI();
        })
        .catch(function(error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push Not Supported';
}
function initialiseUI() {
    subscribeUser();
    // Set the initial subscription value
    swRegistration.pushManager.getSubscription()
        .then(function(subscription) {
            isSubscribed = !(subscription === null);

            updateSubscriptionOnServer(subscription);

            if (isSubscribed) {
                console.log('User IS subscribed.');
            } else {
                console.log('User is NOT subscribed.');
            }

        });
}

function subscribeUser() {
    const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then(function(subscription) {
            console.log('User is subscribed.');

            updateSubscriptionOnServer(subscription);

            isSubscribed = true;


        })
        .catch(function(err) {
            console.log('Failed to subscribe the user: ', err);
        });
}
function updateSubscriptionOnServer(subscription) {
    // TODO: Send subscription to application server


    if (subscription) {
        //document.querySelector('body').innerText = JSON.stringify(subscription);
        console.log(JSON.stringify(subscription));
    } else {
    }
}