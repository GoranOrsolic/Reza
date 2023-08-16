
    @foreach ($tournaments as $tur)

        <a href="{{ route('seasons', $tur['id']) }}">name: {{ $tur['name']}}

        id: {{ $tur['id']}}

        <br /></a>
    @endforeach



