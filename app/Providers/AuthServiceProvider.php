<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 策略自动发现
        // @link https://learnku.com/docs/laravel/6.x/authorization/5153#creating-policies
        Gate::guessPolicyNamesUsing(function ($modelClass) {

            if (is_object($modelClass) && $modelClass instanceof Model) {
                $modelClass = get_class($modelClass);
            }

            if (! is_string($modelClass) && ! is_object($modelClass)) {
                throw new \Exception('The Policy of' . $modelClass . 'not found');
            }

            $currentModelPolicy = str_replace('Models', 'Policies', $modelClass) . 'Policy';

            if (! class_exists($currentModelPolicy)) {
                throw new \Exception('No Policy for' . $currentModelPolicy);
            }

            // 动态返回模型对应的策略名称，如：// 'App\Models\Auth\User' => 'App\Policies\Auth\UserPolicy',
            // 返回策略类名…
            return $currentModelPolicy;
        });

    }
}
