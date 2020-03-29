<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('dashboard.home'));
});

// Home > Users
Breadcrumbs::for('user', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('dashboard.user.index'));
});

Breadcrumbs::for('user_add', function ($trail) {
    $trail->parent('user');
    $trail->push('User Add', route('dashboard.user.create'));
});

Breadcrumbs::for('user_show', function ($trail, $user) {
    $trail->parent('user');
    $trail->push($user->username, route('dashboard.user.show', $user->slug));
});

Breadcrumbs::for('user_edit', function ($trail, $user) {
    $trail->parent('user');
    $trail->push($user->username, route('dashboard.user.edit', $user->slug));
});