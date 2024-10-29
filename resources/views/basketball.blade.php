@extends('layouts.main')
@section('content')

    <div class="container mx-auto">
        <div class="flex gap-6 mt-5 ">
            <div class="w-1/4">
                <div class="bg-white rounded-xl shadow-xl pb-1">
                    <livewire:basketball-dropdown-component />
                </div>
            </div>
            <div class="w-2/4">
                <div class="bg-white p-3 rounded-xl shadow-xl">
                    <livewire:basketball-toggle-button wire:init="initialize" />
                </div>
            </div>
            <div class="w-1/4">
                <div class="bg-white p-3 rounded-xl shadow-xl">

            </div>

        </div>
    </div>
@endsection
