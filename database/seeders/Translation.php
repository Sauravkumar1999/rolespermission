<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Translation extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $promotionTranslations = [
            ['group' => 'translation', 'key' => 'translation', 'text' => json_encode(['en' => 'translation', 'hn' => 'अनुवाद']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'user', 'key' => 'user', 'text' => json_encode(['en' => 'User', 'hn' => 'उपयोगकर्ता']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'role', 'key' => 'role', 'text' => json_encode(['en' => 'Role', 'hn' => 'भूमिका']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'permission', 'key' => 'permission', 'text' => json_encode(['en' => 'Permission', 'hn' => 'अनुमति']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'schedule', 'key' => 'schedule', 'text' => json_encode(['en' => 'Schedule', 'hn' => 'अनुसूची']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'home', 'key' => 'home', 'text' => json_encode(['en' => 'Home', 'hn' => 'घर']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'home', 'key' => 'dashboard', 'text' => json_encode(['en' => 'dashboard', 'hn' => 'डैशबोर्ड']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'chat', 'key' => 'chat', 'text' => json_encode(['en' => 'Chat', 'hn' => 'बात करना']), 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'setting', 'key' => 'setting', 'text' => json_encode(['en' => 'Setting', 'hn' => 'सेटिंग']), 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::beginTransaction();

        try {
            foreach ($promotionTranslations as $translation) {
                DB::table('language_lines')->updateOrInsert(
                    [
                        'group' => $translation['group'],
                        'key' => $translation['key'],
                    ],
                    [
                        'text' => $translation['text'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
                DB::commit();
            }
        } catch (\Exception $e) {
            echo 'failed to seed';
            DB::rollBack();
        }
    }
}
