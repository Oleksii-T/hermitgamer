<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $route = auth()->user()->isAdmin()
                    ? 'admin.index'
                    : 'index';

                if (!$request->ajax()) {
                    return redirect()->route($route);
                }
                return response()->json([
                    'success' => true,
                    'data' => [
                        'redirect' => route($route)
                    ],
                    'message' => 'Logged in successfully'
                ]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // login config
        Fortify::loginView(function () {
            $page = \App\Models\Page::get('login');
            return view('auth.login', compact('page'));
        });
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(50)->by($email.$request->ip());
        });

        // register config
        Fortify::registerView(function () {
            $page = \App\Models\Page::get('register');
            return view('auth.register', compact('page'));
        });
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'redirect' => route('index')
                    ],
                    'message' => 'Registered successfully'
                ]);
            }
        });

        // reset pass config
        Fortify::requestPasswordResetLinkView(function () {
            $page = \App\Models\Page::get('forgot-password');
            return view('auth.password-email', compact('page'));
        });
        Fortify::resetPasswordView(function ($request) {
            $token = $request->token;
            $email = $request->email;
            return view('auth.password-reset', compact('token', 'email'));
        });
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
