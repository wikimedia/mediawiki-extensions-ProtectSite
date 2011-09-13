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
	'ProtectSite' => array( 'Suojaa_sivusto' ),
);

/** Macedonian (Македонски) */
$specialPageAliases['mk'] = array(
	'ProtectSite' => array( 'ЗаштитиМрежноМесто' ),
);

/** Nedersaksisch (Nedersaksisch) */
$specialPageAliases['nds-nl'] = array(
	'ProtectSite' => array( 'Webstee_beveiligen' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'ProtectSite' => array( 'SiteBeveiligen' ),
);

/** Swedish (Svenska) */
$specialPageAliases['sv'] = array(
	'ProtectSite' => array( 'Skydda_sida' ),
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;