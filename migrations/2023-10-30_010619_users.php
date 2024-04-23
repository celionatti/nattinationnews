<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2023_10_30_010619_users Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2023_10_30_010619_users extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("users")
            ->id()->primaryKey()
            ->varchar("user_id")->index("user_id")
            ->varchar("surname")->index("surname")
            ->varchar("othername")->index("othername")
            ->varchar("email")->uniquekey("email")
            ->varchar("phone", 20)->nullable()
            ->varchar("avatar", 300)->nullable()
            ->varchar("password")
            ->enum("gender", ['male', 'female', 'others'])->defaultValue("others")
            ->enum("role", ['user', 'admin', 'editor', 'journalist', 'manager'])->defaultValue("user")
            ->varchar("social", 300)->nullable()
            ->varchar("bio", 500)->nullable()
            ->varchar("token", 300)->nullable()
            ->timestamp("token_expiration")->nullable()
            ->tinyint("is_verified")->defaultValue(0)
            ->tinyint("is_blocked")->defaultValue(0)
            ->enum("subscriber", ['true', 'false'])->defaultValue("false")
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
        $this->dropTable("users");
    }
}