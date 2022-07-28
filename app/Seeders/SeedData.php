<?php

namespace App\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Exceptions\InvalidSeeddataException;

interface DataInterface
{
    public function __construct(string $filepath, int $fetch_size);
    public function fetch();
}

class SeedData implements DataInterface
{
    private DataInterface $data;

    public function __construct(string $filepath, int $fetch_size)
    {
        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
        switch($extension) {
            case 'csv':
                $this->data = new CsvData($filepath, $fetch_size);
                break;
            default:
                throw new InvalidSeeddataException($extension);
        }
    }

    public function fetch()
    {
        return $this->data->fetch();
    }
}

class CsvData implements DataInterface
{
    private $data;
    private $header;
    private $fetch_size;

    public function __construct(string $filepath, int $fetch_size)
    {
        $this->data = new \SplFileObject($filepath);
        $this->data->setFlags(
            \SplFileObject::DROP_NEW_LINE |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::READ_CSV
            );
        $this->header = $this->data->fgetcsv();
        $this->fetch_size = $fetch_size;
    }

    public function fetch()
    {
        $count = 0;
        $records = [];

        while($this->data->valid()) {
            $rcd = $this->data->fgetcsv();
            if(!is_array($rcd)) continue;

            $records[] = $this->toObject($rcd);
            if(++$count >= $this->fetch_size) {
                yield $records;
                $records = [];
                $count = 0;
            }
        }
        yield $records;
    }

    private function toObject($list) {
        $obj = [];
        foreach($list as $k => $v) {
            $obj[ $this->header[$k] ] = $v;
        }
        return $obj;
    }
}
