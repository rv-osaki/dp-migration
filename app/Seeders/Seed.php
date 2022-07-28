<?php

namespace App\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

const DEFAULT_FETCH_SIZE = 1000;

class Seed
{
    private $data;
    private $table;

    public function __construct(string $table, string $seedfilepath, int $fetchSize = DEFAULT_FETCH_SIZE)
    {
        $this->data = new SeedData($seedfilepath, $fetchSize);
        $this->table = DB::table($table);
    }

    public function run()
    {
        DB::transaction(function() {
            $this->table->truncate();
            foreach($this->data->fetch() as $records) {
                $this->table->insert($records);
            }
        });
    }
}
