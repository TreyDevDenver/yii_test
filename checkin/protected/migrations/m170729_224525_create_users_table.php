<?php

class m170729_224525_create_users_table extends CDbMigration
{
	/**
	 * Create the users table. 
	 * Used to store user deatils.
	 */
	public function up()
	{
		$this->createTable('users', array(
			'id' => 'pk',
			'first_name' => 'string NOT NULL',
			'last_name' => 'string NOT NULL',
			'email' => 'string NOT NULL',
		));
	}

	/**
	 * Remove the users table.
	 */
	public function down()
	{
		$this->dropTable('users');
	}
}