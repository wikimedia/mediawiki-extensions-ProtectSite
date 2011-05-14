<?php
/**
 * Aliases for ProtectSite extension.
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'ProtectSite' => array( 'ProtectSite' ),
);

/** Arabic (العربية) */
$specialPageAliases['ar'] = array(
	'ProtectSite' => array( 'حماية_الموقع' ),
);

/** Finnish (Suomi) */
$specialPageAliases['fi'] = array(
	'ProtectSite' => array( 'SuojaaSivusto', 'Suojaa sivusto' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'ProtectSite' => array( 'SiteBeveiligen' ),
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;