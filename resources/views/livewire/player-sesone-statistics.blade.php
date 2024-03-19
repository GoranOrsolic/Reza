<div>
    <div class="p-2">
        <select wire:model="selectedKey" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-400">
            @foreach ($playerStatistics['data'] as $key => $value)
                @php
                    $prettyKeys = [
                        'rating' => 'Rating',
                        'goals' => 'Goals',
                        'assists' => 'Assists',
                        'goalsAssistsSum' => 'Goals + Assists',
                        'penaltyGoals' => 'Penalty goals',
                        'freeKickGoal' => 'Free kick goals',
                        'scoringFrequency' => 'Scoring frequency',
                        'totalShots' => 'Total shots',
                        'shotsOnTarget' => 'Shots on target',
                        'bigChancesMissed' => 'Big chances missed',
                        'bigChancesCreated' => 'Big chances created',
                        'accuratePasses' => 'Accurate passes',
                        'keyPasses' => 'Key passes',
                        'accurateLongBalls' => 'Accurate long balls',
                        'successfulDribbles' => 'Successful dribbles',
                        'penaltyWon' => 'Penalty won',
                        'tackles' => 'Tackles',
                        'interceptions' => 'Interceptions',
                        'clearances' => 'Clearances',
                        'possessionLost' => 'Possession lost',
                        'yellowCards' => 'Yellow cards',
                    ];
                @endphp
                <option value="{{ $key }}">{{ $prettyKeys[$key] ?? $key }}</option>
            @endforeach
        </select>
    </div>
    @if ($selectedKey && isset($playerStatistics['data'][$selectedKey]))
        <div>
            <ul class="p-2">
                @php $counter = 1; @endphp
                @foreach (array_slice($playerStatistics['data'][$selectedKey], 0, 10) as $player)
                    <li class="flex mb-2">
                        {{-- Broj --}}
                        <div class="mr-4">{{ $counter++ }}</div>
                        {{-- Dodaj fotografiju igrača --}}
                        <div class="mr-4">
                            @if(isset($playerPhotos[$player['player']['id']]))
                                <img src="{{ $playerPhotos[$player['player']['id']] }}" alt="{{ $player['player']['name'] }}" class="rounded-full" width="38" height="38">
                            @else
                                <img src="placeholder.jpg" alt="{{ $player['player']['name'] }}" class="w-12 h-12 rounded-full">
                            @endif
                        </div>
                        {{-- Ime igrača --}}
                        <div class="flex flex-col">
                            <div>
                                {{ $player['player']['name'] }}
                            </div>
                            <div>
                                {{ $player['player']['position'] }}
                            </div>
                        </div>
                        {{-- Prikazivanje dodatnih podataka ako postoje --}}
                        @if (isset($player['statistics']))
                            @foreach ($player['statistics'] as $statKey => $statValue)
                                @unless (in_array($statKey, ['id', 'type', 'appearances']))
                                    <div class="ml-auto">
                                        @if ($selectedKey === 'rating' && $statKey === 'rating')
                                            {{ sprintf("%.2f", $statValue) }}
                                        @elseif ($selectedKey === 'scoringFrequency' && $statKey === 'scoringFrequency')
                                            {{ sprintf("%.2f", $statValue) }}
                                        @elseif ($selectedKey === 'accuratePasses' && $statKey === 'accuratePasses')
                                            {{ sprintf("%.2f", $statValue) }}
                                        @elseif ($selectedKey === 'successfulDribbles' && $statKey === 'successfulDribbles')
                                            {{ sprintf("%.2f", $statValue) }}
                                        @else
                                            {{ $statValue }}
                                        @endif
                                    </div>
                                @endunless
                            @endforeach
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
