@if ($errors->any())
    <div class="mb-2 mt-2">
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        </ul>
    </div>
@endif
