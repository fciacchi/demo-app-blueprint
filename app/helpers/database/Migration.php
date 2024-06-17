<?php

namespace App\Helpers\Database;

use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

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

    public function dropForeignKey($table, $column)
    {
        $foreignKeyName = "{$table}_{$column}_foreign";

        if ($this->database::$capsule::schema()->hasColumn($table, $column)) {
            if ($this->database::$capsule::schema()->hasTable('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')) {
                $foreignKeys = $this->database::$capsule::select(
                    "SELECT CONSTRAINT_NAME 
                        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                        WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND CONSTRAINT_NAME = ?",
                        [$table, $column, $foreignKeyName]
                );

                if (!empty($foreignKeys)) {
                    $this->database::$capsule::schema()->table($table, function (Blueprint $table) use ($column) {
                        $table->dropForeign([$column]);
                    });
                }
            }
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