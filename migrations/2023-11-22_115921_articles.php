<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2023_11_22_115921_articles Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2023_11_22_115921_articles extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("articles")
            ->id()->primaryKey()
            ->varchar("article_id", 255)->nullable()
            ->varchar("category_id", 255)->nullable()
            ->varchar("region_id", 255)->nullable()
            ->enum("is_editors_pick", ['true', 'false'])->defaultValue("false")
            ->enum("featured_article", ['true', 'false'])->defaultValue("false")
            ->int("views")->defaultValue(0)
            ->varchar("title",  2000)
            ->text("content")
            ->varchar("key_point", 500)
            ->text("tags")
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
        $this->dropTable("articles");
    }
}