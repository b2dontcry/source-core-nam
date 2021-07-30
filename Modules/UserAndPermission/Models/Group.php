<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\UserAndPermission\Helpers\Traits\{HasModelSupporter, HasPagination, HasSortAndSearch};

class Group extends Model
{
    use HasModelSupporter, HasPagination, HasSortAndSearch;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'created_by', 'updated_by',
    ];

    /**
     * Thiết lập tên nhóm quyền khi lưu vào model.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strip_tags(trim($value));
    }

    /**
     * Thiết lập mô tả nhóm quyền khi lưu vào model.
     *
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strip_tags(trim($value));
    }

    /**
     * Lấy danhs sách nhóm quyền.
     *
     * @param  array  $filter
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getList(array $filter = [])
    {
        $builder = $this->select('id', 'name', 'description', 'created_at', 'updated_at');

        $builder = $this->searchBuilder($builder, $filter);
        $builder = $this->sortBuilder($builder, $filter);

        return $this->getWithPagination($builder, $filter);
    }

    /**
     * Lấy chi tiết nhóm quyền.
     *
     * @param  int  $id
     * @return \Modules\UserAndPermission\Models\Group
     */
    public function getDetail($id)
    {
        $result = $this->leftJoin('users as cr', 'cr.id', '=', $this->getTable().'.created_by')
            ->leftJoin('users as up', 'up.id', '=', $this->getTable().'.updated_by')
            ->where($this->getTable().'.'.$this->primaryKey, $id)
            ->select(
                $this->getTable().'.id',
                $this->getTable().'.name',
                $this->getTable().'.description',
                $this->getTable().'.created_at',
                $this->getTable().'.updated_at',
                $this->getTable().'.created_by',
                DB::raw('cr.name as created_by_name'),
                $this->getTable().'.updated_by',
                DB::raw('up.name as updated_by_name')
            );

        return $result->first();
    }

    /**
     * Thêm nhóm quyền.
     *
     * @param  array  $data
     * @return \Modules\UserAndPermission\Models\Group
     */
    public function add(array $data)
    {
        $this->name = strip_tags($data['name']);
        $this->description = isset($data['description']) ? strip_tags($data['description']) : null;
        $this->created_by = auth()->id();
        $this->updated_by = auth()->id();

        $this->save();

        return $this;
    }

    /**
     * Các tài khoản người dùng thuộc nhóm quyền.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Các quyền của tài khoản người dùng.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Lấy danh sách nhóm quyền và kiểm tra nhóm quyền của tài khoản người dùng.
     *
     * @param  \Illuminate\Support\Collection|array  $listGroupsSelected
     * @return \Illuminate\Support\Collection
     */
    public function getForEdit($listGroupsSelected)
    {
        if ($listGroupsSelected instanceof \Illuminate\Support\Collection) {
            $listGroupsSelected = $listGroupsSelected->toArray();
        }

        return $this->getListAndCheckSelected($this, [
            'list' => $listGroupsSelected,
            'columns' => ['id', 'name', 'description'],
        ]);
    }

}
