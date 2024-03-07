@extends('layouts.main')

@section('content')
    <div class="container mx-auto">
        <div class="flex gap-6 mt-5">
            <div class="w-4/5">
                <div class="bg-white rounded-xl shadow-xl mb-2">
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
                                    <span>
                                        @if(!empty($standings))
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
                <div class="bg-white rounded-xl shadow-xl mb-2">
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
                                    </td>
                                    <td class="px-28"></td> <!-- Veliki razmak između druge i treće kolone -->
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
                </div>
                <div class="bg-white rounded-xl shadow-xl p-2 mb-2">

                    @livewire('season-standings', ['tournamentId' => $tournamentId, 'seasonId' => $seasonId, 'page' => $currentPage])

                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    @foreach($dataTournament as $tournamentInfo)
                        <div class="text-center p-2 font-bold">League info</div>
                        <div class="border-b border-gray-400"></div>
                        <div class="flex justify-around">
                            <div class="w-1/2 border-r border-gray-400">
                                <div>
                                    <div class="pl-2 pt-2 pb-2 font-bold">Titles</div>
                                    <div class="flex flex-wrap justify-around items-center">
                                        <div class="text-center">
                                            <img src="{{$teamHolderImg}}" alt="Logo" class="rounded mx-auto" width="40" height="40">
                                            {{$tournamentInfo['titleHolder']['name']}}
                                            <br>
                                            Title holder({{$tournamentInfo['titleHolderTitles']}})
                                        </div>
                                        <div class="text-center">
                                            <img src="{{$teamMostImg}}" alt="Logo" class="rounded mx-auto" width="40" height="40">
                                            {{$tournamentInfo['mostTitlesTeams'][0]['name']}}
                                            <br>
                                            Most Titles({{$tournamentInfo['mostTitles']}})
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="p-2 font-bold">Lower division</div>
                                <div class="p-2 flex border-b border-gray-400">
                                    <img src="{{$lowerDivisionImg}}" alt="Logo" class="rounded mr-3" width="32" height="32">
                                    {{$tournamentInfo['lowerDivisions'][0]['name']}}
                                </div>
                                <div class="p-2 font-bold">Newcomers from lower division</div>
                                <div class="p-2 flex border-b border-gray-400">
                                    <img src="{{$newcomersLogoImg}}" alt="Logo" class="rounded mr-3" width="32" height="32">
                                    {{$newcomersInfo['data']['newcomersLowerDivision'][0]['name']}}
                                </div>
                                <div class="p-2 font-bold">Facts</div>
                                <div class="flex justify-between p-2">
                                    <span>Goals</span> <span>{{$newcomersInfo['data']['goals']}}</span>
                                </div>
                                <div class="flex justify-between p-2">
                                    <span>Home team wins</span> <span>{{$newcomersInfo['data']['homeTeamWins']}}</span>
                                </div>
                                <div class="flex justify-between p-2">
                                    <span>Away team wins</span> <span>{{$newcomersInfo['data']['awayTeamWins']}}</span>
                                </div>
                                <div class="flex justify-between p-2">
                                    <span>Draws</span> <span>{{$newcomersInfo['data']['draws']}}</span>
                                </div>
                                <div class="flex justify-between p-2">
                                    <span>Yellow cards</span> <span>{{$newcomersInfo['data']['yellowCards']}}</span>
                                </div>
                                <div class="flex justify-between p-2">
                                    <span>Red cards</span> <span>{{$newcomersInfo['data']['redCards']}}</span>
                                </div>
                                <div class="flex justify-between p-2 border-b border-gray-400">
                                    <span>Number Of Competitors</span> <span>{{$newcomersInfo['data']['numberOfCompetitors']}}</span>
                                </div>
                                {{--<div class="p-2 font-bold">Host</div>
                                <div class="flex justify-between p-2">
                                    <span>Country</span> <span>{{$newcomersInfo['data']['hostCountries'][0]}}</span>
                                </div>--}}

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    @livewire('player-statistics', ['tournamentId' => $tournamentId, 'seasonId' => $seasonId])

                </div>
            </div>
            <div class="w-2/5">
                <div class="bg-white p-2 rounded-xl shadow-xl mb-2">
                    <h2>Featured Match</h2>

                    <div class="bg-gray-100 p-2 rounded-xl" style="background-color: #f3f4f6 !important;">
                        @foreach($dataFeaturedEvents as $featuredEvents)
                            <div class="flex items-center">
                                <img class="mr-4" src="data:image/png;base64,{{ $tournamentLogo }}" alt="Tournament Logo" width="24" height="24">
                                {{ $featuredEvents[0]['tournament']['category']['name'] }},
                                {{ $featuredEvents[0]['tournament']['name'] }},
                                Round {{ $featuredEvents[0]['roundInfo']['round'] }}
                            </div>

                            <div class="flex justify-between pt-2">
                                <div class="flex flex-col items-center flex-1">
                                    <img src="{{$homeTeamLogoImg}}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                    <span>{{ $featuredEvents[0]['homeTeam']['shortName'] }}</span>
                                </div>

                                <div class="flex flex-col items-center mx-2 justify-center">
                                    <span>{{ \Carbon\Carbon::parse($featuredEvents[0]['startTimestamp'])->format('d/m/Y') }}</span>
                                    <span>{{ \Carbon\Carbon::parse($featuredEvents[0]['startTimestamp'])->format('H:i') }}</span>
                                </div>

                                <div class="flex flex-col items-center flex-1">
                                    <img src="{{$awayTeamLogoImg}}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                    <span>{{ $featuredEvents[0]['awayTeam']['shortName'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl p-2 shadow-xl mb-2 grid grid-cols-3 gap-4">
                    <div class="p-2 font-bold">Top rating players</div>
                    @php
                        $first10Ratings = array_slice($topStatsPlayers['data']['rating'], 0, 10);
                    @endphp

                    @foreach($first10Ratings as $index => $topRating)
                        <div class="flex p-2 items-center">
                            <div class="mr-2">{{ $loop->index + 1 }}</div>
                            @if(isset($playerPhotos[$index]))
                                <img src="{{ $playerPhotos[$index] }}" alt="Player Image" class="rounded-full mr-2" width="38" height="38">
                            @endif
                            <div class="flex-grow">
                                {{ $topRating['player']['name'] }}
                                @if(isset($teamLogoRating[$index]))
                                    <img src="{{ $teamLogoRating[$index] }}" alt="Team Image" class="rounded-full mr-2" width="16" height="16">
                                @endif
                            </div>
                            <div class="ml-auto">
                                {{ sprintf("%.2f", $topRating['statistics']['rating']) }}
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="bg-white rounded-xl p-2 shadow-xl mb-2 grid grid-cols-3 gap-4">
                    <div class="p-2 font-bold">Most goals </div>
                    @php
                        $first10Goals = array_slice($topStatsPlayers['data']['goals'], 0, 10);
                    @endphp

                    @foreach($first10Goals as $index => $topGoals)
                        <div class="flex p-2 items-center">
                            <div class="mr-2">{{ $loop->index + 1 }}</div>
                            @if(isset($playerGoalsPhotos[$index]))
                                 <img src="{{ $playerGoalsPhotos[$index] }}" alt="Player Image" class="rounded-full mr-2" width="38" height="38">
                            @endif
                            <div class="flex-grow">
                                {{ $topGoals['player']['name'] }}
                                @if(isset($teamLogoGoals[$index]))
                                    <img src="{{ $teamLogoGoals[$index] }}" alt="Team Image" class="rounded-full mr-2" width="16" height="16">
                                @endif
                            </div>
                            <div class="ml-auto">
                                {{ $topGoals['statistics']['goals'] }}<br>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    Ručno popunjen sadržaj kolone 2, red 4
                </div>
                <div class="bg-white p-2 rounded-xl shadow-xl mb-2">
                    <h2>Team of the week</h2>

                    <iframe id="sofa-totw-embed-170-52147-10728" width="100%" height="500" style="display:block;max-width:440px"
                            src="https://widgets.sofascore.com/embed/unique-tournament/170/season/52147/round/10728/teamOfTheWeek?widgetBackground=Gray&showCompetitionLogo=true&widgetTitle=HNL" frameBorder="0" scrolling="no"></iframe>
                    <div style="font-size:12px;font-family:Arial,sans-serif;text-align:left">
                        Team of the Week provided by <a target="_blank" href="https://www.sofascore.com/">Sofascore</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

