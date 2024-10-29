<div class="toggle-container">
    <div class="flex space-x-4 mb-4 items-center">
        <label class="flex items-center space-x-2 cursor-pointer transition duration-300 ease-in-out transform hover:scale-110">
            <input type="radio" wire:model="showContent1" value="1" class="hidden">
            <span class="bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center {{ $showContent1 == 1 ? 'text-white bg-blue-500' : 'text-gray-500' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </span>
            <span class="{{ $showContent1 == 1 ? 'text-blue-500' : 'text-gray-700' }}">All</span>
        </label>

        <label class="flex items-center space-x-2 cursor-pointer transition duration-300 ease-in-out transform hover:scale-110">
            <input type="radio" wire:model="showContent1" value="0" class="hidden">
            <span class="bg-red-500 rounded-full w-8 h-8 flex items-center justify-center {{ $showContent1 == 0 ? 'text-white bg-red-500' : 'text-gray-500' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16z" />
        </svg>
    </span>
            <span class="{{ $showContent1 == 0 ? 'text-red-500' : 'text-gray-700' }}">Live</span>
        </label>
    </div>
    <div class="content1" @if($showContent1) style="display:block" @else style="display:none" @endif>
        @if($todayMatch)
            @foreach($todayMatch as $todayMatchs)
                @foreach($todayMatchs as $tMatchs)
                    {{ $tMatchs['tournament']['category']['name'] }} <br />
                    {{ $tMatchs['tournament']['name'] }}<br />
                    <div class="flex p-3 bg-white">
                        <div class="">
                            {{ \Carbon\Carbon::parse($tMatchs['startTimestamp'])->format('H:i') }}<br/>
                            {{--{{ \Carbon\Carbon::parse($tMatchs['time']['currentPeriodStartTimestamp'])->format('H:i') }}--}}
                        </div>
                        <div class="border mr-3 ml-3 border-gray-400"></div>
                        <div class="">
                            {{ $tMatchs['homeTeam']['name'] }}<br />
                            {{ $tMatchs['awayTeam']['name'] }}<br />
                        </div>
                        <div class="ml-auto">
                            @if(isset($tMatchs['homeScore']['current']))
                                {{ $tMatchs['homeScore']['current'] }}<br />
                            @endif
                            @if(isset($tMatchs['awayScore']['current']))
                                {{ $tMatchs['awayScore']['current'] }}<br />
                            @endif
                        </div>

                    </div>
                @endforeach
            @endforeach
        @endif
    </div>
    <div class="content2" @unless($showContent1) style="display:block" @else style="display:none" @endif>
        @if($liveMatch)
            @foreach ($liveMatch as $matchs)
                @foreach($matchs as $match )
                    {{ $match['tournament']['category']['name'] }} <br />
                    {{ $match['tournament']['name'] }}<br />
                    <div class="flex p-3 bg-white">
                        <div class="">
                            {{ \Carbon\Carbon::parse($match['startTimestamp'])->format('H:i') }}<br/>
                            {{--{{ \Carbon\Carbon::parse($match['time']['currentPeriodStartTimestamp'])->format('H:i') }}--}}
                        </div>
                        <div class="border mr-3 ml-3 border-gray-400"></div>
                        <div class="">
                            {{ $match['homeTeam']['name'] }}<br />
                            {{ $match['awayTeam']['name'] }}<br />
                        </div>
                        <div class="ml-auto" style="color: red">
                            {{ $match['homeScore']['display'] }}<br />
                            {{ $match['awayScore']['display'] }}<br />

                        </div>

                    </div>

                @endforeach
            @endforeach
        @endif
    </div>
</div>
