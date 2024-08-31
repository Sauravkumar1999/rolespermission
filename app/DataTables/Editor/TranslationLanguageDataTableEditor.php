<?php

namespace App\DataTables\Editor;

use App\Models\TranslationLanguage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTablesEditor;

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
            'is_default'        => 'boolean',
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
            'is_default'        => 'boolean',
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
}
