<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            // superAdmin -> can view and perform CRUD to all companies and all branches
            'name' => 'infosas',
            'email' => 'infosas2019@infosasics.com',
            'password' => bcrypt('ics@gits'),
            'branch_id' => -1,
            'company_id' => -1,
        ]);
    }
}
