<div>
    @if ($updating)
        <p>Loading...</p>
    @else
        <!-- Prikaz utakmica -->
        @foreach($allEvents as $event)
            {{ \Carbon\Carbon::parse($event['startTimestamp'])->format('d/m/Y') }}
            {{ $event['homeTeam']['name'] }}

            @if(isset($event['homeScore']['current']))
                {{ $event['homeScore']['current'] }}
            @else
                N/A
            @endif

            vs

            {{ $event['awayTeam']['name'] }}

            @if(isset($event['awayScore']['current']))
                {{ $event['awayScore']['current'] }}
            @else
                N/A
            @endif

            <br><br>
        @endforeach

        <!-- Gumbi za prebacivanje između stranica -->
        <div class="navigation-buttons">
            @if ($currentPage > 1)
                <button wire:click="previous" wire:loading.attr="disabled" class="btn btn-primary">Previous</button>
            @endif

            @if ($currentPage < $allEventsPages)
                <button wire:click="next" wire:loading.attr="disabled" class="btn btn-primary">Next</button>
            @endif
        </div>
    @endif
</div>
