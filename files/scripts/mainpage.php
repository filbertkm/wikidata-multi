<?php

require_once __DIR__ . '/../php-master/maintenance/Maintenance.php';

class MainPageCreator extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Create main page';
	}

	public function execute() {
		global $wgDBname;

		if ( $wgDBname === 'wikidatawiki' ) {
			$mainPageTitleText = 'Wikidata:Main Page';
			$title = Title::newFromText( $mainPageTitleText );
			$messageTitle = Title::newFromText( 'MediaWiki:Mainpage' );
			$this->createPage( $messageTitle, $mainPageTitleText, 'create main page message' );

			$sidebarTitle = Title::newFromText( 'MediaWiki:Sidebar' );
			$text = file_get_contents( __DIR__ . '/../static/sidebar.txt' );
			$this->createPage( $sidebarTitle, $text, 'create sidebar' );
		} else {
			$title = Title::newFromText( 'Main Page' );
		}

		$this->createMainPage( $title );
	}

	private function createMainPage( Title $title ) {
		$text = file_get_contents( __DIR__ . '/../static/mainpage.txt' );
		$this->createPage( $title, $text, 'create main page' );
	}

	private function createPage( Title $title, $text, $summary ) {
		$titleText = $title->getPrefixedText();

		if ( $title->exists() ) {
			echo "$titleText page already exists.\n";
			return;
		}

		$page = WikiPage::factory( $title );
		$content = ContentHandler::makeContent( $text, $title );
		$page->doEditContent( $content, $summary );

		echo "created $titleText page.\n";
	}

}

$maintClass = 'MainPageCreator';
require_once RUN_MAINTENANCE_IF_MAIN;
