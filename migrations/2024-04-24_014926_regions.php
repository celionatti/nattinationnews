<?php

declare (strict_types = 1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_04_24_014926_regions Migration
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_04_24_014926_regions extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("regions")
            ->id()->primaryKey()
            ->varchar("region_id", 255)->nullable()
            ->varchar("region")
            ->varchar("region_info")
            ->enum("status", ['active', 'disable'])->defaultValue("disable")
            ->timestamps()
            ->build();
    }

    /**
     * The Down method is to drop table
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable("regions");
    }
}
