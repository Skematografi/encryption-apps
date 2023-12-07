<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Storages extends Model
{
    use SoftDeletes;

    protected $table = 'storages';

    protected $fillable = [
        'filename', 'unique_filename', 'extension', 'size', 'user_id', 'path', 'status', 'key', 'init_vector'
    ];

    public static function fetchData()
    {
        $model = self::leftJoin('users', 'users.id', '=', 'storages.user_id')
            ->select(
                "users.name as owner",
                "storages.id",
                "storages.user_id",
                "storages.path",
                "storages.extension",
                "storages.updated_at",
                DB::raw("(CONCAT(storages.filename, '.', storages.extension)) as filename"),
                DB::raw("(CASE WHEN storages.status = 1 THEN 'Encrypted' ELSE 'Not Encrypted' END) as status"),
                DB::raw("(
                    CASE WHEN storages.size < 1025 THEN
                        CONCAT(CAST(storages.size AS DECIMAL(10,2)), ' KB')
                    ELSE
                        CONCAT(CAST(storages.size / 1024 AS DECIMAL(10,2)), ' MB')
                    END
                ) as size")
            );

        if (auth()->user()->role_id != 1) {
            $model = $model->where('storages.user_id', '=', auth()->user()->id);
        }

        $model = $model->orderBy('storages.updated_at', 'DESC')
            ->orderBy('storages.filename', 'ASC')
            ->get();

        return $model;
    }
}
