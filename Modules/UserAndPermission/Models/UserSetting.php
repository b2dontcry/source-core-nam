<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'user_setting';
    protected $fillable = [
        'user_id', 'language', 'theme', 'config', 'updated_at', 'color'
    ];

    public $timestamps = false;

    /**
     * Danh sách chủ đề giao diện.
     *
     * @var array
     */
    const THEMES = [
        'default',
        'light-primary',
        'light-danger',
        'light-warning',
        'light-teal',
        'light-success',
        'light-dark',
        'dark-primary',
        'dark-danger',
        'dark-warning',
        'dark-teal',
        'dark-success',
        'dark-white'
    ];

    /**
     * Danh sách ngôn ngữ hợp lệ.
     *
     * @var array
     */
    const LANGUAGES_VALID = ['en', 'vi'];

    /**
     * Danh sách ngôn ngữ.
     *
     * @var array
     */
    const LANGUAGES = [
        'en' => 'English', 'vi' => 'Tiếng Việt',
    ];

    /**
     * Danh sách màu chủ đạo giao diện.
     *
     * @var array
     */
    const COLORS = [
        'dark', 'light', 'danger', 'warning', 'teal', 'primary',
    ];
}
