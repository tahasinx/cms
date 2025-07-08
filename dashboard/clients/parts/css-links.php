<title>CMS</title>
<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link href="https://fonts.googleapis.com/css?family=Rajdhani&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">        

<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<style>
    html {
        overflow: scroll;
        overflow-x: hidden;
    }
    ::-webkit-scrollbar {
        width: 0px;  /* Remove scrollbar space */
        background: transparent;  /* Optional: just make scrollbar invisible */
    }
    /* Optional: show position indicator in red */
    ::-webkit-scrollbar-thumb {
        background: #FF0000;
    }
    .content{
        font-family: 'Titillium Web', sans-serif;
    }

    .awesome-modal {
        display: none;
        background-color: whitesmoke;
        box-shadow: 0 0 26px 0 rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        padding: 1rem;
        width: 450px;
        min-height:150px;
        max-width: 80%;
        position: fixed;
        top: 50%;
        left: 50%;
        -webkit-transform: translate3d(-50%, -50%, 0);
        transform: translate3d(-50%, -50%, 0);
        overflow: hidden;
        z-index: 999;
        -webkit-animation: bounce .4s ease forwards;
        animation: bounce .4s ease forwards;
        font-family: 'Titillium Web', sans-serif;
    }
    .awesome-modal * {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .awesome-overlay {
        display: none;
        background-color: rgba(0, 0, 0, 0.6);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 998;
        overflow: hidden;
        cursor: default;
    }
    .close-icon {
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: .7rem;
        right: .7rem;
        -webkit-transition: opacity .2s ease;
        transition: opacity .2s ease;
    }
    .close-icon::before, .close-icon::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: inherit;
        height: 2px;
        background-color: #999;
    }
    .close-icon::before {
        -webkit-transform: translate(-50%, -50%) rotate(45deg);
        transform: translate(-50%, -50%) rotate(45deg);
    }
    .close-icon::after {
        -webkit-transform: translate(-50%, -50%) rotate(135deg);
        transform: translate(-50%, -50%) rotate(135deg);
    }

    .modal-title {
        margin-top: 0;
        text-transform: none;
    }

    :target {
        display: block;
    }
    :target ~ .awesome-overlay {
        display: block;
    }

    @-webkit-keyframes bounce {
        0% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(0.7);
            transform: translate3d(-50%, -50%, 0) scale(0.7);
        }
        45% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(1.05);
            transform: translate3d(-50%, -50%, 0) scale(1.05);
        }
        80% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(0.95);
            transform: translate3d(-50%, -50%, 0) scale(0.95);
        }
        100% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(1);
            transform: translate3d(-50%, -50%, 0) scale(1);
        }
    }

    @keyframes bounce {
        0% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(0.7);
            transform: translate3d(-50%, -50%, 0) scale(0.7);
        }
        45% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(1.05);
            transform: translate3d(-50%, -50%, 0) scale(1.05);
        }
        80% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(0.95);
            transform: translate3d(-50%, -50%, 0) scale(0.95);
        }
        100% {
            -webkit-transform: translate3d(-50%, -50%, 0) scale(1);
            transform: translate3d(-50%, -50%, 0) scale(1);
        }
    }
    #close {
        position: fixed;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>