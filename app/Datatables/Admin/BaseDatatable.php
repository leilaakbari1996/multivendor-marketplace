<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

/**
 * Base class for every admin datatable.
 * A child only describes its query, columns and actions view.
 */
abstract class BaseDatatable
{
    /**
     * @return Builder<Model>
     */
    abstract protected function query(): Builder;

    /**
     * Blade view that renders the action buttons of one row.
     * It receives the model as $row.
     */
    abstract protected function actionsView(): string;

    /**
     * Computed columns: [column name => fn (Model $row) => value].
     *
     * @return array<string, Closure(Model): mixed>
     */
    protected function columns(): array
    {
        return [];
    }

    /**
     * Columns whose value is HTML and must not be escaped.
     * Every other column is escaped by default, which prevents XSS.
     *
     * @return list<string>
     */
    protected function rawColumns(): array
    {
        return [];
    }

    public function toJson(): JsonResponse
    {
        $table = DataTables::eloquent($this->query())
            ->addColumn(
                'actions',
                fn (Model $row): string => view($this->actionsView(), ['row' => $row])->render()
            );

        foreach ($this->columns() as $name => $callback) {
            $table->addColumn($name, $callback);
        }

        return $table
            ->rawColumns(['actions', ...$this->rawColumns()])
            ->make(true);
    }
}
