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
