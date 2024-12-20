<div>
    <div class="p-2">
        <select wire:model="selectedKey" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-400">
            @foreach ($playerStatistics['data'] as $key => $value)
                @php
                    $prettyKeys = [
                        'points' => 'Points',
                        'rebounds' => 'Rebounds',
                        'assists' => 'Assists',
                        'fieldGoalsPercentage' => 'Field goals percentage',
                        'freeThrowsPercentage' => 'Free throws percentage',
                        'threePointsPercentage' => 'Three point percentage',
                        'threePointsMade' => '3 pointers',
                        'defensiveRebounds' => 'Defensive rebounds',
                        'offensiveRebounds' => 'Offensive rebounds',
                        'steals' => 'Steals',
                        'turnovers' => 'Turnovers',
                        'blocks' => 'Blocks',
                        'plusMinus' => '+/-',
                        'pointsAgainst' => 'Points allowed',
                        'fieldGoalsPercentageAgainst' => 'Field goals percentage allowed',
                        'threePointsPercentageAgainst' => 'Three point percentage allowed   ',
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
                            @if(isset($playerPhotos[$player['team']['id']]))
                                <img src="{{ $playerPhotos[$player['team']['id']] }}" alt="{{ $player['team']['name'] }}" class="rounded-full" width="38" height="38">
                            @else
                                <img src="placeholder.jpg" alt="{{ $player['team']['name'] }}" class="w-12 h-12 rounded-full">
                            @endif
                        </div>
                        {{-- Ime team --}}
                        <div>
                            {{ $player['team']['name'] }}
                        </div>
                        {{-- Prikazivanje dodatnih podataka ako postoje --}}
                        @if (isset($player['statistics']))
                            <div class="ml-auto">
                            @foreach ($player['statistics'] as $statKey => $statValue)
                                @unless (in_array($statKey, ['id', 'type', 'matches']))
                                        @if ($statKey === 'points' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'pointsAgainst' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'rebounds' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($selectedKey === 'fieldGoalsPercentage' && $statKey === 'fieldGoalsPercentage')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($selectedKey === 'fieldGoalsPercentageAgainst' && $statKey === 'fieldGoalsPercentageAgainst')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($selectedKey === 'freeThrowsPercentage' && $statKey === 'freeThrowsPercentage')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($selectedKey === 'threePointsPercentage' && $statKey === 'threePointsPercentage')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($selectedKey === 'threePointsPercentageAgainst' && $statKey === 'threePointsPercentageAgainst')
                                            {{ sprintf("%.1f", $statValue) }}
                                        @elseif ($statKey === 'assists' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($selectedKey === 'threePointsMade' && $statKey === 'threePointsMade')
                                            {{ sprintf($statValue) }}
                                        @elseif ($statKey === 'defensiveRebounds' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'offensiveRebounds' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'steals' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'turnovers' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'blocks' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @elseif ($statKey === 'plusMinus' && isset($player['statistics']['matches']) && $player['statistics']['matches'] > 0)
                                            {{ sprintf("%.1f", $statValue / $player['statistics']['matches']) }}
                                        @endif
                                @endunless
                            @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
