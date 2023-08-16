<?php

function getSportIcon($sportName)
{
$icons = [
'Football' => 'fa-futbol',
'Basketball' => 'fa-basketball-ball',
'Tennis' => 'fa-solid fa-table-tennis-paddle-ball',
'Ice Hockey' => 'fa-solid fa-hockey-puck',
'Handball' => 'fa-futbol',
'Floorball' => 'fa-futbol',
'Motorsport' => 'fa-solid fa-motorcycle',
'Rugby' => 'fa-solid fa-football',
'Aussie rules' => 'fa-solid fa-football',
'Bandy' => 'fa-solid fa-hockey-puck',
'Snooker' => '"fa-solid fa-bowling-ball',
'Table tennis' => 'fa-solid fa-table-tennis-paddle-ball',
'Darts' => 'fa-solid fa-bullseye',
'Volleyball' => 'fa-solid fa-volleyball',
'Cricket' => 'fa-solid fa-baseball-bat-ball',
'American Football' => 'fa-solid fa-football',
'Baseball' => 'fa-solid fa-baseball',
'Waterpolo' => 'fa-solid fa-person-swimming',
'Futsal' => 'fa-futbol',
'Badminton' => 'fa-solid fa-table-tennis-paddle-ball',
'Beach Volley' => 'fa-solid fa-volleyball',
'eSports' => 'fa-solid fa-gamepad',





// Dodajte ikone za ostale sportove ovde...
];

return $icons[$sportName] ?? 'fa-sport';
}
