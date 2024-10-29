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
                            </div>

                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    @livewire('basketball-standings', ['seasonId' => $seasonId, 'tournamentId' => $tournamentId])
                </div>

                <div class="bg-white rounded-xl shadow-xl mb-2">
                    <div class="text-center p-2 font-bold">Matches</div>
                    <div class="border-b border-gray-400"></div>
                    <div class="flex justify-around">
                        <div class="w-1/2 border-r border-gray-400">
                            <div>
                                <div class="flex flex-wrap justify-around items-center">
                                    <div class="text-center">
                                        @livewire('season-standings', ['tournamentId' => $tournamentId, 'seasonId' => $seasonId, 'page' => $currentPage])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2">

                            <div class="p-2 rounded-xl">
                                @foreach($dataFeaturedEvents as $featuredEvents)
                                    <div class="flex items-center">
                                        <img class="mr-4" src="data:image/png;base64,{{ $tournamentLogo }}" alt="Tournament Logo" width="24" height="24">
                                        {{ $featuredEvents[0]['tournament']['category']['name'] }},
                                        {{ $featuredEvents[0]['tournament']['name'] }},
                                     {{--   Round {{ $featuredEvents[0]['roundInfo']['round'] }}--}}
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
                                    @if (!empty($headTwoHeadStats['data']['teamDuel']))
                                        <div class="bg-gray-100 mt-2 mx-2 p-2 rounded-xl" style="background-color: #f3f4f6 !important;">
                                            <div class="text-center"><h2>Head 2 head</h2></div>
                                            <div class="flex justify-between pt-2">
                                                <div class="flex flex-col items-center flex-1">
                                                    <img src="{{ $homeTeamLogoImg }}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                                    <span>{{ $featuredEvents[0]['homeTeam']['shortName'] }}</span>
                                                    <span>{{ $headTwoHeadStats['data']['teamDuel']['homeWins'] }}</span>
                                                </div>

                                                <div class="flex flex-col items-center mx-auto justify-center">
                                                    <span>{{ $headTwoHeadStats['data']['teamDuel']['draws'] }}</span>
                                                </div>

                                                <div class="flex flex-col items-center flex-1">
                                                    <img src="{{ $awayTeamLogoImg }}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                                    <span>{{ $featuredEvents[0]['awayTeam']['shortName'] }}</span>
                                                    <span>{{ $headTwoHeadStats['data']['teamDuel']['awayWins'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p>Nema dostupnih podataka za Head 2 head.</p>
                                    @endif

                                    <div class="bg-gray-100 mt-2 mx-2 p-2 rounded-xl" style="background-color: #f3f4f6 !important;">
                                        <div class="text-center"><h2>Match Info</h2></div>
                                        <div class="pt-2">
                                            <div class="flex justify-between">
                                                <span>Date and time</span>
                                                <span>{{ \Carbon\Carbon::parse($matchInfo['data']['startTimestamp'])->format('d/m/Y, H:i') }}</span>
                                            </div>

                                            <div class="flex justify-between">
                                                <span>Stadium</span>
                                                @if(isset($matchInfo['data']['venue']['stadium']['name']))
                                                    <span>{{$matchInfo['data']['venue']['stadium']['name']}}</span>
                                                @else
                                                    <span>Podaci o stadionu nisu dostupni</span>
                                                @endif
                                            </div>

                                            <div class="flex justify-between">
                                                <span>Location</span>
                                                <div class="flex items-center ml-auto">
                                                    @if(isset($matchInfo['data']['venue']) && isset($matchInfo['data']['venue']['country']['name']) && isset($matchInfo['data']['venue']['city']['name']))
                                                        <img src="{{ asset('flags/' . $matchInfo['data']['venue']['country']['name'] . '.svg') }}" alt="{{ $matchInfo['data']['venue']['country']['name'] }}" class="rounded" width="16" height="16">
                                                        <span class="ml-2">{{$matchInfo['data']['venue']['city']['name']}}, {{$matchInfo['data']['venue']['country']['name']}}</span>
                                                    @else
                                                        <span class="ml-2">Podaci o lokaciji nisu dostupni</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    @foreach($dataTournament as $tournamentInfo)
                        <div class="text-center p-2 font-bold">League info</div>
                        <div class="border-b border-gray-400"></div>
                                    <div class="pl-2 pt-2 pb-2 font-bold">Titles</div>
                                    <div class="flex flex-wrap justify-around items-center bg-gray-100 pt-2">
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
                    @endforeach
                </div>
                </div>
                <div class="bg-white rounded-xl shadow-xl mb-2">
                    {{--@livewire('player-statistics', ['tournamentId' => $tournamentId, 'seasonId' => $seasonId])--}}
                </div>
            </div>
            <div class="w-2/5">
                <div class="bg-white p-2 rounded-xl shadow-xl mb-2">
                    <h2>Featured Match</h2>
{{--
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
                    </div>--}}
                </div>

                <div class="bg-white rounded-xl p-2 shadow-xl mb-2">
                    <div class="p-2 font-bold">Top rating players</div>
                   {{-- @php
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
                    @endforeach--}}
                </div>


                <div class="bg-white rounded-xl p-2 shadow-xl mb-2">
                    <div class="p-2 font-bold">Most goals </div>
                    {{--@php
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
--}}
                </div>

                <div class="bg-white rounded-xl shadow-xl mb-2">
                    Ručno popunjen sadržaj kolone 2, red 4
                </div>
                <div class="bg-white p-2 rounded-xl shadow-xl mb-2">
                    <h2>Team of the week</h2>

                </div>
            </div>
        </div>
    </div>

    </div>

@endsection

