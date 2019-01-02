
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./addinput');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('match-manager', require('./components/MatchManager.vue'));
Vue.component('standings', require('./components/Standings.vue'));


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};

        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from:            $(this).data('from'),
                to:              $(this).data('to'),
                speed:           $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals:        $(this).data('decimals')
            }, options);

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;

            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);

            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);

            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                value += increment;
                loopCount++;

                render(value);

                if (typeof(settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }

                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;

                    if (typeof(settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }
}(jQuery));

jQuery(function ($) {
    // custom formatting example
    $('.count-number').data('countToOptions', {
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }
});

function addNewInput(element) {
    let parent = element.parentNode;    // div u okviru koga se nalazi
    let hasValue = false;
    for(let i = 0; i < parent.children.length; i++) {
        if(parent.children[i].value) {
            hasValue = true;
            break;
        }
    }
    if (!hasValue) {
        if(parent.parentNode.children.length === 1) {
            return;
        } else {
            parent.parentNode.removeChild(parent);
            return;
        }
    } else if (parent.nextElementSibling)
        return;

    let newInput = parent.cloneNode(); // novi div
    let nameParts = newInput.id.split('_');
    newInput.id = nameParts[0] + '_' + (parseInt(nameParts[1]) + 1);
    for(let i = 0; i < parent.children.length; i++) {
        let newChild;
        if(parent.children[i].type === "select-one") {
            newChild = parent.children[i].cloneNode(true);  // cloneNode([deep])

        } else {
            newChild = parent.children[i].cloneNode();
        }
        let nameParts = newChild.name.split('_');
        let name = nameParts[0] + '_' + nameParts[1] + '_' + (parseInt(nameParts[2]) + 1);
        newChild.name = name;
        newChild.value = "";
        newInput.appendChild(newChild);
    }
    parent.parentNode.appendChild(newInput);
}

function addNewInput(element) {
    let parent = element.parentNode;    // div u okviru koga se nalazi
    let hasValue = false;
    for(let i = 0; i < parent.children.length; i++) {
        if(parent.children[i].value) {
            hasValue = true;
            break;
        }
    }
    if (!hasValue) {
        if(parent.parentNode.children.length === 1) {
            return;
        } else {
            parent.parentNode.removeChild(parent);
            return;
        }
    } else if (parent.nextElementSibling)
        return;

    let newInput = parent.cloneNode(); // novi div
    let nameParts = newInput.id.split('_');
    newInput.id = nameParts[0] + '_' + (parseInt(nameParts[1]) + 1);
    for(let i = 0; i < parent.children.length; i++) {
        let newChild;
        if(parent.children[i].type === "select-one") {
            newChild = parent.children[i].cloneNode(true);  // cloneNode([deep])

        } else {
            newChild = parent.children[i].cloneNode();
        }
        let nameParts = newChild.name.split('_');
        let name = nameParts[0] + '_' + nameParts[1] + '_' + (parseInt(nameParts[2]) + 1);
        newChild.name = name;
        newChild.value = "";
        newInput.appendChild(newChild);
    }
    parent.parentNode.appendChild(newInput);
}

function changeAction(element) {
    let form = element.parentNode;
    let method = form.children[0]; // prvi je hidden input za metodu
    console.log(method);
    if(element.value === "Update") {
        method.value = "PUT";
    } else {
        method.value = "DELETE";
    }
}

// Multiple inputs
function addNewInput(element) {
    let parent = element.parentNode;    // div u okviru koga se nalazi
    let hasValue = false;
    for(let i = 0; i < parent.children.length; i++) {
        if(parent.children[i].value) {
            hasValue = true;
            break;
        }
    }
    if (!hasValue) {
        if(parent.parentNode.children.length === 1) {
            return;
        } else {
            parent.parentNode.removeChild(parent);
            return;
        }
    } else if (parent.nextElementSibling)
        return;

    let newInput = parent.cloneNode(); // novi div
    let nameParts = newInput.id.split('_');
    newInput.id = nameParts[0] + '_' + (parseInt(nameParts[1]) + 1);
    for(let i = 0; i < parent.children.length; i++) {
        let newChild;
        if(parent.children[i].type === "select-one") {
            newChild = parent.children[i].cloneNode(true);  // cloneNode([deep])

        } else {
            newChild = parent.children[i].cloneNode();
        }
        let nameParts = newChild.name.split('_');
        let name = nameParts[0] + '_' + nameParts[1] + '_' + (parseInt(nameParts[2]) + 1);
        newChild.name = name;
        newChild.value = "";
        newInput.appendChild(newChild);
    }
    parent.parentNode.appendChild(newInput);
}

const app = new Vue({
    el: '#app'
});
