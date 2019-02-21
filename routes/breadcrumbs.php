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
Breadcrumbs::for('programacion_medio_plazo_nuevo', function ($trail) {
   
    $trail->parent('programacion_medio_plazo');
    $trail->push('Nuevo', route('medio_plazo_nuevo'));
});

Breadcrumbs::for('programacion_corto_plazo', function ($trail) {
    $trail->parent('home');
    $trail->push('Programacion Corto Plazo', route('programacion_corto_plazo'));
});
Breadcrumbs::for('programacion_corto_plazo_nuevo', function ($trail) {
   
    $trail->parent('programacion_corto_plazo');
    $trail->push('Nuevo', route('corto_plazo_nuevo'));
});
Breadcrumbs::for('operaciones', function ($trail) {
    $trail->parent('home');
    $trail->push('Operaciones', route('operaciones'));
});