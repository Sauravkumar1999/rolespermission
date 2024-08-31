<?php

namespace App\DataTables\TableView;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('dashboard.users.partials._action_button_role', ['data' => $data])->render();
            })
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->orderBy('name','asc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('role'))
            ->dom("<'row m-2'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-8 d-flex align-items-center justify-content-end'lB>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-12 d-flex align-item-center justify-content-end'p>>")
            // ->dom('Bfrtip')
            ->language(["search" => "", "lengthMenu" => "_MENU_", "searchPlaceholder" => 'Search...'])
            ->orderBy(0, 'ASC')
            ->initComplete('function() {
                $(".dataTables_length label, #user-table_filter label").addClass("mb-0");
                $(".dt-buttons .dt-button").removeClass("dt-button");
            }')
            ->orderBy(1)
            ->pageLength(10)
            ->columnDefs([
                'className' => 'dt-center',
                'targets'   => 'all'
            ])
            ->buttons(
                Button::make('create')
                    ->attr(['id' => 'createButton'])
                    ->className('btn btn-primary btn-sm btn-label waves-effect right waves-light rounded-pill ms-2')->text('<i class="ri-add-line ani-breath align-bottom label-icon align-middle rounded-pill fs-20"></i> <span class="only-pc">Create</span>')
                    ->editor('editor')
                    ->authorized(Auth::user()->can('role.create'))
            )->editor(
                Editor::make()->fields([
                    Text::make('name')->label('Name')->attr('placeholder', 'Enter Name'),
                    Text::make('display_name')->label('Display Name')->attr('placeholder', 'Enter Name'),
                    Text::make('desc')->label('Description'),
                ])
                    ->onOpen("function(e, node, action) {
                    $('.DTE_Action_Create').parent().addClass('modal-lg');
                }")
            )->scrollX(false);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex') // Computed column for row index
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->className('text-center'),
            Column::make('name'),
            Column::make('display_name'),
            Column::make('desc'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
