<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============       ================
 * BM_2024_03_28_040006_adverts Migration 
 * ===============       ================
 * ======================================
 */

namespace PhpStrike\migrations;

use celionatti\Bolt\Migration\BoltMigration;

class BM_2024_03_28_040006_adverts extends BoltMigration
{
    /**
     * The Up method is to create table.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable("adverts")
            ->id()->primaryKey()
            ->varchar("advert_id")->nullable()
            ->varchar("name", 100)->nullable()
            ->text("advert_img")->nullable()
            ->enum("priority", ['low', 'medium', 'high', 'banner', 'none'])->defaultValue("none")
            ->enum("status", ['open', 'closed', 'expired', 'pending'])->defaultValue("pending")
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
        $this->dropTable("adverts");
    }
}
