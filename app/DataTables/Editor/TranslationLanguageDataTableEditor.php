<?php

namespace App\DataTables\Editor;

use App\Models\TranslationLanguage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Http\Request as HttpRequest;

class TranslationLanguageDataTableEditor extends DataTablesEditor
{
    protected $model = TranslationLanguage::class;

    /**
     * Get create action validation rules.
     */
    public function createRules(): array
    {
        return [
            'lang_name'         => 'required|string',
            'slug'              => 'required|string',
        ];
    }

    /**
     * Get edit action validation rules.
     */
    public function editRules(Model $model): array
    {
        return [
            'lang_name'         => 'required|string',
            'slug'              => 'required|string',
        ];
    }

    /**
     * Get remove action validation rules.
     */
    public function removeRules(Model $model): array
    {
        return [];
    }

    /**
     * Event hook that is fired after `creating` and `updating` hooks, but before
     * the model is saved to the database.
     */
    public function saving(Model $model, array $data): array
    {
        return $data;
    }

    /**
     * Event hook that is fired after `created` and `updated` events.
     */
    public function saved(Model $model, array $data): Model
    {
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
    }
}
