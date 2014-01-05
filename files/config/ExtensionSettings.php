<?php

require_once ( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
require_once ( "$IP/extensions/Cite/Cite.php" );													 
require_once ( "$IP/extensions/SimpleAntiSpam/SimpleAntiSpam.php" );								 
require_once ( "$IP/extensions/CheckUser/CheckUser.php" );										   
require_once ( "$IP/extensions/cldr/cldr.php" );													 
require_once ( "$IP/extensions/CategoryTree/CategoryTree.php" );									 
require_once ( "$IP/extensions/SiteMatrix/SiteMatrix.php" );										 
require_once ( "$IP/extensions/Vector/Vector.php" );

$wgVectorFeatures['collapsibletabs']['user'] = true;												
$wgVectorFeatures['simplesearch'] = array( 'global' => true, 'user' => false );					 
$wgVectorFeatures['expandablesearch'] = array( 'global' => false, 'user' => false );				
$wgVectorUseSimpleSearch = true;																	

require_once ( "$IP/extensions/WikiEditor/WikiEditor.php" );										 

$wgDefaultUserOptions['usebetatoolbar'] = 1;														
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;													
$wgDefaultUserOptions['wikieditor-preview'] = 1;  
