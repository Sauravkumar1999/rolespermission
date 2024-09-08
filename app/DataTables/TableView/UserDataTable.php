<?php

namespace App\DataTables\TableView;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields\File;
use Yajra\DataTables\Html\Editor\Fields\Number;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->setRowId('id')
            ->addColumn('actions', function ($data) {
                return view('dashboard.users.partials._action_button', ['data' => $data])->render();
            })
            ->addColumn('profile', function ($data) {
                return '<img src="' . $data->profile . '" alt="Profile" class="avatar-xs rounded-circle" />';
            })
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    return '<span class="badge bg-success">Approve</span>';
                }
                return '<span class="badge bg-warning">Waiting</span>';
            })
            ->addColumn('phone', function ($data) {
                return $data->phone;
            })
            ->rawColumns(['actions', 'status', 'profile', 'edit']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('user'))
            ->dom("<'row m-2'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-8 d-flex align-items-center justify-content-end'lB>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-12 d-flex align-item-center justify-content-end'p>>")
            // ->dom('Bfrtip')
            ->language([
                "search" => "",
                "lengthMenu" => "_MENU_",
                "searchPlaceholder" => trans('general.search'),
                "processing" => '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
            ])
            ->orderBy(0, 'ASC')
            ->initComplete('function() {
                $(".dataTables_length label, #user-table_filter label").addClass("mb-0");
                $(".dt-buttons .dt-button").removeClass("dt-button");
                $("#user-table_processing").removeClass("card");
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
                    ->authorized(Auth::user()->can('user.create'))
            )->editor(
                Editor::make()->fields([
                    Text::make('name')->label('Name')->attr('placeholder', 'Enter Full Name'),
                    Text::make('email')->label('Email')->attr('placeholder', 'exaplain@mail.com'),
                    Text::make('phone')->label('Phone')->attr('placeholder', 'Enter Phone number'),
                    // Text::make('password')->label('Password')->attr('placeholder', '********'),
                    Text::make('password')->label(trans('user.password'))
                    ->attr('id' , 'password')
                    ->attr('readonly' , 'readonly')
                    ->attr('placeholder' , trans('user.password'))
                    ->attr('disabled' , true)
                    ->attr('class' , 'password-field'),
                    File::make('profile')->label('profile')
                        ->display("function (data) {  if(!data.includes('img')) { console.log('yes'); return '<img src=\"'+data+'\" />'; } else { console.log('no'); return data; } }"),
                ])
                    ->onOpen("function(e, node, action) {
                        $('.DTE_Action_Create').parent().addClass('modal-lg');
                        var passwordField = $('div.DTE_Field_Name_password');
                        generatePasswordHTML();
                    }")
                    ->onInitEdit("function(){ console.log('onInitEdit') }")
            )->scrollX(false);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(trans(trans('translation.id')))->searchable(false)->orderable(false)->className('text-center'),
            Column::make('status'),
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('profile'),
            Column::make('actions')->title(trans('translation.actions'))->exportable(false)->printable(false)->className('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
