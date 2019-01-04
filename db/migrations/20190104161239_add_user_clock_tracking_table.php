<?php
/*
 * This file is part of the Eventum (Issue Tracking System) package.
 *
 * @copyright (c) Eventum Team
 * @license GNU General Public License, version 2 or later (GPL-2+)
 *
 * For the full copyright and license information,
 * please see the COPYING and AUTHORS files
 * that were distributed with this source code.
 */

use Eventum\Db\AbstractMigration;

class AddUserClockTrackingTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('user_clock_tracking', ['id' => false, 'primary_key' => 'uct_id', 'engine' => "InnoDB"])
            ->addColumn('uct_id', 'integer', ['length' => 10, 'signed' => false])
            ->addColumn('uct_usr_id', 'integer', ['length' => 10, 'null' => false, 'signed' => false])
            ->addColumn('uct_clocked_in', 'datetime', ['null' => false])
            ->addColumn('uct_clocked_out', 'datetime', ['null' => true])
            ->addColumn('uct_time_spent', 'integer', ['default' => 0, 'signed' => false])
            ->addIndex(['uct_usr_id']);
        $this->getPrimaryKey($table)->setIdentity(true);
        $table->create();
    }
}
