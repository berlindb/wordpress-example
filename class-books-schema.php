<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Books_Schema extends \BerlinDB\Database\Schema {

	public $columns = [

		//id
		'id'           => [
			'name'     => 'id',
			'type'     => 'bigint',
			'length'   => '20',
			'unsigned' => true,
			'extra'    => 'auto_increment',
			'primary'  => true,
			'sortable' => true,
		],

		//isbn
		'isbn'         => [
			'name'       => 'isbn',
			'type'       => 'tinytext',
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		],

		//title
		'title'         => [
			'name'       => 'title',
			'type'       => 'mediumtext',
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		],

		//author
		'author'         => [
			'name'       => 'author',
			'type'       => 'mediumtext',
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		],

		//date_created
		'date_created' => [
			'name'       => 'date_created',
			'type'       => 'datetime',
			'date_query' => true,
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		],

		//date_published
		'date_published' => [
			'name'       => 'date_published',
			'type'       => 'datetime',
			'date_query' => true,
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		],

	];

}