<?php
/**
*
* contribution_style [English]
*
* @package Titania
* @version $Id$
* @copyright (c) 2008 phpBB Customisation Database Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_TITANIA'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'CONTRIB_AUTHOR'		=> 'Style Author',
	'CONTRIB_DESCRIPTION'	=> 'Style Description',
	'CONTRIB_DETAILS'		=> 'Style Details',
	'CONTRIB_FAQ'			=> 'Style FAQ',
	'CONTRIB_NAME'			=> 'Style',
	'CONTRIB_STATISTICS'	=> 'Style Statistics',
	'CONTRIB_SUPPORT'		=> 'Style Support',
	'CONTRIB_TITLE'			=> 'Style Title',

	'ERROR_CONTRIB_NOT_FOUND'	=> 'The style you requested could not be found.',
));
