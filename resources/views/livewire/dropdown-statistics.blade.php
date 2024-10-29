<div class="mt-2">
    @foreach(array_keys($options) as $category)
        <h2 class="cursor-pointer p-2 flex items-center justify-between font-bold border-t border-b hover:bg-gray-100" wire:click="selectCategory('{{ $category }}')">
            <span class="mr-2">{{ $category }}</span>
            <i class="fa @if($isOpen && $selectedCategory === $category) fa-angle-up @else fa-angle-down @endif"></i>
        </h2>
        @if($isOpen && $selectedCategory === $category)
            <ul class="p-2">
                @foreach($options[$category] as $option)
                    <li class="mb-2 flex justify-between">
                        @php
                            // Mapiranje ključa na prikazanu vrijednost
                            $displayKey = [
                                'matches' => 'Matches',
                                'goalsScored' => 'Goals Scored',
                                'goalsConceded' => 'Goals conceded',
                                'assists' => 'Assists',
                                'penaltyGoals' => 'Penalty goals',
                                'freeKickGoals' => 'Free kick goals',
                                'goalsFromInsideTheBox' => 'Goals from inside the box',
                                'goalsFromOutsideTheBox' => 'Goals from outside the box',
                                'leftFootGoals' => 'Left foot goals',
                                'rightFootGoals' => 'Right foot goals',
                                'headedGoals' => 'Headed goals',
                                'hitWoodwork' => 'Hit woodwork',
                                'averageBallPossession' => 'Ball possession',
                                'accuratePassesPercentage' => 'Accurate per game',
                                'accurateOwnHalfPassesPercentage' => 'Acc. own half',
                                'accurateOppositionHalfPassesPercentage' => 'Acc. opposition half',
                                'accurateLongBallsPercentage' => 'Acc. long balls',
                                'accurateCrossesPercentage' => 'Acc. crosses',
                                'cleanSheets' => 'Clean sheets',
                                'errorsLeadingToShot' => 'Errors leading to shot',
                                'errorsLeadingToGoal' => 'Errors leading to goal',
                                'penaltiesCommited' => 'Penalties committed',
                                'penaltyGoalsConceded' => 'Penalty goals conceded',
                                'clearancesOffLine' => 'Clearance off line',
                                'lastManTackles' => 'Last man tackle',
                                'yellowCards' => 'Yellow cards',
                                'redCards' => 'Red cards',
                            ][$option] ?? $option;

                            // Provjeri je li ključ uključen u popis postotnih ključeva
                            $percentageKeys = [
                                'averageBallPossession',
                                'accuratePassesPercentage',
                                'accurateOwnHalfPassesPercentage',
                                'accurateOppositionHalfPassesPercentage',
                                'accurateLongBallsPercentage',
                                'accurateCrossesPercentage',
                            ];

                            // Provjeri postoji li ključ prije nego što mu pristupimo
                            $value = $seasonStats['data'][$option] ?? null;

                            // Primijeni postotni format ako je ključ u popisu postotnih ključeva
                            $formattedValue = $value !== null
                                ? (in_array($option, $percentageKeys)
                                    ? number_format($value, 2) . '%'
                                    : number_format($value, 0))
                                : 'N/A';
                        @endphp

                        <span>{{ $displayKey }}:</span>
                        <span>{{ $formattedValue }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    @endforeach
</div>
