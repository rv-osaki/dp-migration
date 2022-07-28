<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 環境横断的に登録する
        // $this->call(SampleUser::class);

        // 環境別に切り分ける
        // if(App::Environment() === 'production') {
        //     $this->call(SampleUser::class);
        // } else {
        //     $this->call(SampleUser::class);
        // }
    }
}
