// for async (this is on every page via app.php)
// no need to import it in other .js files :)
import 'babel-polyfill';
import Store from './Store';
import Notifier from './Notifier';
import $ from 'jquery';
import 'jquery-validation';

/*
* A little helper for using a jquery plugin, jquery-form
* */
global.validateForm = (id, opts) => {
    $(`#${id}`).validate({
            errorPlacement: function (error, element) {
                error.appendTo(element.parent().parent());
            },
            ...opts
        }
    );
}

class Main {
    constructor() {
    }

    notifications() {
        new Notifier()
            .determineNotifications(JSDATA.notifications || [])
    }
}

new Main()
    .notifications();

