<?php

namespace Modules\UserAndPermission\Models;

use Modules\UserAndPermission\Helpers\Traits\{HasPagination, HasSortAndSearch};
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class History extends Model
{
    use HasPagination, HasSortAndSearch;

    protected $fillable = [
        'user_id', 'table_name', 'key', 'device', 'device_family', 'device_model', 'ip_address', 'platform',
        'browser', 'created_at', 'data',
    ];
    public $timestamps = false;

    const DESKTOP_DEVICE = 'Desktop';
    const TABLET_DEVICE = 'Tablet';
    const MOBILE_DEVICE = 'Mobile';
    const OTHER_DEVICE = 'Other';

    /**
     * Lấy danh sách lịch sử.
     *
     * @param  array  $filter
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getList(array $filter = [])
    {
        $builder = $this->leftJoin('users', 'users.id', '=', $this->getTable().'.user_id')
                        ->select($this->getTable().'.*', 'users.username')
                        ->orderBy($this->getTable().'.created_at', 'DESC')
                        ->orderBy($this->getTable().'.'.$this->getKeyName(), 'DESC');

        if (! auth()->user()->is_admin) {
            $builder->where($this->getTable().'.user_id', auth()->id());
        }

        $builder = $this->searchBuilder($builder, $filter);

        return $this->getWithPagination($builder, $filter);
    }

    /**
     * Thêm lịch sử.
     *
     * @param  string  $table
     * @param  string  $key
     * @param  string  $data
     * @return void
     */
    public function add($table, $key, $data = '')
    {
        $device = static::OTHER_DEVICE;

        if (Browser::isMobile()) {
            $device = static::MOBILE_DEVICE;
        } elseif (Browser::isTablet()) {
            $device = static::TABLET_DEVICE;
        } elseif (Browser::isDesktop()) {
            $device = static::DESKTOP_DEVICE;
        }

        $data = [
            'user_id' => auth()->id(),
            'table_name' => $table,
            'key' => $key,
            'data' => $data,
            'device' => $device,
            'device_family' => Browser::deviceFamily(),
            'device_model' => Browser::deviceModel(),
            'ip_address' => Request::ip(),
            'platform' => Browser::platformName(),
            'browser' => Browser::browserName(),
            'created_at' => Carbon::now(),
        ];

        $this->create($data);
    }

    /**
     * Xóa lịch sử sau x ngày (mặc định là 30 ngày).
     *
     * @param  int  $x
     * @return void
     */
    public function clearXDayHistory($x = 30)
    {
        $x = config('userandpermission.limit_save_history', $x);

        $this->where('created_at', '<', Carbon::now()->subDay($x))->delete();
    }

    /**
     * Lịch sử hoạt động thuộc về tài khoản người dùng.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
