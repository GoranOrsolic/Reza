@extends('layouts.main')
@section('content')

    <div class="container mx-auto">
    <div class="flex gap-6 mt-5 ">
        <div class="w-1/4 bg-white rounded-xl shadow-xl">
            <livewire:dropdown-component />
        </div>
        <div class="w-2/4 bg-white p-3 rounded-xl shadow-xl">
            <livewire:toggle-button wire:init="initialize" />
        </div>
        <div class="w-1/4 bg-white p-3 rounded-xl shadow-xl">
            @foreach ($sports as $sport)
                <a href="{{ route('sport', $sport['id']) }}"> name: {{ $sport['name']}}
                    id: {{ $sport['id']}}
                    <br /></a>
            @endforeach

        </div>

    </div>
</div>
@endsection
