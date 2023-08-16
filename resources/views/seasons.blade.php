
@foreach($seasons as $year)
        <a href="{{ route('standings',[$year['id'], $url])}}">name: {{$year['name']}}
        year: {{$year['year']}}
        id:   {{$year['id']}}
            <br/></a>
    @endforeach
