<div class="container">
    @foreach($dat as $info)

                <div class="d-flex flex-row align-items-center">
                <div><img src="{{$base64}}" alt=""></div>
                    <div>{{$info['name']}}</div>
                </div>


            @foreach($players as $count)
    <div class="d-flex flex-row">
        <div class="col width: 50%">
                <div class="d-flex flex-wrap justify-content-around">
                <div class="width: 50%">Total players: {{count($count['players'])}}</div>
                <div class="width: 50%">Foreign players: {{count($count['foreignPlayers'])}}</div>
                <div class="width: 50%">National team players: {{count($count['nationalPlayers'])}}</div>
            {{--@foreach($count['players'] as $age)
                {{\Carbon\Carbon::parse($age['player']['dateOfBirthTimestamp'])->age}}
            @endforeach--}}
                </div>

            @endforeach

    <div>
        <div class="d-flex justify-content-between">Coach: <div>{{$info['manager']['name']}}</div> </div>

        <div class="d-flex justify-content-between">Foundation date:  <div>{{\Carbon\Carbon::parse($info['foundationDateTimestamp'])->format('d/m/Y')}}</div></div>

        <div class="d-flex justify-content-between">Country: <div> {{$info['category']['name']}}</div></div>

        <div class="d-flex justify-content-between">Stadium: <div> {{$info['venue']['stadium']['name']}}</div></div>

        <div class="d-flex justify-content-between">Capacity:  <div>{{$info['venue']['stadium']['capacity']}}</div></div>

        <div class="d-flex justify-content-between">City:  <div>{{$info['venue']['city']['name']}}, {{$info['venue']['country']['name']}}</div></div>

    </div>
    </div>
    @endforeach
    <div class="col">
    @foreach($transfers as $trans)
    <div class="d-flex pb-4">
        <div class="pr-5">
        @foreach($trans['transfersIn'] as $tra)
            <div>{{$tra['player']['name']}}</div>
        @endforeach
        </div>
        <div class="pl-5">
        @foreach($trans['transfersOut'] as $tra)
            <div>{{$tra['player']['name']}}</div>
        @endforeach
        </div>
    </div>

    @endforeach
        <div>
                <div class="d-flex flex-wrap justify-content-around">
                @foreach($tournaments['data'] as $tournament)
                  <div>{{$tournament['name']}}</div>
                @endforeach
                </div>
        </div>
    </div>
</div>
            @foreach($eventsNext as $nextEvent)
                @foreach($nextEvent['events'] as $nexte)
                    {{\Carbon\Carbon::parse($nexte['startTimestamp'])->format('d/m/Y')}}
                    {{$nexte['homeTeam']['name']}}
                vs
                    {{$nexte['awayTeam']['name']}}
                    <br>
                @endforeach
            @endforeach
<br>
            @foreach($eventsLast as $lastEvent)
                @foreach($lastEvent['events'] as $last)
                    {{\Carbon\Carbon::parse($last['startTimestamp'])->format('d/m/Y')}}
                    {{$last['homeTeam']['name']}}
                    @if(isset($last['homeScore']['current']))
                        {{ $last['homeScore']['current'] }}
                    @else
                        N/A
                    @endif
                    vs
                    {{$last['awayTeam']['name']}}
                    @if(isset($last['awayScore']['current']))
                        {{ $last['awayScore']['current'] }}
                    @else
                        N/A
                    @endif
                    <br>
                @endforeach
            @endforeach


            <a href="team/football/page/{{$next}}">Next</a>

</div>




