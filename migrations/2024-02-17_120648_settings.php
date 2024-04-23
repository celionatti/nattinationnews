<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_02_17_120648_settings Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_02_17_120648_settings extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("settings")
            ->id()->primaryKey()
            ->varchar("setting_id")->nullable()
            ->varchar("name", 100)->nullable()
            ->text("value")->nullable()
            ->enum("status", ['active', 'inactive'])->defaultValue("inactive")
            ->build();
    }

    /**
     * The Down method is to drop table
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable("settings");
    }
}