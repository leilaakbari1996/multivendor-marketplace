<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

trait HasDatatable
{
    protected function renderDatatable(
        Builder $query,
        string $actionsView,
        array $extraColumns = [],
    ) {
        $table = DataTables::eloquent($query)
            ->addColumn('actions', function ($row) use ($actionsView) {
                return view($actionsView, [
                    'row' => $row,
                ])->render();
            });

        foreach ($extraColumns as $name => $callback) {
            $table->addColumn($name, $callback);
        }

        return $table
            ->rawColumns([
                'actions',
                ...array_keys($extraColumns),
            ])
            ->make(true);
    }
}
