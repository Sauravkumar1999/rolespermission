<?php

namespace App\DataTables\TableView;

use App\Models\TranslationLanguage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields\File;
use Yajra\DataTables\Html\Editor\Fields\Radio;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Services\DataTable;

class TranslationLanguageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('actions', function ($data) {
                return '<div class="d-inline-block text-nowrap">
                    <a href="' . route('translations.language', $data->slug) . '" class="btn btn-sm btn-icon editor-change"><i class="ri-exchange-line text-primary fs-5"></i></a>
                    <button class="btn btn-sm btn-icon editor-edit"><i class="ri-edit-box-line text-warning fs-5"></i></button>
                    <button class="btn btn-sm btn-icon editor-delete"><i class="ri-delete-bin-line text-danger fs-5"></i></button>
                    </div>';
            })
            ->addColumn('svg', function ($data) {
                return '<img src="' . $data->svg . '" alt="Profile" class="avatar-xs rounded-circle" />';
            })
            ->editColumn('created_at', function ($data) {
                return date('Y-m-d', strtotime($data->created_at));
            })
            ->rawColumns(['actions','svg']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TranslationLanguage $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $readOnly = default_language();
        return $this->builder()
            ->setTableId('translationlanguage-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('translations.process'))
            ->dom("<'row m-2'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-8 d-flex align-items-center justify-content-end'lB>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-12 d-flex align-item-center justify-content-end'p>>")
                ->language([
                    "search" => "",
                    "lengthMenu" => "_MENU_",
                    "searchPlaceholder" => trans('general.search'),
                    "processing" => '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
                ])
            ->orderBy(0, 'ASC')
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
                        $("#translationlanguage-table_processing").removeClass("card");
                     }')
            ->editor(
                Editor::make()->fields([
                    Text::make('lang_name')
                        ->label('language')
                        ->attr('placeholder', 'Enter language name'),
                    Text::make('slug')
                        ->label('slug')
                        ->id('slug')
                        ->attr('placeholder', 'Enter slug'),
                    File::make('svg')->label('Svg')
                        ->display("function (data) {  if(!data.includes('img')) { return '<img src=\"'+data+'\" />'; } else { return data; } }"),
                    Radio::make('is_default')->label('status')
                    ->options([
                        [
                            'label' => 'On',
                            'value' => 1
                        ],
                        [
                            'label' => 'Off',
                            'value' => 0
                        ],
                    ])->default('general'),
                ])
                    ->onOpen("function(e, node, action) {
                            $('.DTE_Action_Create').parent().addClass('modal-lg');
                        }")
            )
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('lang_name')->title('Lanhuage name'),
            Column::make('slug')->title('slug'),
            Column::make('svg')->title('Svg'),
            Column::make('created_at')->title('created-at'),
            Column::make('actions')->title(trans('translation.actions'))->exportable(false)->printable(false)->className('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TranslationLanguage_' . date('YmdHis');
    }
    private function currentLang()
    {
        return request()->route('slug');
    }
}
