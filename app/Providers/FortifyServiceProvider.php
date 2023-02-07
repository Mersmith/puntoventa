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
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Fortify::ignoreRoutes();

        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                $ruta = str_replace('/', '', $request->getPathInfo());

                if ($ruta == "login") {
                    if (Auth::user()->rol == "administrador") {
                        return redirect()->route('administrador.perfil');
                    } elseif (Auth::user()->rol == "cliente") {
                        return redirect()->route('cliente.perfil');
                    } else {
                        return "Es incognito";
                    }
                } elseif ($ruta == "login-administrador") {
                    if (Auth::user()->rol == "administrador") {
                        return redirect()->route('administrador.perfil');
                    } else {
                        return redirect('/');
                    }
                }
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse
        {
            public function toResponse($request)
            {
                $ruta = str_replace('/', '', $request->getPathInfo());

                if ($ruta == "register") {
                    return redirect()->route('cliente.perfil');
                } elseif ($ruta == "register-administrador") {
                    return redirect()->route('administrador.perfil');
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
