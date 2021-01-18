<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Books_Table extends \BerlinDB\Database\Table {

	/**
	 * Table name, without the global table prefix.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $name = 'books';

	/**
	 * Database version key (saved in _options or _sitemeta)
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $db_version_key = 'books_version';

	/**
	 * Optional description.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $description = 'Books';

	/**
	 * Database version.
	 *
	 * @since 1.0.0
	 * @var   mixed
	 */
	protected $version = '1.0.0';

	/**
	 * Key => value array of versions => methods.
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	protected $upgrades = array();

	/**
	 * Setup this database table.
	 *
	 * @since 1.0.0
	 */
	protected function set_schema() {
		$this->schema = "
			id  bigint(20) NOT NULL AUTO_INCREMENT,
			isbn            tinytext   NOT NULL,
			title           mediumtext NOT NULL,
			author          mediumtext NOT NULL,
			date_created    DATETIME   NOT NULL,
			date_published  DATETIME   NOT NULL,
			PRIMARY KEY (id)
			";
	}
}