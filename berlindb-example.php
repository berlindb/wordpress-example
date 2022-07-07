<?php
/**
 * Plugin Name:       BerlinDB Example
 * Plugin URI:        https://github.com/berlindb/wordpress-example/
 * Description:       An example plugin
 * Version:           1.0.0
 * Author:            BerlinDB
 * Author URI:        https://github.com/berlindb/
 * Text Domain:       berlindb-example
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugin_dir = plugin_dir_path( __FILE__ );

/**
 * REQUIRE BERLINDB.
 */
require_once( $plugin_dir . 'core/autoloader.php' );

/**
 * BOOKS TABLE REQUIRED FILES.
 * Below are the files that ultimately build the database table "books"
 */

// Books Table. This specifies the table name, manages table version and upgrade routines, and builds the table.
require_once( $plugin_dir . 'class-books-table.php' );

// Books Schema. This specifies how the table can be queried, and what columns are in the table.
require_once( $plugin_dir . 'class-books-schema.php' );

// Book Row Instance. When queried, each record that is retrieved is returned as an instance of this class.
// BerlinDB refers to this as "shaping"
require_once( $plugin_dir . 'class-book.php' );

// Book Query. This is the class you call to interact with the database class. Sort-of like an advanced WP_Query.
require_once( $plugin_dir . 'class-book-query.php' );

/**
 * TABLE SETUP
 * This creates the database tables, and add the table to the database.
 */

// Instantiate the Books Table class.
$table = new Books_Table;

// Uninstall the database. Uncomment this code to force the database to rebuild.
//if($table->exists()){
//	$table->uninstall();
//}

// If the table does not exist, then create the table.
if ( ! $table->exists() ) {
	$table->install();
}

/**
 * ADDING RECORDS
 * This snippet shows how records can be added to the database.
 */
add_action( 'init', function () {

	// First, we're going to see if the database already has records. If it does, we'll skip adding these records.
	// This prevents duplicate records from being created on each page load.
	$query = new Book_Query( [
		'number' => 1,    // Only retrieve a single record
		'fields' => 'ids' // Just return an array of IDs. This helps keep our query performant.
	] );

	// If the query didn't find any records, create the records.
	if ( empty( $query->items ) ) {
		$records = [
			[
				'isbn'           => '0-7475-3269-9',
				'title'          => 'Harry Potter and the Philosopher\'s Stone',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'June 26, 1997' ) ),
			],
			[
				'isbn'           => '0-4390-6486-4',
				'title'          => 'Harry Potter and the Chamber of Secrets',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'June 2, 1999' ) ),
			],
			[
				'isbn'           => '0-4396-5548-X',
				'title'          => 'Harry Potter and the Prisoner of Azkaban',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'July 8, 1999' ) ),
			],
			[
				'isbn'           => '0-4391-3959-7',
				'title'          => 'Harry Potter and the Goblet of Fire',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'July 8, 2000' ) ),
			],
			[
				'isbn'           => '0-4393-5807-8',
				'title'          => 'Harry Potter and the Order of the Phoenix',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'June 21, 2003' ) ),
			],
			[
				'isbn'           => '0-4397-8454-9',
				'title'          => 'Harry Potter and the Half-Blood Prince',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'July 16, 2005' ) ),
			],
			[
				'isbn'           => '0-7475-9105-9',
				'title'          => 'Harry Potter and the Deathly Hallows',
				'author'         => 'J.K. Rowling',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'July 21, 2007' ) ),
			],
			[
				'isbn'           => '0-4390-2352-1',
				'title'          => 'The Hunger Games',
				'author'         => 'Suzanne Collins',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'September 14, 2008' ) ),
			],
			[
				'isbn'           => '0-4390-2349-1',
				'title'          => 'Catching Fire',
				'author'         => 'Suzanne Collins',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'September 1, 2009' ) ),
			],
			[
				'isbn'           => '0-4390-2351-3',
				'title'          => 'Mockingjay',
				'author'         => 'Suzanne Collins',
				'date_created'   => current_time( 'mysql', true ),
				'date_published' => date( 'Y-m-d H:i:s', strtotime( 'August 24, 2010' ) ),
			],
		];

		// Loop through and add records
		foreach ( $records as $record ) {
			$query->add_item( $record );
		}
	}
} );

/**
 * QUERYING RECORDS
 * Here's a basic example on how to fetch records from the database.
 * This example hooks into WordPress's the_content, but this could be done anywhere.
 */
add_filter( 'the_content', function ( $content ) {
	if ( defined('REST_REQUEST') ) {
		return $content;
	}

	$query = new Book_Query( [
		'author'  => 'J.K. Rowling',   // Only get books written by J.K Rowling
		'orderby' => 'date_published', // Sort the books by the date they were published
		'order'   => 'asc',            // Use ascending order
	] );

	foreach ( $query->items as $item ) {
		// Queried items become instances of Book. This method is declared in our Book class.
		echo $item->display();
	}

	return $content;
} );
