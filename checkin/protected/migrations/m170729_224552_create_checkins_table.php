<?php

class m170729_224552_create_checkins_table extends CDbMigration
{
	/**
	 * Create the checkin table. 
	 * Used to store when a user checked-in and how many points they were awarded.
	 */
	public function up()
	{
		$this->createTable('checkins', array(
			'id' => 'pk',
			'user_id' => 'integer NOT NULL',
			'num_points' => 'integer NOT NULL',
			'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
		));
	}

	/**
	 * Remove the checkin table.
	 */
	public function down()
	{
		$this->dropTable('checkins');
	}
}