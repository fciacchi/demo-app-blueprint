<?php

namespace App\Helpers\Database;

use Leaf\Database;

class Migration {
    private $database = null;
    private $tableName = 'migrations';
    private $fileName = '';

    public function __construct($fileName)
    {
        $this->database = new Database();
        $this->fileName = $fileName;
    }

    public function insert()
    {
        if ($this->database::$capsule::schema()->hasTable($this->tableName)
            && !$this->migrationExists()
        ) {

            $this->database::$capsule::table($this->tableName)
                ->insert([
                    'migration' => $this->fileName,
                ]);
        }
    }

    public function delete()
    {
        if ($this->database::$capsule::schema()->hasTable($this->tableName)
            && $this->migrationExists()
        ) {
            $this->database::$capsule::table($this->tableName)
                ->where(
                    'migration', $this->fileName
                )
                ->delete();
        }
    }

    private function migrationExists()
    {
        return $this->database::$capsule::table($this->tableName)
            ->where(
                'migration', $this->fileName
            )->exists();
    }
}