<div class="w-full max-w-4xl mx-auto mt-10 p-4 bg-white shadow-md rounded">
    <!-- Učitavanje podataka -->
    @if($loading)
        <div class="text-center text-gray-500">Učitavanje podataka...</div>
        <!-- Poruka o grešci -->
    @elseif($error)
        <div class="text-center text-red-500">{{ $error }}</div>
        <!-- Prikaz podataka -->
    @else
        <!-- Provjera ima li više od jednog ključa -->
        @if(count($data) > 1)
            <!-- Dropdown Meni -->
            <div class="mb-6">
                <label for="dropdown" class="block text-gray-700 text-sm font-bold mb-2">Odaberi konferenciju:</label>
                <select wire:model="selectedKey" id="dropdown" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($data as $item)
                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Prikaz Izabranih Podataka -->
        @if($selectedData)
            <div>
                <h2 class="text-2xl font-bold mb-4">{{ $selectedData['name'] }}</h2>
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2 text-start">Tim</th>
                            <th class="px-28"></th>
                            <th class="text-center px-2 py-2">Pobjede</th>
                            <th class="text-center px-2 py-2">Porazi</th>
                            <th class="text-center px-2 py-2">Postotak</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($selectedData['rows'] as $row)
                            <tr class="hover:bg-gray-100">
                                <td class="px-2 py-2">{{ $row['position'] }}</td>
                                <td class="px-2 py-2 text-start">{{ $row['team']['name'] }}</td>
                                <td class="px-28"></td>
                                <td class="text-center px-2 py-2">{{ $row['wins'] }}</td>
                                <td class="text-center px-2 py-2">{{ $row['losses'] }}</td>
                                <td class="text-center px-2 py-2">{{ number_format($row['percentage'] * 100, 2) }}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        @endif
    @endif
</div>