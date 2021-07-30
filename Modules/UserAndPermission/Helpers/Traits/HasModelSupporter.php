<?php

namespace Modules\UserAndPermission\Helpers\Traits;

use Illuminate\Support\Facades\Request;
use Modules\UserAndPermission\Models\History;

/**
 * Trait HasModelSupporter
 * @package Modules\UserAndPermission\Helpers\Traits
 */
trait HasModelSupporter
{
    /**
     * Lấy danh sách và kiểm tra giá trị đã chọn cho <select>.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array  $config (list, columns, wheres)
     * @return \Illuminate\Support\Collection
     */
    public function getListAndCheckSelected(\Illuminate\Database\Eloquent\Model $model, array $config = [])
    {
        $query = $model;

        if (isset($config['wheres'])) {
            $query = $query->where($config['wheres']);
        }

        return $query->get($config['columns'] ?? ['*'])->map(function ($item) use ($config) {
            $item->selected = in_array($item->id, $config['list'] ?? []);
            return $item;
        });
    }

    /**
     * Lưu lịch sử hoạt động của model.
     *
     * @param  string  $key
     * @param  string|array|null  $data
     * @return \Modules\UserAndPermission\Models\History
     */
    public function saveHistory($key, $data = null)
    {
        $table = $this->getTable();

        if (is_null($data)) {
            $data = $this->toJson();
        } elseif (is_array($data)) {
            $data = json_encode($data);
        }

        $history = (new History())->add($table, $key, $data);

        return $history;
    }
}
