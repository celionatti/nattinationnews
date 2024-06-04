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
            ->varchar("id_number")->index("id_number")
            ->varchar("surname")->index("surname")
            ->varchar("name")->index("name")
            ->varchar("email")->uniquekey("email")
            ->varchar("phone", 20)->nullable()
            ->varchar("avatar", 300)->nullable()
            ->varchar("password")
            ->enum("gender", ['male', 'female', 'others'])->defaultValue("others")
            ->enum("role", ['admin', 'editor', 'journalist', 'manager', 'graphic_designer', 'community_manager', 'content_officer', 'none'])->defaultValue("none")
            ->varchar("facebook", 300)->nullable()
            ->varchar("twitter", 300)->nullable()
            ->varchar("instagram", 300)->nullable()
            ->varchar("bio", 500)->nullable()
            ->varchar("birth_date", 500)->nullable()
            ->varchar("file", 500)->nullable()
            ->varchar("token", 300)->nullable()
            ->tinyint("is_verified")->defaultValue(0)
            ->tinyint("is_blocked")->defaultValue(0)
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