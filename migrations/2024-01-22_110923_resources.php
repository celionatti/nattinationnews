<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_01_22_110923_resources Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_01_22_110923_resources extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("resources")
            ->id()->primaryKey()
            ->varchar("resource_id", 255)->nullable()
            ->varchar("user_id")->nullable()->foreignKey("user_id", "users", "user_id")
            ->varchar("title",  2000)
            ->text("content")
            ->text("category")
            ->text("thumbnail")->nullable()
            ->varchar("thumbnail_caption")->nullable()
            ->text("resource")->nullable()
            ->varchar("meta_title")->nullable()
            ->varchar("meta_description")->nullable()
            ->varchar("meta_keywords")->nullable()
            ->enum("status", ['draft', 'publish', 'delete'])->defaultValue("draft")
            ->timestamps()
            ->build(true);
    }

    /**
     * The Down method is to drop table
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable("resources");
    }
}