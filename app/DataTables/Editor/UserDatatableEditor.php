<?php

namespace App\DataTables\Editor;

use App\Models\User;
use App\Traits\MediaHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTablesEditor;

use function React\Promise\all;

class UserDatatableEditor extends DataTablesEditor
{
    use MediaHandler;
    protected $model = User::class;

    /**
     * Get create action validation rules.
     */
    public function createRules(): array
    {
        return [
            'email'    => 'required|email|max:255|unique:' . $this->resolveModel()->getTable(),
            'name'     => 'required|max:255',
            'phone'    => 'required',
            'profile'  => 'required',
            'password' => 'required|min:8',
            'status'   => 'required|in:0,1',
            'role'     => 'required|exists:roles,id',
        ];
    }

    /**
     * Get edit action validation rules.
     */
    public function editRules(Model $model): array
    {
        return [
            'email'    => '|required|max:255|email|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'name'     => '|required|max:255',
            'phone'    => 'required',
            'password' => 'nullable|min:8',
            'role'     => 'required|exists:roles,id',
        ];
    }

    /**
     * Get remove action validation rules.
     */
    public function removeRules(Model $model): array
    {
        if ($model->setting) {
            $model->setting->delete();
        }

        if ($model->profile) {
            $profilePath = public_path($model->profile);
            if (file_exists($profilePath)) {
                unlink($profilePath);
            }
        }
        return [];
    }

    /**
     * Event hook that is fired before creating a new record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Empty model instance.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function creating(Model $model, array $data)
    {
        // Before saving the model, hash the password.
        if (!empty(data_get($data, 'password'))) {
            data_set($data, 'password', bcrypt($data['password']));
        }

        // return $data;
    }

    /**
     * Event hook that is fired after a new record is created.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The newly created model.
     * @param array $data Attribute values array received from `creating` or
     *   `saving` hook.
     * @return \Illuminate\Database\Eloquent\Model Since version 1.8.0 it must
     *   return the $model.
     */
    public function created(Model $model, array $data)
    {
        return $model;
    }

    /**
     * Event hook that is fired before updating an existing record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model instance retrived
     *  retrived from database.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function updating(Model $model, array $data)
    {
        if (!empty(data_get($data, 'password'))) {
            data_set($data, 'password', bcrypt($data['password']));
        } else {
            data_set($data, 'password', $model->password);
        }

        if (!is_file(public_path(data_get($data, 'profile')))) {
            data_set($data, 'profile', $model->profile);
        }

        return $data;
    }


    /**
     * Event hook that is fired after updating an existing record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model instance retrieved
     *  retrieved from the database.
     * @param array $data Attribute values array received from Editor.
     * @return Model
     */
    public function updated(Model $model, array $data)
    {
        $role = Role::findById($data['role']);
        $model->syncRoles($role);
        return $model;
    }

    public function upload(HttpRequest $request)
    {
        $file = $request->file('upload');
        $field = $request->input('uploadField');
        try {
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $imageName = time() . $file->getClientOriginalName();
                $file->move(public_path('uploads/' . $field), $imageName);

                return response()->json([
                    'action' => 'upload', 'data'   => [],
                    'files'  => [
                        'files' => [
                            'file_name' => [
                                'filename'      => 'file_name',
                                'original_name' => 'original_name',
                                'url'           => '/uploads/' . $field . '/' . $imageName,
                            ],
                        ],
                    ],
                    'upload' => [
                        'id' => '/uploads/' . $field . '/' . $imageName,
                    ],
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'action'      => $this->action,
                'data'        => [],
                'fieldErrors' => [
                    [
                        'name'   => $field,
                        'status' => str_replace('upload', $field, $exception->getMessage()),
                    ],
                ],
            ]);
        }
        // $file = $request->file('upload');
        // $field = $request->input('uploadField');
        // try {
        //     if ($field == 'avatar') {
        //         $media = $this->uploadAvatarImage($file);
        //     }
        //     return response()->json([
        //         'action' => 'upload',
        //         'data'   => [],
        //         'files'  => [
        //             'files' => [
        //                 $media->filename => [
        //                     'filename'      => $media->filename,
        //                     'original_name' => $media->basename,
        //                     'size'          => $media->size,
        //                     'directory'     => $media->directory,
        //                     'disk'          => $media->disk,
        //                     'url'           => $media->getUrl(),
        //                 ],
        //             ],
        //         ],
        //         'upload' => [
        //             'id' => $media->basename,
        //         ],
        //     ]);
        // } catch (\Exception $exception) {
        //     return response()->json([
        //         'action'      => $this->action,
        //         'data'        => [],
        //         'fieldErrors' => [
        //             [
        //                 'name'   => $field,
        //                 'status' => str_replace('upload', $field, $exception->getMessage()),
        //             ],
        //         ],
        //     ]);
        // }
    }
}
