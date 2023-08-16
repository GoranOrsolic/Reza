<div>
    <h3 class="pl-5 mb-2 font-bold">All leagues</h3>
    @foreach($categories as $category)
        <div class="mb-4">
            <h3 class="flex items-center cursor-pointer pl-5 pr-5 justify-between" wire:click="toggleCategory({{ $category['id'] }})">
                @if(file_exists(public_path('flags/' . $category['flag'] . '.svg')))
                    <img src="{{ asset('flags/' . $category['flag'] . '.svg') }}" alt="{{ $category['name'] }}" class="ml-2 rounded" width="24" height="24" >
                @endif

               <span class="ml-3"> {{ $category['name'] }}</span>

                <span class="ml-auto">
                     @if(in_array($category['id'], $selectedCategories))
                        <i class="fa fa-angle-up"></i>
                    @else
                        <i class="fa fa-angle-down"></i>
                    @endif
                 </span>

            </h3>
            @if(in_array($category['id'], $selectedCategories))
                @if(count($tournaments[$category['id']]) > 0)
                    <ul class="cursor-pointer justify-center">
                        @foreach($tournaments[$category['id']] as $tournament)
                            <li class="bg-slate-200 hover:bg-slate-300 w-full text-center">
                                <a href="{{ route('standings', ['tournamentId' => $tournament['id']]) }}">{{ $tournament['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-red-500">No tournaments available for this category.</p>
                @endif
            @endif
        </div>
    @endforeach
</div>
