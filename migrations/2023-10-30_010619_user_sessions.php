<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2023_10_30_010619_user_sessions Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2023_10_30_010619_user_sessions extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("user_sessions")
            ->id()->primaryKey()
            ->varchar("user_id", 255)->nullable()
            ->varchar("token_hash")->nullable()
            ->varchar("expiration")->nullable()
            ->build();
    }

    /**
     * The Down method is to drop table
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable("user_sessions");
    }
}