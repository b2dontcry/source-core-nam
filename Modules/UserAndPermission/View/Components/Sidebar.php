<?php

namespace Modules\UserAndPermission\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;
use Modules\UserAndPermission\Models\Menu;

class Sidebar extends Component
{
    /**
     * Hiển thị menu.
     *
     * @return string
     */
    public function renderMenu()
    {
        $menuItems = Menu::with('items')
            ->where(['level' => 1, 'menu_type' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('group_title', 'asc')
            ->get()
            ->groupBy('group_title')
            ->toArray();

        return $this->getMenu($menuItems);
    }

    private function getMenu(array $menuItems = [])
    {
        $result = '';

        if (empty($menuItems)) {
            return $result;
        }

        foreach ($menuItems as $groupTitle => $items) {
            $result .= '<li class="nav-header text-uppercase">'.__($groupTitle).'</li>';
            $result .= $this->getMenuItems($items);
        }

        return $result;
    }

    /**
     * Lấy các template của menu items.
     *
     * @param  array  $menuItems
     * @return string
     */
    private function getMenuItems(array $menuItems = [])
    {
        $result = '';

        if (empty($menuItems)) {
            return $result;
        }

        foreach ($menuItems as $menuItem) {
            $menuItem['route'] = json_decode($menuItem['route'], true);
            if (isset($menuItem['items']) && ! empty($menuItem['items'])) {
                $permissions = array_keys($menuItem['route']);
                if (Gate::check('check_user_permission', [$permissions])) {
                    $result .= '<li class="nav-item has-treeview '.$this->activeMenu($menuItem['route'], 'menu-open').'">
                        <a href="#" class="nav-link '.$this->activeMenu($menuItem['route']).'">
                            <i class="nav-icon '.$menuItem['icon'].'"></i>
                            <p>'.__($menuItem['name']).'<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">'.$this->getMenuItems($menuItem['items']).'</ul>
                    </li>';
                }
            } else {
                $permission = array_keys($menuItem['route']);
                $route = array_values($menuItem['route'])[0];
                if (Gate::check('check_user_permission', [$permission])) {
                    $result .= '<li class="nav-item">
                        <a href="'.route($route).'" class="nav-link '.$this->activeMenu($route).'">
                            <i class="nav-icon '.$menuItem['icon'].'"></i>
                            <p>'.__($menuItem['name']).'</p>
                        </a>
                    </li>';
                }
            }
        }

        return $result;
    }

    /**
     * Kích hoạt menu.
     *
     * @param  array|string  $route
     * @param  string  $className
     * @return string
     */
    public function activeMenu($route, $className = 'active')
    {
        $currentRoute = Route::currentRouteName();
        if (is_array($route)) {
            foreach ($route as $value) {
                if ($value == $currentRoute) {
                    return $className;
                }
            }
        } else {
            if ($route == $currentRoute) {
                return $className;
            }
        }
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

            if ($color == 'light' || $color == 'dark') {
                return "sidebar-{$theme}-primay";
            } else {
                return "sidebar-{$theme}-{$color}";
            }
        }

        return 'sidebar-dark-primary';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('userandpermission::components.sidebar');
    }
}
