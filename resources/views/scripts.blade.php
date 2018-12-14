
@section('scripts')
    <script>
        function addNewInput(element) {
            if (!element.value) {
                element.parentNode.removeChild(element.nextElementSibling);
                return;
            } else if (element.nextElementSibling)
                return;
            let newInput = element.cloneNode();
            let inputType = newInput.id.split('_');
            newInput.id = inputType + '_' + (parseInt(element.id.substring(element.id.indexOf('_') + 1)) + 1);
            newInput.value = '';
            element.parentNode.appendChild(newInput);
        }
    </script>
@endsection