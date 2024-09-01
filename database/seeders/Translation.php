<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Translation extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $jsonPath = database_path('seeders/translations.json');
        $groups = json_decode(File::get($jsonPath), true);

        DB::beginTransaction();

        try {
            foreach ($groups as $group => $translations) {
                foreach ($translations as $translation) {
                    DB::table('language_lines')->updateOrInsert(
                        [
                            'group' => $group,
                            'key' => $translation['key'],
                        ],
                        [
                            'text' => json_encode($translation['text']),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            echo 'Failed to seed: ' . $e->getMessage();
            DB::rollBack();
        }
    }
}
