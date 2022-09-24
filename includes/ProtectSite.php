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
 * @license GPL-2.0-or-later
 */

use MediaWiki\MediaWikiServices;

class ProtectSite extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ProtectSite'/*class*/, 'protectsite'/*restriction*/ );
	}

	/** @inheritDoc */
	public function doesWrites() {
		return true;
	}

	/**
	 * Show the special page
	 *
	 * @param string|null $par Parameter passed to the page
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
		global $wgGroupPermissions, $wgProtectSiteExempt, $wgCommandLineMode;

		// macbre: don't run code below when running in command line mode (memcache starts to act strange)
		if ( !empty( $wgCommandLineMode ) ) {
			return;
		}

		$params = [
			'localKeyLB' => [
				'factory' => static function () {
					return MediaWikiServices::getInstance()->getDBLoadBalancer();
				}
			]
		];

		/* Initialize Object */
		$persist_data = new SqlBagOStuff( $params );

		$cache = MediaWikiServices::getInstance()->getMainWANObjectCache();

		/* Get data into the prot hash */
		$prot = $cache->get( $cache->makeKey( 'protectsite' ) );
		if ( !$prot ) {
			$prot = $persist_data->get( 'protectsite' );
			if ( !$prot ) {
				$cache->set( $cache->makeKey( 'protectsite' ), 'disabled' );
			}
		}

		/* Logic to disable the selected user rights */
		if ( is_array( $prot ) ) {
			/* MW doesn't timeout correctly, this handles it */
			if ( time() >= $prot['until'] ) {
				$persist_data->delete( 'protectsite' );
			}

			/* Protection-related code for MediaWiki 1.8+ */
			// phpcs:disable Generic.Files.LineLength.TooLong
			$wgGroupPermissions['*']['createaccount'] = ( $wgGroupPermissions['*']['createaccount'] ?? false ) && !( $prot['createaccount'] >= 1 );
			$wgGroupPermissions['user']['createaccount'] = ( $wgGroupPermissions['user']['createaccount'] ?? false ) && !( $prot['createaccount'] == 2 );

			$wgGroupPermissions['*']['createpage'] = ( $wgGroupPermissions['*']['createpage'] ?? false ) && !( $prot['createpage'] >= 1 );
			$wgGroupPermissions['*']['createtalk'] = ( $wgGroupPermissions['*']['createtalk'] ?? false ) && !( $prot['createpage'] >= 1 );
			$wgGroupPermissions['user']['createpage'] = ( $wgGroupPermissions['user']['createpage'] ?? false ) && !( $prot['createpage'] == 2 );
			$wgGroupPermissions['user']['createtalk'] = ( $wgGroupPermissions['user']['createtalk'] ?? false ) && !( $prot['createpage'] == 2 );

			$wgGroupPermissions['*']['edit'] = ( $wgGroupPermissions['*']['edit'] ?? false ) && !( $prot['edit'] >= 1 );
			$wgGroupPermissions['user']['edit'] = ( $wgGroupPermissions['user']['edit'] ?? false ) && !( $prot['edit'] == 2 );
			$wgGroupPermissions['sysop']['edit'] = true;
			$wgGroupPermissions['sysop']['createpage'] = true;

			$wgGroupPermissions['user']['move'] = ( $wgGroupPermissions['user']['move'] ?? false ) && !( $prot['move'] == 1 );
			$wgGroupPermissions['user']['upload'] = ( $wgGroupPermissions['user']['upload'] ?? false ) && !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload'] = ( $wgGroupPermissions['user']['reupload'] ?? false ) && !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload-shared'] = ( $wgGroupPermissions['user']['reupload-shared'] ?? false ) && !( $prot['upload'] == 1 );
			// phpcs:enable

			// are there any groups that should not get affected by ProtectSite's lockdown?
			if ( !empty( $wgProtectSiteExempt ) && is_array( $wgProtectSiteExempt ) ) {
				// there are, so loop over them, and force these rights to be true
				// will resolve any problems from inheriting rights from 'user' or 'sysop'
				foreach ( $wgProtectSiteExempt as $exemptGroup ) {
					$wgGroupPermissions[$exemptGroup]['createaccount'] = true;
					$wgGroupPermissions[$exemptGroup]['edit'] = true;
					$wgGroupPermissions[$exemptGroup]['createpage'] = true;
					$wgGroupPermissions[$exemptGroup]['createtalk'] = true;
					$wgGroupPermissions[$exemptGroup]['move'] = true;
					$wgGroupPermissions[$exemptGroup]['upload'] = true;
					$wgGroupPermissions[$exemptGroup]['reupload'] = true;
					$wgGroupPermissions[$exemptGroup]['reupload-shared'] = true;
				}
			}
		}
	}

}
