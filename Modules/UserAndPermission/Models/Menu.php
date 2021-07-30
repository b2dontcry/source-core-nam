<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'icon', 'route', 'group_title', 'parent_id', 'level', 'order', 'menu_type', 'created', 'updated',
    ];

    const MENU_TYPE_SIDEBAR = 0;
    const MENU_TYPE_NAV = 1;
    const MENU_TYPE_LIST = 2;

    /**
     * Các menu con của menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
                    ->orderBy('order', 'ASC');
    }
}
