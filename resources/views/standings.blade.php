@extends('layouts.main')

@section('content')

    <div class="container mx-auto">
        <div class="flex gap-6 mt-5">
            <div class="w-3/4 bg-white rounded-xl shadow-xl">
                <div class="flex justify-center items-center"> <!-- Dodajte justify-center i items-center ovdje -->
                    <div class="mr-3">
                        @if(isset($tournamentLogo))
                            <img src="data:image/png;base64,{{ $tournamentLogo }}" alt="Tournament Logo">
                        @endif
                    </div>
                    <div>

                            <span class="text-4xl mb-2">@if(!empty($standings))
                                {{ $standings[0]['tournament']['name'] }}
                            @else
                            @endif
                                </span>

                        <div class="flex mt-4">
                            <div class="flex mr-4">
                                @if(file_exists(public_path('flags/' . $standings[0]['tournament']['category']['flag'] . '.svg')))
                                    <img src="{{ asset('flags/' . $standings[0]['tournament']['category']['flag'] . '.svg') }}" alt="{{ $standings[0]['tournament']['category']['name'] }}" class="rounded mr-4" width="32" height="32" >
                                @endif
                                <span>@if(!empty($standings))
                                    {{ $standings[0]['tournament']['category']['name'] }}
                                @else
                                @endif
                                </span>
                            </div>
                            <div>
                                @if(!empty($standings))
                                    {{ $standings[0]['name'] }}
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="w-1/4 bg-white p-3 rounded-xl shadow-xl">
                druga kolona  <br>
                <br>  <br>
                <br>  <br>
                <br>  <br>
                <br>  <br>
                <br>fdsf  <br>
                <br>  <br>
                <br>  <br>
                <br>  <br>
                <br>fsasdsa  <br>
                <br>  <br>
                <br>
            </div>
        </div>

        <div class="flex gap-6 mt-5 ">
            <div class="w-3/4 bg-white rounded-xl shadow-xl">
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="px-2 py-2">#</th>
                        <th class="px-2 py-2 text-start">Team</th>
                        <th class="px-28"></th> <!-- Veliki razmak između druge i treće kolone -->
                        <th class="text-center px-2 py-2">P</th> <!-- Text desno za ostale kolone -->
                        <th class="text-center px-2 py-2">W</th>
                        <th class="text-center px-2 py-2">D</th>
                        <th class="text-center px-2 py-2">L</th>
                        <th class="text-center px-2 py-2">Sr</th>
                        <th class="text-center px-2 py-2">C</th>
                        <th class="text-center px-2 py-2">PTS</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($standings as $data)
                        @foreach($data['rows'] as $index => $row)
                            <tr class="hover:bg-gray-100">
                                <td class="px-2 py-2">{{ $row['position'] }}</td>
                                <td class="px-2 py-2 text-start">
                                    <a href="{{ route('team.football', $row['team']['id']) }}" class="flex items-center">
                                        <img src="{{ $teamLogos[$row['team']['id']] }}" alt="{{ $row['team']['name'] }} Logo" class="rounded mr-2" width="24" height="24">
                                        {{ $row['team']['name'] }}
                                    </a>
                                </td>                              <td class="px-28"></td> <!-- Veliki razmak između druge i treće kolone -->
                                <td class="text-center px-2 py-2">{{ $row['matches'] }}</td> <!-- Text desno za ostale kolone -->
                                <td class="text-center px-2 py-2">{{ $row['wins'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['draws'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['losses'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['scoresFor'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['scoresAgainst'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['points'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
                            NEXT MATCHES
                            <br>
                            <br>

                            @foreach($nextEvents['events'] as $index => $matches)
                                {{\Carbon\Carbon::parse($matches['startTimestamp'])->format('d/m/Y')}}
                                {{$matches['homeTeam']['name']}}
                                vs
                                {{$matches['awayTeam']['name']}}
                                <br>
                                <br>
                            @endforeach
                            PAST MATCHES
                            <br>
                            <br>
                            @foreach($pastEvents['events'] as $index => $matches)
                                {{ \Carbon\Carbon::parse($matches['startTimestamp'])->format('d/m/Y') }}
                                {{ $matches['homeTeam']['name'] }}

                                @if(isset($matches['homeScore']['current']))
                                    {{ $matches['homeScore']['current'] }}
                                @else
                                    N/A
                                @endif

                                vs

                                {{ $matches['awayTeam']['name'] }}

                                @if(isset($matches['awayScore']['current']))
                                    {{ $matches['awayScore']['current'] }}
                                @else
                                    N/A
                                @endif

                                <br>
                                <br>
                            @endforeach

                    <br>
                    <br>
            </div>
            <div class="w-1/4 bg-white p-3 rounded-xl shadow-xl">
                druga kolona
            </div>

        </div>
    </div>

@endsection
