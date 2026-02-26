<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            self::writeLog($model, 'created', null, $model->toArray());
        });

        static::updated(function (Model $model) {
            $original = $model->getOriginal();
            $changes  = $model->getChanges();
            // Hapus updated_at dari log agar tidak terlalu noisy
            unset($changes['updated_at'], $original['updated_at']);

            if (!empty($changes)) {
                self::writeLog($model, 'updated', $original, $changes);
            }
        });

        static::deleted(function (Model $model) {
            self::writeLog($model, 'deleted', $model->toArray(), null);
        });
    }

    protected static function writeLog(Model $model, string $action, ?array $oldData, ?array $newData): void
    {
        DB::table('audit_logs')->insert([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'table_name' => $model->getTable(),
            'record_id'  => (string) $model->getKey(),
            'old_data'   => $oldData ? json_encode($oldData) : null,
            'new_data'   => $newData ? json_encode($newData) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
