<?php

class m170730_024303_update_users_add_phone extends CDbMigration
{
	/**
	 * Adds the phone number column to the users table.
	 */
	public function up()
	{
		$this->addColumn('users', 'phone', 'string NOT NULL');
		$this->createIndex('users_phone', 'users', 'phone', true);
	}

	/**
	 * Remove the phone number column for the users table.
	 */
	public function down()
	{
		$this->dropIndex('users_phone', 'users');
		$this->dropColumn('users', 'phone');
	}
}