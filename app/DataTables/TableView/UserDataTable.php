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
use Yajra\DataTables\Html\Editor\Fields\Radio;
use Yajra\DataTables\Html\Editor\Fields\Select;
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
                return '<img src="' . $data->profile . '" alt="Profile" class="avatar-xs rounded-circle" onerror="this.onerror=null; this.src=\'/assets/images/error400-cover.png\';" />';
            })
            ->addColumn('role', function ($data) {
                $role = $data->roles;
                return $role->first()?->display_name ?? 'N/A';
            })
            ->filterColumn('role', function ($query, $key) {
                if ($key === 'all roles' || empty($key)) {
                    return;
                }
                return $query->whereHas('roles', function ($q) use ($key) {
                    $q->whereRaw('LOWER(display_name) LIKE ?', [strtolower($key)]);
                });
            })
            ->editColumn('hidden_status', function ($data) {
                return $data->status;
            })
            ->editColumn('hidden_role', function ($data) {
                $role = $data->roles;
                return $role->first()?->id ?? '';
            })
            ->addColumn('status', function ($data) {
                if ($data->status) {
                    return '<span class="badge bg-success">Approve</span>';
                }
                return '<span class="badge bg-warning">Waiting</span>';
            })
            ->filterColumn('status', function ($query, $key) {
                switch (strtolower($key)) {
                    case 'approve':
                        $query->where('status', 1);
                        break;
                    case 'waiting':
                        $query->where('status', 0);
                        break;

                    default:
                        break;
                }
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
        return $model->newQuery()->where('id', '!=', Auth::id());
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
            ->dom("<'row'<'col-md-6 d-flex align-items-center justify-content-start'f>
                    <'col-md-6 d-flex align-items-center justify-content-end'lB>>
                    <'row'<'col-12'tr>>
                    <'row'<'col-12 d-flex justify-content-center'p>>
            ")
            ->language(datatable_lang())
            ->orderBy(0, 'ASC')
            ->initComplete('function() {
                $(".dataTables_length label, #user-table_filter label input").removeClass("form-control-sm");
                $(".dataTables_length select").removeClass("form-select-sm");
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
                    ->className('btn btn-primary btn-label waves-effect right waves-light rounded-pill ms-2')->text('<i class="ri-add-line ani-breath align-bottom label-icon align-middle rounded-pill fs-20"></i> <span class="only-pc">Create</span>')
                    ->editor('editor')
                    ->authorized(Auth::user()->can('user.create'))
            )->editor(
                Editor::make()->fields([
                    Select::make('role')->label(trans('user::user.role-type'))->options($this->getUserRoleDropDown())->id('user_role'),
                    Text::make('name')->label('Name')->attr('placeholder', 'Enter Full Name'),
                    Text::make('email')->label('Email')->attr('placeholder', 'exaplain@mail.com'),
                    Text::make('phone')->label('Phone')->attr('placeholder', 'Enter Phone number'),
                    // Text::make('password')->label('Password')->attr('placeholder', '********'),
                    Radio::make('status')->label("Status")
                        ->options([
                            ['label' => "Approve", 'value' => 1,],
                            ['label' => "Waiting", 'value' => 0],
                        ])->default(0)->id('user_status'),
                    Text::make('password')->label(trans('user.password'))
                        ->attr('id', 'password')
                        ->attr('readonly', 'readonly')
                        ->attr('placeholder', '********')
                        ->attr('disabled', true)
                        ->attr('class', 'password-field'),
                    File::make('profile')->label('profile')
                        ->display("function (data) {  if(!data.includes('img')) {return '<img src=\"'+data+'\" />'; } else {return data; } }"),
                ])
            )->scrollX(false);
    }

    protected function getUserRoleDropDown()
    {
        $roles = collect(userRole())->mapWithKeys(function ($role) {
            return [$role['display_name'] => $role['id']];
        })->toArray();

        return ['Select Roles' => ''] + $roles;
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(trans('general.id'))->searchable(false)->orderable(false)->className('text-center'),
            Column::make('status')->title(trans('translation.status')),
            Column::make('hidden_status')->visible(false)->searchable(false)->orderable(false),
            Column::make('hidden_role')->visible(false)->searchable(false)->orderable(false),
            Column::make('role')->title(trans('translation.role')),
            Column::make('name')->title(trans('translation.name')),
            Column::make('email')->title(trans('translation.email')),
            Column::make('phone')->title(trans('translation.phone')),
            Column::make('profile')->title(trans('translation.profile'))->orderable(false)->searchable(false)->orderable(false)->searchable(false),
            Column::make('actions')->title(trans('general.actions'))->exportable(false)->printable(false)
            ->orderable(false)->searchable(false)->className('text-center'),
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
