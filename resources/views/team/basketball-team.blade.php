@extends('layouts.main')

@section('content')
    <div class="container mx-auto">
        <div class="flex gap-6 mt-5">
            <div class="w-4/5">

                @foreach($teamInfo as $info)

                    <div class="d-flex flex-row align-items-center">
                        <div class="flex p-2 items-center bg-white rounded-xl shadow-xl mb-2">
                            <div>
                                <img src="data:image/png;base64,{{ $teamLogo }}" alt="" width="112" height="112">
                            </div>
                            <div class="ml-4">
                                <p class="text-3xl">{{ $info['name'] }}</p>
                                <div class="flex mt-2 items-center">
                                    <img src="{{ asset('flags/' . $info['country']['name'] . '.svg') }}" alt="{{ $info['country']['name'] }}" class="rounded-full" width="24" height="24">
                                    <p class="text-lg ml-2">{{ $info['country']['name'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-xl mb-2">
                            @livewire('basketball-standings', ['seasonId' => $seasonId, 'tournamentId' => $tournamentId])
                        </div>

                    </div>
                @endforeach
                    <div class="bg-white rounded-xl shadow-xl mb-2">
                    <div class="text-center p-2 font-bold">Matches</div>
                    <div class="border-b border-gray-400"></div>
                    <div class="flex justify-around">
                        <div class="w-1/2 border-r border-gray-400">
                            <div>
                                <div class="flex flex-wrap justify-around items-center">
                                    <div class="text-center">
                                        @livewire('team-events', ['teamId' => $id, 'page' => $page])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2">

                            <div class="flex items-center p-2">
                                {{ $nextMatch['data']['nextEvent']['tournament']['category']['name'] }},
                                {{ $nextMatch['data']['nextEvent']['tournament']['name'] }},
                                Round {{ $nextMatch['data']['nextEvent']['roundInfo']['round'] }}
                            </div>

                            <div class="flex justify-between pt-2">
                                <div class="flex flex-col items-center flex-1">
                                    <img src="{{$homeTeamLogoImg}}" alt="Logo" class="rounded mr-3" width="48" height="48">
                                    <span>{{ $nextMatch['data']['nextEvent']['homeTeam']['shortName'] }}</span>
                                </div>

                                <div class="flex flex-col items-center mx-2 justify-center">
                                    <span>{{ \Carbon\Carbon::parse($nextMatch['data']['nextEvent']['startTimestamp'])->format('d/m/Y') }}</span>
                                    <span>{{ \Carbon\Carbon::parse($nextMatch['data']['nextEvent']['startTimestamp'])->format('H:i') }}</span>
                                </div>

                                <div class="flex flex-col items-center flex-1">
                                    <img src="{{$awayTeamLogoImg}}" alt="Logo" class="rounded" width="48" height="48">
                                    <span>{{ $nextMatch['data']['nextEvent']['awayTeam']['shortName'] }}</span>
                                </div>
                            </div>

                           @if (!empty($headTwoHeadStats['data']['teamDuel']))
                                <div class="bg-gray-100 mt-2 mx-2 p-2 rounded-xl" style="background-color: #f3f4f6 !important;">
                                    <div class="text-center"><h2>Head 2 head</h2></div>
                                    <div class="flex justify-between pt-2">
                                        <div class="flex flex-col items-center flex-1">
                                            <img src="{{ $homeTeamLogoImg }}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                            <span>{{ $nextMatch['data']['nextEvent']['homeTeam']['shortName'] }}</span>
                                            <span>{{ $headTwoHeadStats['data']['teamDuel']['homeWins'] }}</span>
                                        </div>

                                        <div class="flex flex-col items-center mx-auto justify-center">
                                            <span>{{ $headTwoHeadStats['data']['teamDuel']['draws'] }}</span>
                                        </div>

                                        <div class="flex flex-col items-center flex-1">
                                            <img src="{{ $awayTeamLogoImg }}" alt="Logo" class="rounded mb-2" width="48" height="48">
                                            <span>{{ $nextMatch['data']['nextEvent']['awayTeam']['shortName'] }}</span>
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
                                        <span>Competition</span>
                                        @if(isset($matchInfo['data']['tournament']['category']['sport']['name']))
                                            <span>{{$matchInfo['data']['tournament']['category']['sport']['name']}}, {{$matchInfo['data']['tournament']['category']['name']}}, {{$matchInfo['data']['tournament']['name']}}, Round {{$matchInfo['data']['roundInfo']['round']}} </span>
                                        @else
                                            <span>Podaci nisu dostupni</span>
                                        @endif
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

                                    <div class="flex justify-between">
                                        <span>Referee</span>
                                        <div class="flex items-center ml-auto">
                                            @if(isset($matchInfo['data']['referee']) && isset($matchInfo['data']['referee']['country']['name']) && isset($matchInfo['data']['referee']['name']))
                                                <img src="{{ asset('flags/' . $matchInfo['data']['referee']['country']['name'] . '.svg') }}" alt="{{ $matchInfo['data']['referee']['country']['name'] }}" class="rounded" width="16" height="16">
                                                <span class="ml-2">{{$matchInfo['data']['referee']['name']}}</span>
                                            @else
                                                <span class="ml-2">Podaci o sucu nisu dostupni</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xl mb-2">
                    <div class="text-center p-2 font-bold">Team info</div>
                    <div class="border-b border-gray-400"></div>
                      <div class="flex justify-around">
                        <div class="w-1/2 border-r border-gray-400">
                            <div class="flex flex-wrap justify-around items-center bg-gray-100 mt-2 mx-2 p-2 rounded-xl" style="background-color: #f3f4f6 !important;">
                                <div class="w-1/2 p-2 pb-4 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 12 12" class="mx-auto"><path fill="currentColor" d="M4 6a2 2 0 1 0 0-4a2 2 0 0 0 0 4m4.5 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M2.25 7C1.56 7 1 7.56 1 8.25c0 0 0 2.25 3 2.25c2.378 0 2.871-1.414 2.973-2C7 8.347 7 8.25 7 8.25C7 7.56 6.44 7 5.75 7zm5.746 1.6a2.645 2.645 0 0 1-.09.536c-.063.223-.167.49-.342.765a4.1 4.1 0 0 0 .935.099c2.5 0 2.5-1.75 2.5-1.75c0-.69-.56-1.25-1.25-1.25H7.62c.24.358.379.787.379 1.25v.25z"/></svg>
                                    Total players: {{count($players['data']['players'])}}
                                </div>
                                <div class="w-1/2 p-2 pb-4 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 32 32" class="mx-auto"><path fill="currentColor" d="M26 4h-4V2h-2v2h-8V2h-2v2H6c-1.1 0-2 .9-2 2v20c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 22H6V12h20zm0-16H6V6h4v2h2V6h8v2h2V6h4z"/></svg>
                                    Average player age: {{sprintf("%.1f", $averageAge)}}
                                </div>
                                <div class="w-1/2 p-2 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 20 20" class="mx-auto"><path fill="currentColor" d="M17.584 9.372h2a9.554 9.554 0 0 0-.668-2.984L17.16 7.402c.224.623.371 1.283.424 1.97m-3.483-8.077a9.492 9.492 0 0 0-3.086-.87v2.021a7.548 7.548 0 0 1 2.084.585zm2.141 4.327l1.741-1.005a9.643 9.643 0 0 0-2.172-2.285l-1.006 1.742a7.625 7.625 0 0 1 1.437 1.548m-6.228 11.949a7.6 7.6 0 0 1-7.6-7.6c0-3.858 2.877-7.036 6.601-7.526V.424C4.182.924.414 5.007.414 9.971a9.6 9.6 0 0 0 9.601 9.601c4.824 0 8.807-3.563 9.486-8.2H17.48c-.658 3.527-3.748 6.199-7.466 6.199"/></svg>
                                    Foreign players: {{count($players['data']['foreignPlayers'])}}
                                </div>
                                <div class="w-1/2 p-2 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 20 20" class="mx-auto"><path fill="currentColor" d="M17.584 9.372h2a9.554 9.554 0 0 0-.668-2.984L17.16 7.402c.224.623.371 1.283.424 1.97m-3.483-8.077a9.492 9.492 0 0 0-3.086-.87v2.021a7.548 7.548 0 0 1 2.084.585zm2.141 4.327l1.741-1.005a9.643 9.643 0 0 0-2.172-2.285l-1.006 1.742a7.625 7.625 0 0 1 1.437 1.548m-6.228 11.949a7.6 7.6 0 0 1-7.6-7.6c0-3.858 2.877-7.036 6.601-7.526V.424C4.182.924.414 5.007.414 9.971a9.6 9.6 0 0 0 9.601 9.601c4.824 0 8.807-3.563 9.486-8.2H17.48c-.658 3.527-3.748 6.199-7.466 6.199"/></svg>
                                    National team players: {{count($players['data']['nationalPlayers'])}}
                                </div>
                            </div>
                            <div class="border-b border-gray-400 mt-2"></div>
                            <div class="p-2">
                                <div class="font-bold text-lg mb-2">Info</div>

                                <div class="flex justify-between">
                                    <span>Coach:</span>
                                    <div>{{$info['manager']['name']}}</div>
                                </div>

                                <div class="flex justify-between ">
                                    <span>Country</span>
                                    <div class="flex items-center ml-auto">
                                        <img src="{{ asset('flags/' . $info['country']['name'] . '.svg') }}" alt="{{ $info['country']['name'] }}" class="rounded" width="16" height="16">
                                        <span class="ml-2">{{$info['country']['name']}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-400 w-full mt-2"></div>
                            <div class="p-2">

                                <div class="font-bold text-lg mt-2 mb-2">Venue</div>
                                <div class="flex justify-between">
                                    <span>Stadium:</span>
                                    <div>{{$info['venue']['stadium']['name']}}</div>
                                </div>

                                <div class="flex justify-between">
                                    <span>Capacity:</span>
                                    <div>{{$info['venue']['stadium']['capacity']}}</div>
                                </div>

                                <div class="flex justify-between">
                                    <span>City:</span>
                                    <div>{{$info['venue']['city']['name']}}, {{$info['venue']['country']['name']}}</div>
                                </div>
                            </div>

                        </div>
                        <div class="w-1/2">
                            <div class="font-bold text-lg p-2 mt-2 mb-2">Latest transfers</div>
                            <div class="flex p-2">
                                <div class="w-1/2">
                                    @php $totalIn = count($transfers['data']['transfersIn'] ?? []); @endphp
                                    <h3 class="text-green-500 pb-4">Arrivals {{ $totalIn }}</h3>
                                    <ul>
                                        @php $counter = 0; @endphp
                                        @foreach ($transfers['data']['transfersIn'] as $transfer)
                                            @if ($counter < 3 && isset($transfer['player']['name']))
                                                <li>
                                                    {{ $transfer['player']['name'] }}
                                                </li>
                                                @php $counter++; @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="w-1/2">
                                    @php $totalOut = count($transfers['data']['transfersOut'] ?? []); @endphp
                                    <h3 class="text-red-500 pb-4">Departures {{ $totalOut }}</h3>
                                    <ul>
                                        @php $counter = 0; @endphp
                                        @foreach ($transfers['data']['transfersOut'] as $transfer)
                                            @if ($counter < 3 && isset($transfer['player']['name']))
                                                <li>
                                                    {{ $transfer['player']['name'] }}
                                                </li>
                                                @php $counter++; @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
{{--                            <div class="border-b border-gray-400 mt-2"></div>--}}
{{--                            <div class="grid grid-cols-3 mt-4 gap-4">--}}
{{--                                @foreach ($tournaments['data'] as $turnir)--}}
{{--                                    <div class="flex flex-col items-center">--}}
{{--                                        <img src="{{ $logos[$turnir['id']] }}" alt="{{ $turnir['name'] }} Logo" class="mb-2" width="40" height="40">--}}
{{--                                        <h2 class="text-center">{{ $turnir['name'] }}</h2>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>

{{--                <div class="bg-white rounded-xl shadow-xl mb-2">--}}
{{--                    <div class="text-center p-2 font-bold">Players</div>--}}
{{--                    <div class="p-2">Forward</div>--}}
{{--                    <div class="flex p-2 flex-wrap gap-3">--}}
{{--                        @foreach ($players['data']['players'] as $playerData)--}}
{{--                            @if (isset($playerData['player']['position']) && $playerData['player']['position'] === 'F')--}}
{{--                                <div class="w-1/6 p-4 border rounded text-center relative bg-gray-100 mb-4">--}}
{{--                                    @if (isset($playerPhotos[$playerData['player']['id']]))--}}
{{--                                        <div class="relative">--}}
{{--                                            <img src="{{ $playerPhotos[$playerData['player']['id']] }}" alt="{{ $playerData['player']['id'] }} Logo" class="mb-2 rounded-full mx-auto" width="63" height="63">--}}
{{--                                            @if (isset($playerData['player']['jerseyNumber']))--}}
{{--                                                <span class="absolute bottom-0 right-1 bg-gray-600 text-white p-1 rounded text-xs">{{ $playerData['player']['jerseyNumber'] }}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <p>No photo available</p>--}}
{{--                                    @endif--}}
{{--                                    <p class="m-3">{{ $playerData['player']['name'] }}</p>--}}
{{--                                    <div class="flex m-3 justify-between items-center">--}}
{{--                                        <p class="mr-2">{{ $playerData['player']['position'] }}</p>--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <p class="mr-2">{{ $playerData['player']['country']['alpha2'] }}</p>--}}
{{--                                            <img src="{{ asset('flags/' . $playerData['player']['country']['name'] . '.svg') }}" alt="{{ $playerData['player']['country']['name'] }}" class="rounded" width="16" height="16">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="p-2">Midfielder</div>--}}
{{--                    <div class="flex p-2 flex-wrap gap-3">--}}
{{--                        @foreach ($players['data']['players'] as $playerData)--}}
{{--                            @if (isset($playerData['player']['position']) && $playerData['player']['position'] === 'M')--}}
{{--                                <div class="w-1/6 p-4 border rounded text-center relative bg-gray-100">--}}
{{--                                    @if (isset($playerPhotos[$playerData['player']['id']]))--}}
{{--                                        <div class="relative">--}}
{{--                                            <img src="{{ $playerPhotos[$playerData['player']['id']] }}" alt="{{ $playerData['player']['id'] }} Logo" class="mb-2 rounded-full mx-auto" width="63" height="63">--}}
{{--                                            @if (isset($playerData['player']['jerseyNumber']))--}}
{{--                                                <span class="absolute bottom-0 right-1 bg-gray-600 text-white p-1 rounded text-xs">{{ $playerData['player']['jerseyNumber'] }}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <p>No photo available</p>--}}
{{--                                    @endif--}}
{{--                                    <p>{{ $playerData['player']['name'] }}</p>--}}
{{--                                    <div class="flex justify-between items-center">--}}
{{--                                        <p class="mr-2">{{ $playerData['player']['position'] }}</p>--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <p class="mr-2">{{ $playerData['player']['country']['alpha2'] }}</p>--}}
{{--                                            <img src="{{ asset('flags/' . $playerData['player']['country']['name'] . '.svg') }}" alt="{{ $playerData['player']['country']['name'] }}" class="rounded" width="16" height="16">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}

{{--                    <div class="p-2">Defender</div>--}}
{{--                    <div class="flex p-2 flex-wrap gap-3">--}}
{{--                        @foreach ($players['data']['players'] as $playerData)--}}
{{--                            @if (isset($playerData['player']['position']) && $playerData['player']['position'] === 'D')--}}
{{--                                <div class="w-1/6 p-4 border rounded text-center relative bg-gray-100">--}}
{{--                                    @if (isset($playerPhotos[$playerData['player']['id']]))--}}
{{--                                        <div class="relative">--}}
{{--                                            <img src="{{ $playerPhotos[$playerData['player']['id']] }}" alt="{{ $playerData['player']['id'] }} Logo" class="mb-2 rounded-full mx-auto" width="63" height="63">--}}
{{--                                            @if (isset($playerData['player']['jerseyNumber']))--}}
{{--                                                <span class="absolute bottom-0 right-1 bg-gray-600 text-white p-1 rounded text-xs">{{ $playerData['player']['jerseyNumber'] }}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <p>No photo available</p>--}}
{{--                                    @endif--}}
{{--                                    <p>{{ $playerData['player']['name'] }}</p>--}}
{{--                                    <div class="flex justify-between items-center">--}}
{{--                                        <p class="mr-2">{{ $playerData['player']['position'] }}</p>--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <p class="mr-2">{{ $playerData['player']['country']['alpha2'] }}</p>--}}
{{--                                            <img src="{{ asset('flags/' . $playerData['player']['country']['name'] . '.svg') }}" alt="{{ $playerData['player']['country']['name'] }}" class="rounded" width="16" height="16">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="p-2">Goalkeeper</div>--}}
{{--                    <div class="flex p-2 flex-wrap gap-3">--}}
{{--                        @foreach ($players['data']['players'] as $playerData)--}}
{{--                            @if (isset($playerData['player']['position']) && $playerData['player']['position'] === 'G')--}}
{{--                                <div class="w-1/6 p-4 border rounded text-center relative bg-gray-100">--}}
{{--                                    @if (isset($playerPhotos[$playerData['player']['id']]))--}}
{{--                                        <div class="relative">--}}
{{--                                            <img src="{{ $playerPhotos[$playerData['player']['id']] }}" alt="{{ $playerData['player']['id'] }} Logo" class="mb-2 rounded-full mx-auto" width="63" height="63">--}}
{{--                                            @if (isset($playerData['player']['jerseyNumber']))--}}
{{--                                                <span class="absolute bottom-0 right-1 bg-gray-600 text-white p-1 rounded text-xs">{{ $playerData['player']['jerseyNumber'] }}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <p>No photo available</p>--}}
{{--                                    @endif--}}
{{--                                    <p>{{ $playerData['player']['name'] }}</p>--}}
{{--                                    <div class="flex justify-between items-center">--}}
{{--                                        <p class="mr-2">{{ $playerData['player']['position'] }}</p>--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <p class="mr-2">{{ $playerData['player']['country']['alpha2'] }}</p>--}}
{{--                                            <img src="{{ asset('flags/' . $playerData['player']['country']['name'] . '.svg') }}" alt="{{ $playerData['player']['country']['name'] }}" class="rounded" width="16" height="16">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}

{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="w-2/5">--}}

{{--                <div class="bg-white rounded-xl shadow-xl mb-2">--}}
{{--                    <div class="p-2 font-bold">Season statistics</div>--}}
{{--                    <div class="p-2">HNL</div>--}}
{{--                    <div><livewire:dropdown-statistics :teamId="$id" :seasonId="$seasonId" :tournamentId="$tournamentId" />--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="bg-white rounded-xl shadow-xl mb-2">--}}
{{--                    <div class="p-2 font-bold">Season statistics</div>--}}
{{--                    <div class="p-2">HNL</div>--}}
{{--                    <div><livewire:player-sesone-statistics :teamId="$id" :seasonId="$seasonId" :tournamentId="$tournamentId" :playerPhotos="$playerPhotos" />--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--<div class="bg-white rounded-xl shadow-xl mb-2">--}}
{{--                    <div class="p-2 font-bold">Media</div>--}}
{{--                    <div>--}}
{{--                        <ul class="p-2">--}}
{{--                            @foreach (array_reverse($mediaInfo['data']) as $video)--}}
{{--                                <li class="flex mb-2">--}}
{{--                                    --}}{{----}}{{-- Prikaz sličice videozapisa --}}{{----}}{{----}}
{{--                                    <div class="mr-4">--}}
{{--                                        <img src="{{ $video['thumbnailUrl'] }}" alt="{{ $video['title'] }}" height="80" width="144">--}}
{{--                                    </div>--}}
{{--                                    --}}{{----}}{{-- Prikaz naslova i poveznice do videa --}}{{----}}{{----}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        <div>{{ $video['title'] }}</div>--}}
{{--                                        <div>{{ $video['subtitle'] }}</div>--}}
{{--                                        <div>--}}
{{--                                            <a href="{{ $video['url'] }}" target="_blank" class="text-blue-500 hover:underline">Watch Video</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection



