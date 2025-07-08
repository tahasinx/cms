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
    $('#message_count').load(window.location.href + " #message_count");
    $('#messages').load(window.location.href + " #messages");
}

function unseen() {
    $('#unseen_to').load(window.location.href + " #unseen_to");
    $('#unseen_from').load(window.location.href + " #unseen_from");
    $('#sent').load(window.location.href + " #sent");
    $('#received').load(window.location.href + " #received");
}

function notifications() {
   $('#notifications').load(window.location.href + " #notifications");
   $('#notification_count').load(window.location.href + " #notification_count");
}