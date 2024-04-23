<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_04_03_011933_contacts Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_04_03_011933_contacts extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("contacts")
            ->id()->primaryKey()
            ->varchar("contact_id")
            ->varchar("name")
            ->varchar("email")
            ->varchar("subject")->nullable()
            ->text("message")->nullable()
            ->timestamps()
            ->enum("status", ['read', 'unread'])->defaultValue("unread")
            ->enum("label", ['archive', 'spam', 'important', 'none'])->defaultValue("none")
            ->build();
    }

    /**
     * The Down method is to drop table
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable("contacts");
    }
}