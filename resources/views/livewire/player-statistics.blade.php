<table class="min-w-full bg-white border border-gray-300">
    <thead>
    <tr>
        <th class="py-2 px-4 border bg-gray-100"> # </th>
        <th class="py-2 px-4 border bg-gray-100"> Team </th>
        <th class="py-2 px-4 border bg-gray-100"> Name </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('rating')"> Rating </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('goals')"> Golovi </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('assists')"> Assists </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('shotsOnTarget')"> Shots On Target </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('accuratePasses')"> Accurate Passes </th>
        <th class="py-2 px-4 border cursor-pointer bg-gray-100" wire:click="selectKey('successfulDribbles')"> Successful Dribbles </th>
        <!-- Dodajte ostale zaglavlje za druge ključeve -->
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        @foreach(collect($item[$selectedKey])->take(10) as $playerData)
            <tr>
                <td class="py-2 text-center px-4 border">{{ $loop->index + 1 }}</td>
                <td class="py-2 text-center px-4 border">{{ $playerData['team']['name'] }}</td>
                <td class="py-2 text-center px-4 border">{{ $playerData['player']['name'] }}</td>
                @if($selectedKey === 'rating')
                    <!-- Prikaz dodatnih podataka za 'rating' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $playerData['statistics']['rating']) }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['goals'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['assists'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['shotsOnTarget'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['accuratePasses'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['successfulDribbles'] ?? '' }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @elseif($selectedKey === 'goals')
                    <!-- Prikaz dodatnih podataka za 'goals' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $additionalData[$playerData['player']['id']]['data']['statistics']['rating'] ?? '') }}</td>
                    <td class="py-2 text-center px-4 border">{{ $playerData['statistics']['goals'] }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['assists'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['shotsOnTarget'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['accuratePasses'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['successfulDribbles'] ?? '' }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @elseif($selectedKey === 'assists')
                    <!-- Prikaz dodatnih podataka za 'assists' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $additionalData[$playerData['player']['id']]['data']['statistics']['rating'] ?? '') }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['goals'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $playerData['statistics']['assists'] }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['shotsOnTarget'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['accuratePasses'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['successfulDribbles'] ?? '' }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @elseif($selectedKey === 'shotsOnTarget')
                    <!-- Prikaz dodatnih podataka za 'shotsOnTarget' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $additionalData[$playerData['player']['id']]['data']['statistics']['rating'] ?? '') }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['goals'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['assists'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $playerData['statistics']['shotsOnTarget'] }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['accuratePasses'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['successfulDribbles'] ?? '' }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @elseif($selectedKey === 'accuratePasses')
                    <!-- Prikaz dodatnih podataka za 'accuratePasses' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $additionalData[$playerData['player']['id']]['data']['statistics']['rating'] ?? '') }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['goals'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['assists'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['shotsOnTarget'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $playerData['statistics']['accuratePasses'] }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['successfulDribbles'] ?? '' }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @elseif($selectedKey === 'successfulDribbles')
                    <!-- Prikaz dodatnih podataka za 'successfulDribbles' ključ -->
                    <td class="py-2 text-center px-4 border">{{ sprintf("%.2f", $additionalData[$playerData['player']['id']]['data']['statistics']['rating'] ?? '') }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['goals'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['assists'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['shotsOnTarget'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $additionalData[$playerData['player']['id']]['data']['statistics']['accuratePasses'] ?? '' }}</td>
                    <td class="py-2 text-center px-4 border">{{ $playerData['statistics']['successfulDribbles'] }}</td>
                    <!-- Dodajte ostale ćelije za druge dodatne informacije -->
                @endif
                <!-- Dodajte ostale ćelije za druge ključeve -->
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

