<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
 
Breadcrumbs::for('stars', function (BreadcrumbTrail $trail): void {
    $trail->push(ucfirst(Request::segment(3)), route('stars', Request::segment(3)));
});
Breadcrumbs::for('influencers', function (BreadcrumbTrail $trail): void {
    $trail->push(ucfirst(Request::segment(2)), route('home'));
    $trail->push(ucfirst(Request::segment(3)), Route::currentRouteName());
});
Breadcrumbs::for('influencerDetail', function (BreadcrumbTrail $trail, $user): void {
    $trail->push(ucfirst($user->primary_platform), route('influencerDetail', $user->id));
    $trail->push(ucfirst($user->name));
});
Breadcrumbs::for('search', function (BreadcrumbTrail $trail): void {
    $trail->push('Search');
});
Breadcrumbs::for('order-info', function (BreadcrumbTrail $trail, $user): void {
    $trail->parent('influencerDetail', $user);
    $trail->push('Order Information');
});
Breadcrumbs::for('payment-detail', function (BreadcrumbTrail $trail, $user): void {
    $trail->parent('order-info', $user);
    $trail->push('Payment Details');
});
Breadcrumbs::for('paypal-payment', function (BreadcrumbTrail $trail, $user): void {
    $trail->parent('influencerDetail', $user);
    $trail->push('Paypal Payment');
});