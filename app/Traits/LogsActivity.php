<?php

namespace App\Traits;

use App\Models\ActivityLogs;

trait LogsActivity
{
    /**
     * Логирование действий пользователя.
     *
     * @param string $action Описание действия
     * @param array $data Дополнительные данные (необязательно)
     * @return void
     */
    public function logActivity(string $action, array $data = [], $id = null)
    {
        if (!auth()->user() && !empty($id)) {
            $userId = $id;
        } else {
            $userId = auth()->user()->id;
        }

        ActivityLogs::create([
            'user_id' => $userId,
            'action' => $action,
            'data' => $data,
        ]);
    }
}
