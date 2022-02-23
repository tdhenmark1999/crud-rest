<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:120,1',
            'bindings',
            \App\Laravel\Middleware\Api\ValidResponseFormat::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \App\Http\Middleware\ThrottleRequests::class,

        'backoffice.auth' => \App\Laravel\Middleware\Backoffice\Authenticate::class,
        'backoffice.guest' => \App\Laravel\Middleware\Backoffice\RedirectIfAuthenticated::class,
        'backoffice.verify-reset-token' => \App\Laravel\Middleware\Backoffice\VerifyResetToken::class,

        'jwt.auth' => \App\Laravel\Middleware\Api\JWTApiAuth::class,
        'jwt.refresh' => \App\Laravel\Middleware\Api\JWTRefresher::class,

        'api.exists' => \App\Laravel\Middleware\Api\ExistRecord::class,
        'api.verify-reset-token' => \App\Laravel\Middleware\Api\VerifyResetToken::class,

        'api.mentor' => \App\Laravel\Middleware\Api\MentorUserOnly::class,
        'api.mentee' => \App\Laravel\Middleware\Api\MenteeUserOnly::class,

        'system.auth' => \App\Laravel\Middleware\System\Authenticate::class,
        'system.guest' => \App\Laravel\Middleware\System\RedirectIfAuthenticated::class,
        'system.lock' => \App\Laravel\Middleware\System\Lock::class,
        'system.super_user' => \App\Laravel\Middleware\System\SuperUserOnly::class,
        'system.client_partner_not_allowed' => \App\Laravel\Middleware\System\NoClientPartner::class,
        'system.update_profile_first' => \App\Laravel\Middleware\System\UpdatedProfileOnly::class,

    ];
}
