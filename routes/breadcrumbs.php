<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Usuarios', route('users'));
});
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('roles'));
});
Breadcrumbs::for('programacion_medio_plazo', function ($trail) {
    $trail->parent('home');
    $trail->push('Programacion Mediano Plazo', route('programacion_medio_plazo'));
});