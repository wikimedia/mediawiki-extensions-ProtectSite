<?php
/**
 * Aliases for ProtectSite extension.
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English */
$specialPageAliases['en'] = array(
	'ProtectSite' => array( 'ProtectSite' ),
);

/** Finnish (Suomi) */
$specialPageAliases['fi'] = array(
	'ProtectSite' => array( 'SuojaaSivusto', 'Suojaa sivusto' ),
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;