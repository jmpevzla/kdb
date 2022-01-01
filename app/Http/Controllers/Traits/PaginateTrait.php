<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\DB;


use Log;

trait PaginateTrait
{
    private function getPage(int $id)
    {
        $model = app($this->model);

        $res = DB::select('
            SELECT id, pos FROM
            (SELECT id, created_at, (@rownum:= @rownum + 1) as pos
                FROM '. $model->tableName() .' JOIN (SELECT @rownum := -1) s
                WHERE deleted_at IS NULL) as ent_pos
            WHERE id = ?
        ', [$id]);

        $page = 1;
        if (!empty($res)) {
            $page = ((int) ($res[0]->pos / $this->paginate) + 1);
        }

        return $page;
    }

    private function redirectWithPage(int $page)
    {
        return redirect()->route($this->routeIndex, ['page' => $page]);
    }

    private function redirectSearchPage(int $id)
    {
        $page = $this->getPage($id);
        return $this->redirectWithPage($page);
    }
}
