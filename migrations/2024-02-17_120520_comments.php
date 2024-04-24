<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_02_17_120520_comments Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_02_17_120520_comments extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("comments")
            ->id()->primaryKey()
            ->varchar("comment_id", 255)
            ->varchar("article_id", 255)
            ->varchar("reply_id")->nullable()
            ->varchar("user_id", 255)->defaultValue("anonymous")
            ->text("comment_text")
            ->enum("status", ['active', 'pending', 'failed'])->defaultValue("active")
            ->varchar("failure_reason")->nullable()
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
        $this->dropTable("comments");
    }
}