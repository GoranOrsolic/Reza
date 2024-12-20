<div>
    <div class="p-2">
        <select wire:model="selectedKey" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-400">
            @foreach ($playerStatistics['data'] as $key => $value)
                @php
                    $prettyKeys = [
                        'points' => 'Points',
                        'rebounds' => 'Rebounds',
                        'assists' => 'Assists',
                        'secondsPlayed' => 'Minutes per game',
                        'fieldGoalsPercentage' => 'Field goals percentage',
                        'freeThrowsPercentage' => 'Free throws percentage',
                        'threePointsPercentage' => 'Three point percentage',
                        'threePointsMade' => '3 pointers',
                        'defensiveRebounds' => 'Defensive rebounds',
                        'offensiveRebounds' => 'Offensive rebounds',
                        'steals' => 'Steals',
                        'turnovers' => 'Turnovers',
                        'blocks' => 'Blocks',
                        'assistTurnoverRatio' => 'Assist to Turnover Ratio',
                        'plusMinus' => '+/- per game',
                        'doubleDoubles' => 'Double doubles',
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
                @foreach (array_slice($playerStatistics['data'][$selectedKey], 0, 5) as $player)
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
                                        @if ($statKey === 'points' && isset($player['statistics']['appearances']) && $player['statistics']['appearances'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['appearances']) }}
                                        @elseif ($statKey === 'fieldGoalsPercentage')
                                            @php
                                                $fieldGoalsMadePerAppearance = $player['statistics']['fieldGoalsMade'] / $player['statistics']['appearances'];
                                                $fieldGoalsPercentage = floor($statValue);
                                            @endphp
                                            {{ $fieldGoalsPercentage }}%
                                            ({{ sprintf("%.1f", $fieldGoalsMadePerAppearance) }})
                                        @elseif ($statKey === 'freeThrowsPercentage')
                                            @php
                                                $freeThrowsPercentage = $player['statistics']['freeThrowsMade'] / $player['statistics']['appearances'];
                                                $freeThrowsPre = floor($statValue);
                                            @endphp
                                            {{ $freeThrowsPre }}%
                                            ({{ sprintf("%.1f", $freeThrowsPercentage) }})
                                        @elseif ($statKey === 'threePointsPercentage')
                                            @php
                                                $threePointsPercentage = $player['statistics']['threePointsMade'] / $player['statistics']['appearances'];
                                                $threePointsPre = floor($statValue);
                                            @endphp
                                            {{ $threePointsPre }}%
                                            ({{ sprintf("%.1f", $threePointsPercentage) }})
                                        @elseif ($selectedKey === 'assistTurnoverRatio' && $statKey === 'assistTurnoverRatio')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($selectedKey === 'rebounds' && $statKey === 'rebounds')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'assists' && $statKey === 'assists')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'threePointsMade' && $statKey === 'threePointsMade')
                                            {{ sprintf($statValue) }}
                                        @elseif ($selectedKey === 'defensiveRebounds' && $statKey === 'defensiveRebounds')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'offensiveRebounds' && $statKey === 'offensiveRebounds')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'steals' && $statKey === 'steals')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'turnovers' && $statKey === 'turnovers')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'blocks' && $statKey === 'blocks')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'assistTurnoverRatio' && $statKey === 'assistTurnoverRatio')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'plusMinus' && $statKey === 'plusMinus')
                                            {{ sprintf("%.1f", $statValue / 10) }}
                                        @elseif ($selectedKey === 'secondsPlayed' && $statKey === 'secondsPlayed')
                                            @php
                                                $statValue = $statValue / 10;
                                            @endphp
                                            {{ intdiv($statValue, 60) . ':' . sprintf('%02d', $statValue % 60) }}
                                        @else
                                            @if (!in_array($statKey, ['fieldGoalsMade', 'freeThrowsMade', 'threePointsMade']))
                                                {{ $statValue }}
                                            @endif
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
