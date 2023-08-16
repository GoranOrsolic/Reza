<div class="flex justify-center p-4 text-white">
    <div class="flex space-x-4">
        <ul class="flex justify-around space-x-4">
            @foreach($topSports as $sport)
                <li class="flex flex-col items-center">
                    <i class="fas {{ getSportIcon($sport['name']) }}"></i>
                    <span class="mt-1">{{ $sport['name'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="relative" x-data="{ openDropdown: false }">
        <button @click="openDropdown = !openDropdown" class="bg-blue-700 text-white rounded ml-4 flex flex-col items-center">
            <i class="fas fa-ellipsis"></i> <!-- Ikona se nalazi iznad teksta -->
            <span class="mt-1">More</span> <!-- Tekst se nalazi ispod ikone -->
        </button>
        <ul x-show="openDropdown" class="absolute bg-blue-700 text-white mt-2 rounded w-64" @click.away="openDropdown = false">
            @foreach($dropdownSports as $sport)
                <li class="px-4 py-2">
                    <i class="fas {{ getSportIcon($sport['name']) }}"></i>
                    <span class="ml-2">{{ $sport['name'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
