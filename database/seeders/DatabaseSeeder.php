<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // شغّل السيّدَر الخاص بإنشاء صلاحيات النظام أولًا
        $this->call(PermissionTableSeeder::class);

        // ثم إنشاء المستخدم الإداري وتعيين الصلاحيات
        $this->call(CreateAdminUserSeeder::class);
    }
}
