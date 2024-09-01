<?php

namespace App\DataTables\TableView;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\TranslationLoader\LanguageLine;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Fields\Hidden;
use Yajra\DataTables\Html\Editor\Fields\Select;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Services\DataTable;

class TranslationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('actions', function ($data) {
                return '<div class="d-inline-block text-nowrap">
                     <button class="btn btn-sm btn-icon editor-edit"><i class="ri-edit-box-line text-warning fs-5"></i></button>
                     <button class="btn btn-sm btn-icon editor-delete"><i class="ri-delete-bin-line text-danger fs-5"></i></button>
                    </div>';
            })
            ->setRowId('id')
            ->editColumn('key', function ($data) {
                return $data->key;
            })
            ->editColumn('text', function ($data) {
                return isset($data->text[$this->currentLang()]) ? $data->text[$this->currentLang()] : '';
            })
            ->rawColumns(['actions']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LanguageLine $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('group');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('translation-table')
            ->minifiedAjax()
            ->columns($this->getColumns())
            ->setTableAttributes([
                'class' => 'table table-bordered table-hover', // Add CSS classes to style the table
                'width' => '100%' // Set the width of the table to 100%
            ])
            ->dom("<'row m-2'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-8 d-flex align-items-center justify-content-end'lB>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-12 d-flex align-item-center justify-content-end'p>>")
            ->language([
                "search" => "",
                "lengthMenu" => "_MENU_",
                "searchPlaceholder" => trans('general.search'),
                "processing" => '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
            ])
            ->pageLength(10)
            ->columnDefs([
                'className' => 'dt-center',
                'targets'   => 'all'
            ])
            ->buttons(
                Button::make('create')
                    ->attr(['id' => 'createButton'])
                    ->className('btn btn-primary btn-sm btn-label waves-effect right waves-light rounded-pill ms-2')
                    ->text('<i class="ri-add-line ani-breath align-bottom label-icon align-middle rounded-pill fs-20"></i> <span class="only-pc">Create</span>')
                    ->editor('editor')
            )
            ->initComplete('function() {
                $(".dataTables_length label, #user-table_filter label").addClass("mb-0");
                $(".dt-buttons .dt-button").removeClass("dt-button");
                $("#translation-table_processing").removeClass("card");
             }')->editor(
                Editor::make()->fields([
                    Select::make('group')->options([
                        'home',
                        'general',
                        'message',
                        'validation',
                        'user',
                        'chat',
                        'translation',
                        'role',
                        'permission',
                        'dashboard',
                        'schedule',
                        'setting',
                    ])->label('Group')->id('group'),
                    Text::make('key')->label('Key')->attr('placeholder', 'Enter key name'),
                    Text::make('text')->label('Text')->id('slug')->attr('placeholder', 'Enter text'),
                    Hidden::make('slug')->default($this->currentLang()),
                ])
            )
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('group')->title(trans('translation.group')),
            Column::make('key')->title(trans('translation.key')),
            Column::make('text')->title(trans('translation.text')),
            Column::make('actions')->title(trans('translation.actions'))->exportable(false)->printable(false)->className('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    private function currentLang()
    {
        return request()->route('slug');
    }
    protected function filename(): string
    {
        return 'Translation_' . date('YmdHis');
    }
}
