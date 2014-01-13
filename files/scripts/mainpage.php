<?php

require_once __DIR__ . '/../mediawiki/master/maintenance/Maintenance.php';

class MainPageCreator extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Create main page';
	}

	public function execute() {
		$title = Title::newFromText( 'Main Page' );

		if ( $title->exists() === false ) {
		    $text = file_get_contents( __DIR__ . '/../static/mainpage.txt' );
		    $page = WikiPage::factory( $title );
			$content = ContentHandler::makeContent( $text, $title );
			$page->doEditContent( $content, 'create main page');

			echo "created main page\n";
		} else {
			echo "main page already exists\n";
		}
	}

}

$maintClass = 'MainPageCreator';
require_once RUN_MAINTENANCE_IF_MAIN;
