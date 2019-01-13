@if(session('success'))
    <div class="container">
        <div id="message" style="position: absolute; z-index: 10; font-size: 250%;" class="alert container text-center alert-success">
            {{session('success')}}
        </div>
    </div>
@endif

@if(session('danger'))
    <div class="container">
        <div id="message" style="z-index: 10; position: absolute; font-size: 250%;" class="alert alert-danger container text-center">
            {{session('danger')}}
        </div>
    </div>
@endif
