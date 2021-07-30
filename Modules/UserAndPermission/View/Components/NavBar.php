<?php

namespace Modules\UserAndPermission\View\Components;

use Illuminate\View\Component;

class NavBar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Lấy class cho element của giao diện.
     *
     * @return string
     */
    public function getColorThemeClass()
    {
        $setting = auth()->user()->setting;

        if (! is_null($setting) && $setting->theme != 'default') {
            [$theme, $color] = explode('-', $setting->theme);

            if (($theme == 'dark' && $color != 'white') || ($setting->theme == 'light-white' || $setting->theme == 'light-warning')) {
                return strtr('navbar-@theme navbar-@color', [
                    '@theme' => $theme,
                    '@color' => $color,
                ]);
            }
        }

        return 'navbar-light navbar-white';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('userandpermission::components.navbar');
    }
}
