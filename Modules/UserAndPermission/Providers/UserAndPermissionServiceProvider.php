<?php

namespace Modules\UserAndPermission\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Factory;
use Modules\UserAndPermission\Models\Group;
use Modules\UserAndPermission\Models\User;
use Modules\UserAndPermission\Observers\GroupObserver;
use Modules\UserAndPermission\Observers\UserObserver;
use Modules\UserAndPermission\Http\Middleware\CheckClientCredentials;
use Modules\UserAndPermission\Http\Middleware\CheckUserPermission;
use Modules\UserAndPermission\Http\Middleware\CheckLocale;
use Modules\UserAndPermission\Http\Middleware\CheckLoginFirstTime;

class UserAndPermissionServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'UserAndPermission';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'userandpermission';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Đăng ký các thành phần hỗ trợ cho module
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerObservers();
        $this->registerComponents();

        // Đăng ký các middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('CheckClientCredentials', CheckClientCredentials::class);
        $router->aliasMiddleware('check_user_permissions', CheckUserPermission::class);
        $router->aliasMiddleware('check_locale', CheckLocale::class);
        $router->aliasMiddleware('check_login_first_time', CheckLoginFirstTime::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->singleton(
            \Modules\UserAndPermission\Repositories\Contracts\User::class,
            \Modules\UserAndPermission\Repositories\UserRepository::class
        );
        $this->app->singleton(
            \Modules\UserAndPermission\Repositories\Contracts\Group::class,
            \Modules\UserAndPermission\Repositories\GroupRepository::class
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadJsonTranslationsFrom($langPath);
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    /**
     * Khai báo các ràng buộc giữa Model và Observer.
     *
     * @return void
     */
    public function registerObservers()
    {
        User::observe(UserObserver::class);
        Group::observe(GroupObserver::class);
    }

    /**
     * Khai báo chỉ định các components sẽ được dùng trong blade.
     *
     * @return void
     */
    public function registerComponents()
    {
        // Blade::component('sidebar', 'Modules\UserAndPermission\View\Components\Sidebar');
        // Blade::component('navbar', 'Modules\UserAndPermission\View\Components\NavBar');
        // Blade::component('headerpage', 'Modules\UserAndPermission\View\Components\HeaderPage');
        // Blade::componentNamespace('Modules\UserAndPermission\View\Components', 'userandpermission');
        $this->loadViewComponentsAs($this->moduleNameLower, [
            'sidebar' => \Modules\UserAndPermission\View\Components\Sidebar::class,
            'navbar' => \Modules\UserAndPermission\View\Components\NavBar::class,
            'headerpage' => \Modules\UserAndPermission\View\Components\HeaderPage::class,
        ]);
    }
}
