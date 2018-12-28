@extends('layouts.app')

@section('content')
    <style>
        .sidebar {
            padding: 0px;
            min-height: 100vh
        }

        #container {

        }

        .sidebar a {
            font-size: 16px;
            color: white;

        }
        .counter {
            background-color:#f5f5f5;
            padding: 20px 0;
            border-radius: 5px;
        }

        .count-title {
            font-size: 40px;
            font-weight: normal;
            margin-top: 10px;
            margin-bottom: 0;
            text-align: center;
        }

        .count-text {
            font-size: 13px;
            font-weight: normal;
            margin-top: 10px;
            margin-bottom: 0;
            text-align: center;
        }

        .fa-2x {
            margin: 0 auto;
            float: none;
            display: table;
            color: #4ad1e5;
        }
    </style>
    <div class="container-fluid" id="container">
        <div class="row">
            <nav class="col-sm-3 col-md-2 hidden-xs-down bg-dark sidebar">
                <ul class="nav nav-pills flex-column mt-4" id="sidenav">
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Overview' ? "active" : ""}}" href="/apanel">Overview </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Team' ? "active" : ""}}" href="/apanel?active=Team&route=teams">Teams </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Player' ? "active" : ""}}" href="/apanel?active=Player&route=players">Players </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Coach' ? "active" : ""}}" href="/apanel?active=Coach&route=coaches">Coaches </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Match' ? "active" : ""}}" href="#">Matches </a>
                    </li>
                </ul>
            </nav>

            <main class="col-sm-8 offset-sm-3 col-md-8 offset-md-1 pt-3 mt-4">
                <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
                <div class="container">
                    <div class="row text-center">
                        <div class="col">
                            <div class="counter">
                                <i class="fa fa-code fa-2x"></i>
                                <h2 class="timer count-title count-number" data-to="{{$count}}" data-speed="1500"></h2>
                                <p class="count-text ">Count Visitors</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="counter">
                                <i class="fa fa-coffee fa-2x"></i>
                                <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
                                <p class="count-text ">Registred Teams</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="counter">
                                <i class="fa fa-lightbulb-o fa-2x"></i>
                                <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
                                <p class="count-text ">Registred Players</p>
                            </div></div>
                        <div class="col">
                            <div class="counter">
                                <i class="fa fa-bug fa-2x"></i>
                                <h2 class="timer count-title count-number" data-to="157" data-speed="1500"></h2>
                                <p class="count-text ">Registred Coaches</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isSet($_GET['active']))
                <br>
                <h2>{{$active}}</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Image</th>
                            <th><a href="{{$_GET['route']}}/create" class="btn btn-primary float-right">Add</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $single_data)
                        <tr>
                            <td>{{$single_data->id}}</td>
                            <td><a href="{{$_GET['route']}}/{{$single_data->id}}">{{$single_data->name}}</a></td>
                            <td>{{$single_data->city}}</td>
                            <td><img class="avatar" src="{{$single_data->image}}"></td>
                            <td>
                                <form action="{{$_GET['route']}}/{{$single_data->id}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                                </form>
                                <button class="btn btn-sm btn-primary float-right">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="container mt-4">
                        <div class="jumbotron text-center">
                            <h1>Welcome to Admin Panel</h1>
                            <p>Chose from side-menu to manipulate data</p>
                        </div>
                    </div>
                    <div class="container mt-4">
                        <div class="row text-center">
                            <div class="col">
                                <div class="counter">
                                    <i class="fa fa-code fa-2x"></i>
                                    <h2 class="timer count-title count-number" data-to="100" data-speed="1500"></h2>
                                    <p class="count-text ">Our Visitors</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="counter">
                                    <i class="fa fa-coffee fa-2x"></i>
                                    <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
                                    <p class="count-text ">Registred Teams</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="counter">
                                    <i class="fa fa-lightbulb-o fa-2x"></i>
                                    <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
                                    <p class="count-text ">Registred Players</p>
                                </div></div>
                            <div class="col">
                                <div class="counter">
                                    <i class="fa fa-bug fa-2x"></i>
                                    <h2 class="timer count-title count-number" data-to="157" data-speed="1500"></h2>
                                    <p class="count-text ">Registred Coaches</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
    <script>
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
    </script>
@endsection