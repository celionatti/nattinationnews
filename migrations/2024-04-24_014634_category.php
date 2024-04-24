<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_04_24_014634_category Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_04_24_014634_category extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("categories")
            ->id()->primaryKey()
            ->varchar("category_id", 255)->nullable()
            ->varchar("category")
            ->varchar("category_info")
            ->varchar("child")->nullable()
            ->enum("section", ['navbar', 'sidebar', 'footer', 'footer_sidebar', 'none'])->defaultValue("none")
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
        $this->dropTable("categories");
    }
}