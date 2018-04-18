<?php

namespace App\Listeners;

use Log;

class DBQueryListener
{
    /**
     * Handle the event.
     *
     * @param string $sql    查询SQL
     * @param array  $params 参数
     */
    public function handle($sql, $params)
    {
        if (env('APP_ENV', 'production') == 'local') {
            Log::info($sql.', with['.implode(',', $params).']');
        }
    }
}
