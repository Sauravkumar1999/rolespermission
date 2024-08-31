<?php

namespace App\DataTables\Editor;

use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;
use Yajra\DataTables\DataTablesEditor;

class TranslationDatatableEditor extends DataTablesEditor
{
    protected $model = LanguageLine::class;

    /**
     * Get create action validation rules.
     */
    public function createRules(): array
    {
        return [
            'group' => 'required|string',
            'key'   => 'required|string',
            'text'  => 'required|string',
        ];
    }

    /**
     * Get edit action validation rules.
     */
    public function editRules(Model $model): array
    {
        return [
            'group' => 'required|string',
            'key'   => 'required|string',
            'text'  => 'required|string',
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
        $model->setTranslation($data['slug'], $data['text']);
        $data['group'] = strtolower($data['group']);
        $data['key'] = strtolower($data['key']);
        $data['text'] = $model->text;
        return $data;
    }

    /**
     * Event hook that is fired after `created` and `updated` events.
     */
    public function saved(Model $model, array $data): Model
    {
        return $model;
    }
    public function editing(Model $model, array $data): array
    {
        $model->setTranslation($data['slug'], $data['text']);
        $data['group'] = strtolower($data['group']);
        $data['key'] = strtolower($data['key']);
        $data['text'] = $model->text;
        return $data;
    }
}
