@if (Session::has('success'))
    <p class="xl-msg xl-msg--ok" role="status">{{ Session::get('success') }}</p>
@endif

@if ($errors->any())
    <ul class="xl-msg xl-msg--err" role="alert">
        @foreach ($errors->all() as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
@endif
