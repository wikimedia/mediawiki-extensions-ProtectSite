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

class ProtectSite extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ProtectSite'/*class*/, 'protectsite'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed|null $par Parameter passed to the page
	 */
	public function execute( $par ) {
		$user = $this->getUser();

		// If the user doesn't have 'protectsite' permission, display an error
		if ( !$user->isAllowed( 'protectsite' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			throw new ReadOnlyError;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $user->isBlocked() ) {
			throw new UserBlockedError( $user->mBlock );
		}

		$this->setHeaders();

		$form = new ProtectSiteForm( $this->getRequest() );
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
		$persist_data = new SqlBagOStuff( array() );

		/* Get data into the prot hash */
		$prot = $wgMemc->get( wfMemcKey( 'protectsite' ) );
		if ( !$prot ) {
			$prot = $persist_data->get( 'protectsite' );
			if ( !$prot ) {
				$wgMemc->set( wfMemcKey( 'protectsite' ), 'disabled' );
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

			$wgGroupPermissions['user']['move'] = !( $prot['move'] == 1 );
			$wgGroupPermissions['user']['upload'] = !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload'] = !( $prot['upload'] == 1 );
			$wgGroupPermissions['user']['reupload-shared'] = !( $prot['upload'] == 1 );

			// are there any groups that should not get affected by ProtectSite's lockdown?
			if ( !empty( $wgProtectSiteExempt ) && is_array( $wgProtectSiteExempt ) ) {
				// there are, so loop over them, and force these rights to be true
				// will resolve any problems from inheriting rights from 'user' or 'sysop'
				foreach ( $wgProtectSiteExempt as $exemptGroup ) {
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

/**
 * Class that handles the actual Special:ProtectSite page
 * This is a modified version of the ancient HTMLForm class.
 * @todo FIXME: could probably be rewritten to use the modern HTMLForm :)
 */
class ProtectSiteForm {
	public $mRequest, $action, $persist_data;

	/* Constructor */
	function __construct( &$request ) {
		global $wgMemc;

		$titleObj = SpecialPage::getTitleFor( 'ProtectSite' );
		$this->action = htmlspecialchars( $titleObj->getLocalURL(), ENT_QUOTES );
		$this->mRequest =& $request;
		$this->persist_data = new SqlBagOStuff( array() );

		/* Get data into the value variable/array */
		$prot = $wgMemc->get( wfMemcKey( 'protectsite' ) );
		if ( !$prot ) {
			$prot = $this->persist_data->get( 'protectsite' );
		}

		/* If this was a GET request */
		if ( !$this->mRequest->wasPosted() ) {
			/* If $value is an array, protection is set, allow unsetting */
			if ( is_array( $prot ) ) {
				$this->unProtectSiteForm( $prot );
			} else {
				/* If $value is not an array, protection is not set */
				$this->setProtectSiteForm();
			}
		} else {
			/* If this was a POST request, process the data sent */
			if ( $this->mRequest->getVal( 'protect' ) ) {
				$this->setProtectSite();
			} else {
				$this->unProtectSite();
			}
		}
	}

	function setProtectSite() {
		global $wgOut, $wgMemc, $wgProtectSiteLimit;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Check to see if the time limit exceeds the limit. */
		$curr_time = time();
		if(
			( ( $until = strtotime( '+' . $request['timeout'], $curr_time ) ) === false ) ||
			( $until < $curr_time )
		) {
			$wgOut->addWikiMsg( 'protectsite-timeout-error' );
			$this->setProtectSiteForm();
		} else {
			/* Set the array values */
			$prot['createaccount'] = $request['createaccount'];
			$prot['createpage'] = $request['createpage'];
			$prot['edit'] = $request['edit'];
			$prot['move'] = $request['move'];
			$prot['upload'] = $request['upload'];
			$prot['comment'] = isset( $request['comment'] ) ? $request['comment'] : '';

			if( isset( $wgProtectSiteLimit ) &&
				( $until > strtotime( '+' . $wgProtectSiteLimit, $curr_time ) )
			) {
				$request['timeout'] = $wgProtectSiteLimit;
			}

			/* Set the limits */
			$prot['until'] = strtotime( '+' . $request['timeout'], $curr_time );
			$prot['timeout'] = $request['timeout'];

			/* Write the array out to the database */
			$this->persist_data->set( 'protectsite', $prot, $prot['until'] );
			$wgMemc->set( wfMemcKey( 'protectsite' ), $prot, $prot['until'] );

			/* Create a log entry */
			$log = new LogPage( 'protect' );
			$log->addEntry(
				'protect',
				SpecialPage::getTitleFor( 'Allpages' ),
				$prot['timeout'] .
				( strlen( $prot['comment'] ) > 0 ? '; ' . $prot['comment'] : '' )
			);

			/* Call the Unprotect Form function to display the current state. */
			$this->unProtectSiteForm( $prot );
		}
	}

	function unProtectSite() {
		global $wgMemc;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Remove the data from the database to disable extension. */
		$this->persist_data->delete( 'protectsite' );
		$wgMemc->delete( wfMemcKey( 'protectsite' ) );

		/* Create a log entry */
		$log = new LogPage( 'protect' );
		$log->addEntry(
			'unprotect',
			SpecialPage::getTitleFor( 'Allpages' ),
			$request['ucomment']
		);

		/* Call the Protect Form function to display the current state. */
		$this->setProtectSiteForm();
	}

	/**
	 * @param string $name Name of the fieldset.
	 * @param string $content HTML content to put in.
	 * @return string HTML fieldset
	 */
	private function fieldset( $name, $content ) {
		// Give grep a chance to find the usages:
		// protectsite-title, protectsite-createaccount, protectsite-createpage,
		// protectsite-edit, protectsite-move, protectsite-upload
		return '<fieldset><legend>' . wfMessage( 'protectsite-' . $name )->text() .
			"</legend>\n" . $content . "\n</fieldset>\n";
	}

	/**
	 * Override the broken function in the HTMLForm class
	 * This was fixed in r16320 of the MW source; WM bugzilla bug #7188.
	 */
	private function radiobox( $varname, $fields ) {
		// Give grep a chance to find the usages:
		// protectsite-createaccount-0, protectsite-createaccount-1, protectsite-createaccount-2,
		// protectsite-createpage-0, protectsite-createpage-1, protectsite-createpage-2,
		// protectsite-edit-0, protectsite-edit-1, protectsite-edit-2,
		// protectsite-move-0, protectsite-move-1,
		// protectsite-upload-0, protectsite-upload-1
		$s = '';
		foreach ( $fields as $value => $checked ) {
			$s .= "<div><label><input type=\"radio\" name=\"{$varname}\" value=\"{$value}\"" . ( $checked ? ' checked="checked"' : '' ) . ' />'
			. wfMessage( 'protectsite-' . $varname . '-' . $value )->text() .
			"</label></div>\n";
		}

		return $this->fieldset( $varname, $s );
	}

	/**
	 * Overridden textbox method, allowing for the inclusion of something
	 * after the text box itself.
	 */
	private function textbox( $varname, $value = '', $append = '' ) {
		if ( $this->mRequest->wasPosted() ) {
			$value = $this->mRequest->getText( $varname, $value );
		}

		// Give grep a chance to find the usages:
		// protectsite-timeout, protectsite-comment, protectsite-ucomment
		$value = htmlspecialchars( $value, ENT_QUOTES );
		return '<div><label>' . wfMessage( 'protectsite-' . $varname )->text() .
				"<input type=\"text\" name=\"{$varname}\" value=\"{$value}\" /> " .
				$append .
				"</label></div>\n";
	}

	/* This function outputs the field status. */
	private function showField( $name, $state ) {
		// Give grep a chance to find the usages:
		//   protectsite-createaccount, protectsite-createpage, protectsite-edit,
		//   protectsite-move, protectsite-upload
		// Give grep a chance to find the usages:
		//   protectsite-createaccount-0, protectsite-createaccount-1, protectsite-createaccount-2,
		//   protectsite-createpage-0, protectsite-createpage-1, protectsite-createpage-2,
		//   protectsite-edit-0, protectsite-edit-1, protectsite-edit-2,
		//   protectsite-move-0, protectsite-move-1,
		//   protectsite-upload-0, protectsite-upload-1
		return '<b>' . wfMessage( 'protectsite-' . $name )->text() . ' - <i>' .
					'<span style="color: ' . ( ( $state > 0 ) ? 'red' : 'green' ) . '">' .
					wfMessage( 'protectsite-' . $name . '-' . $state )->text() . '</span>' .
					"</i></b><br />\n";
	}

	function unProtectsiteForm( $prot ) {
		global $wgOut, $wgLang;

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-unprotect' );
		$wgOut->addHTML(
			'<form name="unProtectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset( 'title',
					$this->showField( 'createaccount', $prot['createaccount'] ) .
					$this->showField( 'createpage', $prot['createpage'] ) .
					$this->showField( 'edit', $prot['edit'] ) .
					$this->showField( 'move', $prot['move'] ) .
					$this->showField( 'upload', $prot['upload'] ) .
					'<b>' . wfMessage( 'protectsite-timeout' )->text() . ' </b> ' .
					'<i>' . $wgLang->timeAndDate( wfTimestamp( TS_MW, $prot['until'] ), true ) . '</i>' .
					'<br />' .
					( $prot['comment'] != '' ?
					'<b>' . wfMessage( 'protectsite-comment' )->text() . ' </b> ' .
					'<i>' . $prot['comment'] . '</i>' .
					'<br />' : '' ) .
					"<br />\n" .
					$this->textbox( 'ucomment' ) .
					'<br />' .
					Xml::element( 'input', array(
						'type'	=> 'submit',
						'name'	=> 'unprotect',
						'value' => wfMessage( 'protectsite-unprotect' )->text() )
					)
				) .
			'</form>'
		);
	}

	function setProtectSiteForm() {
		global $wgOut, $wgProtectSiteDefaultTimeout, $wgProtectSiteLimit;

		$request = $this->mRequest->getValues();
		$createaccount = array( 0 => false, 1 => false, 2 => false );
		$createaccount[(isset( $request['createaccount'] ) ? $request['createaccount'] : 0)] = true;
		$createpage = array( 0 => false, 1 => false, 2 => false );
		$createpage[(isset( $request['createpage'] ) ? $request['createpage'] : 0)] = true;
		$edit = array( 0 => false, 1 => false, 2 => false );
		$edit[(isset( $request['edit'] ) ? $request['edit'] : 0)] = true;
		$move = array( 0 => false, 1 => false );
		$move[(isset( $request['move'] ) ? $request['move'] : 0)] = true;
		$upload = array( 0 => false, 1 => false );
		$upload[(isset( $request['upload'] ) ? $request['upload'] : 0)] = true;

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-protect' );
		$wgOut->addHTML(
			'<form name="Protectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset( 'title',
					$this->radiobox( 'createaccount', $createaccount ) .
					$this->radiobox( 'createpage', $createpage ) .
					$this->radiobox( 'edit', $edit ) .
					$this->radiobox( 'move', $move ) .
					$this->radiobox( 'upload', $upload ) .
					$this->textbox( 'timeout', $wgProtectSiteDefaultTimeout,
					( isset( $wgProtectSiteLimit ) ?
						' (' . wfMessage( 'protectsite-maxtimeout', $wgProtectSiteLimit )->text() . ')' :
						''
					)) .
					"\n<br />" .
					$this->textbox( 'comment', isset( $request['comment'] ) ? $request['comment'] : '' ) .
					"\n<br />" .
					Xml::element( 'input', array(
						'type'	=> 'submit',
						'name'	=> 'protect',
						'value' => wfMessage( 'protectsite-protect' )->text() )
					)
				) .
			'</form>'
		);
	}
}
