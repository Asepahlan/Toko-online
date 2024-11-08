<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\View\Composers\AdminDashboardComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cart count composer untuk semua view
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = Session::get('cart', []);
                foreach($cart as $quantity) {
                    $cartCount += (int)$quantity;
                }
            }

            $view->with('cartCount', $cartCount);
        });

        // Admin dashboard composer untuk semua view yang menggunakan layout admin
        View::composer(['layouts.admin', 'admin.*'], AdminDashboardComposer::class);
    }
}
