<?php
/**
 * This extension provides Special:ProtectSite, which makes it possible for
 * users with protectsite permissions to quickly lock down and restore various
 * privileges for anonymous and registered users on a wiki.
 *
 * Knobs:
 * 'protectsite' - Group permission to use the special page.
 * $wgProtectSiteLimit - Maximum time allowed for protection of the site.
 * $wgProtectSiteDefaultTimeout - Default protection time.
 * $wgProtectSiteExempt - Array of non-sysop usergroups to be not effected by rights changes
 *
 * @file
 * @ingroup Extensions
 * @author Eric Johnston <e.wolfie@gmail.com>
 * @author Chris Stafford <c.stafford@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/* Extension Credits. Splarka wants me to be so UN:VAIN! Haet haet hat! */
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Protect Site',
	'version' => '0.5.0',
	'author' => array( '[http://en.uncyclopedia.co/wiki/User:Dawg Eric Johnston]', 'Chris Stafford', 'Jack Phoenix' ),
	'descriptionmsg' => 'protectsite-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ProtectSite',
	'license-name' => 'GPL-2.0+',
);

# Configuration settings
// Array of non-sysop user groups to be not effected by rights changes
$wgProtectSiteExempt = array();

/* Set the default timeout. */
$wgProtectsiteDefaultTimeout = '1 hour';

// Maximum time allowed for protection of the site
$wgProtectSiteLimit = '1 week';

/* Register the new user rights level */
$wgAvailableRights[] = 'protectsite';

/* Set the group access permissions */
$wgGroupPermissions['bureaucrat']['protectsite'] = true;

/* Add this special page to the special page listing array */
$wgMessagesDirs['ProtectSite'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['ProtectSiteAliases'] = __DIR__ . '/ProtectSite.alias.php';
$wgAutoloadClasses['ProtectSite'] = __DIR__ . '/ProtectSite.body.php';
$wgAutoloadClasses['ProtectSiteForm'] = __DIR__ . '/ProtectSite.body.php';
$wgSpecialPages['ProtectSite'] = 'ProtectSite';

/* Register initialization function */
$wgExtensionFunctions[] = 'ProtectSite::setup';