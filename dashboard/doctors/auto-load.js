$(document).ready(function () {
    load();
    count();
    notify();

});


function load() {
    setTimeout(function () {
        messages();
        load();
    }, 200);
}

function count() {
    setTimeout(function () {
        unseen();
        count();
    }, 1000);
}

function notify() {
    setTimeout(function () {
        notifications();
        notify();
    }, 1000);
}


function messages() {
    $('#chat').load("parts/chats.php");
}

function unseen() {
    $('#unseen_to').load(window.location.href + " #unseen_to");
    $('#unseen_from').load(window.location.href + " #unseen_from");
    $('#sent').load(window.location.href + " #sent");
    $('#received').load(window.location.href + " #received");
}

function notifications() {
    $('#message').load(window.location.href + " #message");
}