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
 * @author Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class ProtectSite extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ProtectSite'/*class*/, 'protectsite'/*restriction*/ );
	}

	public function doesWrites() {
		return true;
	}

	/**
	 * Show the special page
	 *
	 * @param mixed|null $par Parameter passed to the page
	 */
	public function execute( $par ) {
		$user = $this->getUser();

		// If the user doesn't have 'protectsite' permission, display an error
		$this->checkPermissions();

		// Show a message if the database is in read-only mode
		$this->checkReadOnly();

		// If user is blocked, s/he doesn't need to access this page
		if ( $user->getBlock() ) {
			throw new UserBlockedError( $user->getBlock() );
		}

		$this->setHeaders();

		$form = new ProtectSiteForm( $this->getRequest(), $user );
	}

	/**
	 * Persistent data is unserialized from a record in the objectcache table
	 * which is set in the special page. It will change the permissions for
	 * various functions for anonymous and registered users based on the data
	 * in the array. The data expires after the set amount of time, just like
	 * a block.
	 */
	public static function setup() {
		/* Globals */
		global $wgGroupPermissions, $wgMemc, $wgProtectSiteExempt, $wgCommandLineMode;

		// macbre: don't run code below when running in command line mode (memcache starts to act strange)
		if ( !empty( $wgCommandLineMode ) ) {
			return;
		}

		/* Initialize Object */
		$persist_data = new SqlBagOStuff( [] );

		/* Get data into the prot hash */
		$prot = $wgMemc->get( $wgMemc->makeKey( 'protectsite' ) );
		if ( !$prot ) {
			$prot = $persist_data->get( 'protectsite' );
			if ( !$prot ) {
				$wgMemc->set( $wgMemc->makeKey( 'protectsite' ), 'disabled' );
			}
		}

		/* Logic to disable the selected user rights */
		if ( is_array( $prot ) ) {
			/* MW doesn't timeout correctly, this handles it */
			if ( time() >= $prot['until'] ) {
				$persist_data->delete( 'protectsite' );
			}

			/* Protection-related code for MediaWiki 1.8+ */
			$wgGroupPermissions['*']['createaccount'] = !( $prot['createaccount'] >= 1 );
			$wgGroupPermissions['user']['createaccount'] = !( $prot['createaccount'] == 2 );

			$wgGroupPermissions['*']['createpage'] = !( $prot['createpage'] >= 1 );
			$wgGroupPermissions['*']['createtalk'] = !( $prot['createpage'] >= 1 );
			$wgGroupPermissions['user']['createpage'] = !( $prot['createpage'] == 2 );
			$wgGroupPermissions['user']['createtalk'] = !( $prot['createpage'] == 2 );

			$wgGroupPermissions['*']['edit'] = !( $prot['edit'] >= 1 );
			$wgGroupPermissions['user']['edit'] = !( $prot['edit'] == 2 );
			$wgGroupPermissions['sysop']['edit'] = true;
			$wgGroupPermissions['sysop']['createpage'] = true;

			$wgGroupPermissions['user']['move'] = !( $prot['move'] == 1 );
			$wgGroupPermissions['user']['upload'] = !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload'] = !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload-shared'] = !( $prot['upload'] == 1 );

			// are there any groups that should not get affected by ProtectSite's lockdown?
			if ( !empty( $wgProtectSiteExempt ) && is_array( $wgProtectSiteExempt ) ) {
				// there are, so loop over them, and force these rights to be true
				// will resolve any problems from inheriting rights from 'user' or 'sysop'
				foreach ( $wgProtectSiteExempt as $exemptGroup ) {
					$wgGroupPermissions[$exemptGroup]['createaccount'] = 1;
					$wgGroupPermissions[$exemptGroup]['edit'] = 1;
					$wgGroupPermissions[$exemptGroup]['createpage'] = 1;
					$wgGroupPermissions[$exemptGroup]['createtalk'] = 1;
					$wgGroupPermissions[$exemptGroup]['move'] = 1;
					$wgGroupPermissions[$exemptGroup]['upload'] = 1;
					$wgGroupPermissions[$exemptGroup]['reupload'] = 1;
					$wgGroupPermissions[$exemptGroup]['reupload-shared'] = 1;
				}
			}
		}
	}

}
