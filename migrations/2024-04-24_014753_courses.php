<?php

declare (strict_types = 1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_04_24_014753_courses Migration
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_04_24_014753_courses extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("courses")
            ->id()->primaryKey()
            ->varchar("course_id", 255)->nullable()
            ->varchar("category_id", 255)->nullable()
            ->int("views")->defaultValue(0)
            ->int("downloads")->defaultValue(0)
            ->varchar("title", 2000)
            ->text("content")
            ->text("upload")->nullable()
            ->text("thumbnail")->nullable()
            ->varchar("thumbnail_caption")->nullable()
            ->text("image")->nullable()
            ->varchar("image_caption")->nullable()
            ->varchar("user_id")->nullable()->foreignKey("user_id", "users", "user_id")
            ->varchar("authors")->nullable()
            ->varchar("meta_title")->nullable()
            ->varchar("meta_description")->nullable()
            ->varchar("meta_keywords")->nullable()
            ->enum("status", ['draft', 'publish'])->defaultValue("draft")
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
        $this->dropTable("courses");
    }
}
