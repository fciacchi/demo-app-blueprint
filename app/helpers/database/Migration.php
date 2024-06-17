<?php

namespace App\Helpers\Database;

use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class Migration
{
    private readonly \Leaf\Database $database;

    private string $tableName = 'migrations';

    public function __construct(private $fileName)
    {
        $this->database = new Database();
    }

    public function insert(): void
    {
        if (!$this->database::$capsule::schema()->hasTable($this->tableName)) {
            return;
        }

        if ($this->migrationExists()) {
            return;
        }

        $this->database::$capsule::table($this->tableName)
            ->insert(
                [
                'migration' => $this->fileName,
                ]
            );
    }

    public function delete(): void
    {
        if (!$this->database::$capsule::schema()->hasTable($this->tableName)) {
            return;
        }

        if (!$this->migrationExists()) {
            return;
        }

        $this->database::$capsule::table($this->tableName)
            ->where(
                'migration',
                $this->fileName
            )
            ->delete();
    }

    public function dropForeignKey($table, $column): void
    {
        $foreignKeyName = sprintf('%s_%s_foreign', $table, $column);

        if (
            $this->database::$capsule::schema()->hasColumn($table, $column)
            && $this->checkForeignKeyExistence($table, $column)
        ) {
            $foreignKeys = $this->database::$capsule::select(
                "SELECT CONSTRAINT_NAME 
                        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                        WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND CONSTRAINT_NAME = ?",
                [$table, $column, $foreignKeyName]
            );
            if (!empty($foreignKeys)) {
                $this->database::$capsule::schema()->table(
                    $table,
                    static function (Blueprint $blueprint) use ($column): void {
                        $blueprint->dropForeign([$column]);
                    }
                );
            }
        }
    }

    private function migrationExists()
    {
        return $this->database::$capsule::table($this->tableName)
            ->where(
                'migration',
                $this->fileName
            )->exists();
    }

    /**
     * Check if a foreign key exists for a given table and column.
     *
     * @param string $table
     * @param string $column
     */
    private function checkForeignKeyExistence($table, $column): bool
    {
        // Check database driver.
        $connection = $this->database::$capsule::connection();
        $driver = $connection->getDriverName();

        if ($driver === 'mysql') {
            // MySQL check.
            $result = $this->database::$capsule::select(
                "
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND TABLE_SCHEMA = DATABASE()
            ",
                [$table, $column]
            );

            return !empty($result);
        }

        return false;
    }
}
