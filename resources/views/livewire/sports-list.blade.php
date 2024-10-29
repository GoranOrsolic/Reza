<div class="flex justify-center p-4 text-white">
    <div class="flex space-x-4">
        <ul class="flex justify-around space-x-4">
            @foreach($topSports as $sport)
                <li class="flex flex-col items-center">
                    @php
                        // Definiši naziv rute za svaki sport
                        $routeName = '#'; // Podrazumevani link (bez linka)
                        if ($sport['name'] == 'Football') {
                            $routeName = route('index');
                        } elseif ($sport['name'] == 'Basketball') {
                            $routeName = route('basketball');
                        }
                        // Dodaj više uslova ako imaš više sportova sa specifičnim rutama
                    @endphp

                    @if($routeName != '#')
                        <a href="{{ $routeName }}" class="flex flex-col items-center">
                            <i class="fas {{ getSportIcon($sport['name']) }}"></i>
                            <span class="mt-1">{{ $sport['name'] }}</span>
                        </a>
                    @else
                        <div class="flex flex-col items-center">
                            <i class="fas {{ getSportIcon($sport['name']) }}"></i>
                            <span class="mt-1">{{ $sport['name'] }}</span>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="relative" x-data="{ openDropdown: false }">
        <button @click="openDropdown = !openDropdown" class="bg-blue-700 text-white rounded ml-4 flex flex-col items-center">
            <i class="fas fa-ellipsis"></i>
            <span class="mt-1">More</span>
        </button>
        <ul x-show="openDropdown" class="absolute bg-blue-700 text-white mt-2 rounded w-64" @click.away="openDropdown = false">
            @foreach($dropdownSports as $sport)
                <li class="px-4 py-2">
                    @php
                        $routeName = '#';
                        if ($sport['name'] == 'Football') {
                            $routeName = route('index');
                        } elseif ($sport['name'] == 'Basketball') {
                            $routeName = route('basketball');
                        }
                        // Dodaj više uslova ako je potrebno
                    @endphp
                    <a href="{{ $routeName }}" class="flex items-center">
                        <i class="fas {{ getSportIcon($sport['name']) }}"></i>
                        <span class="ml-2">{{ $sport['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
