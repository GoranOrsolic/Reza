
@foreach ($categories as $cat)

    <a href="{{ route('football.tournaments', $cat['id']) }}">name: {{ $cat['name']}}
        id: {{ $cat['id']}}
        <br /></a>

@endforeach
