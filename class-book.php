<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Book extends BerlinDB\Database\Row {

	/**
	 * Book constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param $item
	 */
	public function __construct( $item ) {
		parent::__construct( $item );

		// This is optional, but recommended. Set the type of each column, and prepare.
		$this->id             = (int) $this->id;
		$this->isbn           = (string) $this->isbn;
		$this->title          = (string) $this->title;
		$this->author         = (string) $this->author;
		$this->date_created   = false === $this->date ? 0 : strtotime( $this->date_created );
		$this->date_published = false === $this->date ? 0 : strtotime( $this->date_published );
	}

	/**
	 * Retrieves the HTML to display the information about this book.
	 *
	 * @since 1.0.0
	 *
	 * @return string HTML output to display this record's data.
	 */
	public function display() {
		$result = "<h3>" . $this->title . "</h3>";
		$result .= "<dl>";
		$result .= "<dt>Author: </dt><dd>" . $this->author . "</dd>";
		$result .= "<dt>ISBN: </dt><dd>" . $this->isbn . "</dd>";
		$result .= "<dt>Published: </dt><dd>" . date( 'M d, Y', $this->date_published ) . "</dd>";
		$result .= "</dl>";
		return $result;
	}

}