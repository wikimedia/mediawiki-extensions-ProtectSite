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

class ProtectSite extends FormSpecialPage {
	/** @var SqlBagOStuff */
	public $persist_data;
	/** @var WANObjectCache */
	public $wanCache;
	/** @var array */
	public $prot;

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

		// Show a message if the database is in read-only mode
		$this->checkReadOnly();

		// If user is blocked, they don't need to access this page
		if ( $user->getBlock() ) {
			throw new UserBlockedError( $user->getBlock() );
		}

		$this->persist_data = ObjectCache::getInstance( CACHE_DB );
		$this->wanCache = MediaWikiServices::getInstance()->getMainWANObjectCache();

		/* Get data into the value variable/array */
		$this->prot = $this->wanCache->get( $this->wanCache->makeKey( 'protectsite' ) );
		if ( !$this->prot ) {
			$this->prot = $this->persist_data->get( 'protectsite' );
		}

		if ( is_array( $this->prot ) ) {
			$this->getOutput()->addWikiMsg( 'protectsite-text-unprotect' );
		} else {
			$this->getOutput()->addWikiMsg( 'protectsite-text-protect' );
		}

		$this->getOutput()->addHTML( '<h3>' . $this->msg( 'protectsite-title' )->escaped() . '</h3>' );

		parent::execute( $par );
	}

	/** @inheritDoc */
	protected function getDisplayFormat() {
		return 'ooui';
	}

	/**
	 * @param string $name
	 * @param array $values
	 * @return array Two-dimensional label->value mapping array
	 */
	protected function getOptionsForFormField( string $name, array $values ) {
		$options = [];
		foreach ( $values as $val ) {
			$label = $this->msg( 'protectsite-' . $name . '-' . $val )->escaped();
			$options[$label] = $val;
		}
		return $options;
	}

	/**
	 * @param HTMLForm $form
	 */
	protected function alterForm( HTMLForm $form ) {
		if ( is_array( $this->prot ) ) {
			$form->setSubmitTextMsg( 'protectsite-unprotect' );
		} else {
			$form->setSubmitTextMsg( 'protectsite-protect' );
			$form->setSubmitDestructive();
		}
	}

	/**
	 * @return array
	 */
	protected function getFormFields() {
		global $wgProtectSiteDefaultTimeout, $wgProtectSiteLimit;

		$isProtected = is_array( $this->prot );

		$reqValues = $this->getRequest()->getValues();

		$createaccount = $this->getOptionsForFormField( 'createaccount', [ 0, 1, 2 ] );
		$createpage = $this->getOptionsForFormField( 'createpage', [ 0, 1, 2 ] );
		$edit = $this->getOptionsForFormField( 'edit', [ 0, 1, 2 ] );
		$move = $this->getOptionsForFormField( 'move', [ 0, 1 ] );
		$upload = $this->getOptionsForFormField( 'upload', [ 0, 1 ] );

		return [
			'createaccount' => [
				'type' => 'radio',
				'label-message' => 'protectsite-createaccount',
				'tabindex' => 1,
				'required' => true,
				'options' => $createaccount,
				'default' => $this->prot['createaccount'] ?? $reqValues['createaccount'] ?? 0,
				'disabled' => $isProtected
			],
			'createpage' => [
				'type' => 'radio',
				'label-message' => 'protectsite-createpage',
				'tabindex' => 1,
				'required' => true,
				'options' => $createpage,
				'default' => $this->prot['createpage'] ?? $reqValues['createpage'] ?? 0,
				'disabled' => $isProtected
			],
			'edit' => [
				'type' => 'radio',
				'label-message' => 'protectsite-edit',
				'tabindex' => 1,
				'required' => true,
				'options' => $edit,
				'default' => $this->prot['edit'] ?? $reqValues['edit'] ?? 0,
				'disabled' => $isProtected
			],
			'move' => [
				'type' => 'radio',
				'label-message' => 'protectsite-move',
				'tabindex' => 1,
				'required' => true,
				'options' => $move,
				'default' => $this->prot['move'] ?? $reqValues['move'] ?? 0,
				'disabled' => $isProtected
			],
			'upload' => [
				'type' => 'radio',
				'label-message' => 'protectsite-upload',
				'tabindex' => 1,
				'required' => true,
				'options' => $upload,
				'default' => $this->prot['upload'] ?? $reqValues['upload'] ?? 0,
				'disabled' => $isProtected
			],
			'timeout' => [
				'type' => 'text',
				'label-message' => 'protectsite-timeout',
				'tabindex' => 1,
				'required' => false,
				'default' => $this->prot['timeout'] ?? $wgProtectSiteDefaultTimeout,
				'help' => ( isset( $wgProtectSiteLimit ) ?
					' (' . $this->msg( 'protectsite-maxtimeout', $wgProtectSiteLimit )->parse() . ')' : ''
				),
				'disabled' => $isProtected
			],
			'comment' => [
				'type' => 'text',
				'label-message' => $isProtected ? 'protectsite-ucomment' : 'protectsite-comment',
				'tabindex' => 1,
				'required' => false,
				'default' => $this->prot['comment'] ?? ''
			]
		];
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

		$persist_data = ObjectCache::getInstance( CACHE_DB );

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

	/**
	 * Handles the form submission when we are unprotecting the site
	 * @param array $data
	 * @return void
	 */
	public function handleUnprotectSubmit( array $data ) {
		/* Remove the data from the database to disable extension. */
		$this->persist_data->delete( 'protectsite' );
		$this->wanCache->delete( $this->wanCache->makeKey( 'protectsite' ) );

		/* Create a log entry */
		$logEntry = new ManualLogEntry( 'protect', 'unprotect' );
		$logEntry->setPerformer( $this->getUser() );
		$logEntry->setTarget( SpecialPage::getTitleFor( 'Allpages' ) );
		$logEntry->setComment( $data['comment'] );
		$logEntry->publish( $logEntry->insert() );

		/* Call the Protect Form function to display the current state. */
		$this->getOutput()->redirect( SpecialPage::getTitleFor( 'ProtectSite' )->getFullURL() );
	}

	/**
	 * Handles the form submission when we are protecting the site
	 * @param array $data
	 * @return void
	 */
	public function handleProtectSubmit( array $data ) {
		global $wgProtectSiteLimit;

		$curr_time = time();
		$until = strtotime( '+' . $data['timeout'], $curr_time );
		if ( $until === false || $until < $curr_time ) {
			$this->getOutput()->addWikiMsg( 'protectsite-timeout-error' );
		} else {
			/* Set the array values */
			$prot['createaccount'] = $data['createaccount'];
			$prot['createpage'] = $data['createpage'];
			$prot['edit'] = $data['edit'];
			$prot['move'] = $data['move'];
			$prot['upload'] = $data['upload'];
			$prot['comment'] = isset( $data['comment'] ) ? $data['comment'] : '';

			if (
				isset( $wgProtectSiteLimit ) &&
				( $until > strtotime( '+' . $wgProtectSiteLimit, $curr_time ) )
			) {
				$data['timeout'] = $wgProtectSiteLimit;
			}

			/* Set the limits */
			$prot['until'] = strtotime( '+' . $data['timeout'], $curr_time );
			$prot['timeout'] = $data['timeout'];

			/* Write the array out to the database */
			$this->persist_data->set( 'protectsite', $prot, $prot['until'] );
			$this->wanCache->set(
				$this->wanCache->makeKey( 'protectsite' ), $prot, $prot['until'] );

			/* Create a log entry */
			$logEntry = new ManualLogEntry( 'protect', 'protect' );
			$logEntry->setPerformer( $this->getUser() );
			$logEntry->setTarget( SpecialPage::getTitleFor( 'Allpages' ) );
			$logEntry->setComment(
				$prot['timeout'] . ( strlen( $prot['comment'] ) > 0 ? '; ' . $prot['comment'] : '' )
			);
			$logEntry->setParameters( [ '4::description' => '' ] );
			$logEntry->publish( $logEntry->insert() );

			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'ProtectSite' )->getFullURL() );
		}
	}

	/**
	 * Form submission handler method.
	 *
	 * @param array $data
	 */
	public function onSubmit( array $data ) {
		if ( is_array( $this->prot ) ) {
			$this->handleUnprotectSubmit( $data );
		} else {
			$this->handleProtectSubmit( $data );
		}
	}
}
