<?php
/**
*
* @package Titania
* @version $Id$
* @copyright (c) 2008 phpBB Customisation Database Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_TITANIA'))
{
	exit;
}

function titania_custom($action, $version)
{
	switch ($action)
	{
		case 'install' :
			switch ($version)
			{
				case '0.1.40' :
					titania_tags();
					titania_categories();
				break;
			}
		break;

		case 'update' :
			switch ($version)
			{
				case '0.1.34' :
					$sync = new titania_sync;
					$sync->topics('post_count');
				break;

				case '0.1.37' :
					$sync = new titania_sync;
					$sync->queue('revision_queue_id');
				break;

				case '0.1.47' :
					$sync = new titania_sync;
					$sync->topics('queue_discussion_category');
				break;

				case '0.1.49' :
					$sql = 'UPDATE ' . TITANIA_TOPICS_TABLE . ' SET topic_sticky = 1
						WHERE topic_type = ' . TITANIA_QUEUE_DISCUSSION;
					phpbb::$db->sql_query($sql);
				break;

				case '0.1.53' :
					$sql_ary = array();
					$sql = 'SELECT contrib_id, revision_id, phpbb_version FROM ' . TITANIA_REVISIONS_TABLE;
					$result = phpbb::$db->sql_query($sql);
					while ($row = phpbb::$db->sql_fetchrow($result))
					{
						$sql_ary[] = array(
							'revision_id'				=> $row['revision_id'],
							'contrib_id'				=> $row['contrib_id'],
							'phpbb_version_branch'		=> $row['phpbb_version'][0] . $row['phpbb_version'][2],
							'phpbb_version_revision'	=> substr($row['phpbb_version'], 4),
						);
					}
					phpbb::$db->sql_freeresult($result);

					phpbb::$db->sql_multi_insert(TITANIA_REVISIONS_PHPBB_TABLE, $sql_ary);
				break;
			}
		break;

		case 'uninstall' :
			// Uninstall the types (prevent errors)
			foreach (titania_types::$types as $class)
			{
				$class->uninstall();
			}

			titania_search::truncate();
		break;
	}

	titania_ext_groups($action);
}

function titania_tags()
{
	global $umil;

	// Empty the tag tables first
	$sql = 'DELETE FROM ' . TITANIA_TAG_TYPES_TABLE;
	phpbb::$db->sql_query($sql);
	$sql = 'DELETE FROM ' . TITANIA_TAG_FIELDS_TABLE;
	phpbb::$db->sql_query($sql);

	$tag_types = array(
		array(
			'tag_type_id'	=> TITANIA_QUEUE,
			'tag_type_name'	=> 'QUEUE_TAGS',
		)
	);

	$umil->table_row_insert(TITANIA_TAG_TYPES_TABLE, $tag_types);

	$tags = array(
		array(
			'tag_id'			=> 1,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_NEW',
			'tag_clean_name'	=> 'new',
			'no_delete'			=> true,
		),
		// Leave space for others if we need to hard-code any
		array(
			'tag_id'			=> 15,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_ATTENTION',
			'tag_clean_name'	=> 'attention',
			'no_delete'			=> false,
		),
		array(
			'tag_id'			=> 16,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_REPACK',
			'tag_clean_name'	=> 'repack',
			'no_delete'			=> false,
		),
		array(
			'tag_id'			=> 17,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_VALIDATING',
			'tag_clean_name'	=> 'validating',
			'no_delete'			=> false,
		),
		array(
			'tag_id'			=> 18,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_TESTING',
			'tag_clean_name'	=> 'testing',
			'no_delete'			=> false,
		),
		array(
			'tag_id'			=> 19,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_APPROVE',
			'tag_clean_name'	=> 'approve',
			'no_delete'			=> false,
		),
		array(
			'tag_id'			=> 20,
			'tag_type_id'		=> TITANIA_QUEUE,
			'tag_field_name'	=> 'QUEUE_DENY',
			'tag_clean_name'	=> 'deny',
			'no_delete'			=> false,
		),
	);

	$umil->table_row_insert(TITANIA_TAG_FIELDS_TABLE, $tags);
}

function titania_categories()
{
	global $umil;

	$categories = array(
		array(
			'category_id'	=> 1,
			'parent_id'		=> 0,
			'left_id'		=> 1,
			'right_id'		=> 20,
			'category_type'	=> 0,
			'category_name'	=> 'CAT_MODIFICATIONS',
			'category_name_clean'	=> 'modifications',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 2,
			'parent_id'		=> 0,
			'left_id'		=> 21,
			'right_id'		=> 32,
			'category_type'	=> 0,
			'category_name'	=> 'CAT_STYLES',
			'category_name_clean'	=> 'styles',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 3,
			'parent_id'		=> 1,
			'left_id'		=> 2,
			'right_id'		=> 3,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_COSMETIC',
			'category_name_clean'	=> 'cosmetic',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 4,
			'parent_id'		=> 1,
			'left_id'		=> 4,
			'right_id'		=> 5,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_TOOLS',
			'category_name_clean'	=> 'tools',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 5,
			'parent_id'		=> 1,
			'left_id'		=> 6,
			'right_id'		=> 7,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_SECURITY',
			'category_name_clean'	=> 'security',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 6,
			'parent_id'		=> 1,
			'left_id'		=> 8,
			'right_id'		=> 9,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_COMMUNICATION',
			'category_name_clean'	=> 'communication',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 7,
			'parent_id'		=> 1,
			'left_id'		=> 10,
			'right_id'		=> 11,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_PROFILE_UCP',
			'category_name_clean'	=> 'profile',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 8,
			'parent_id'		=> 1,
			'left_id'		=> 12,
			'right_id'		=> 13,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_ADDONS',
			'category_name_clean'	=> 'addons',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 9,
			'parent_id'		=> 1,
			'left_id'		=> 14,
			'right_id'		=> 15,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_ANTI_SPAM',
			'category_name_clean'	=> 'anti-spam',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 10,
			'parent_id'		=> 1,
			'left_id'		=> 16,
			'right_id'		=> 17,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_ENTERTAINMENT',
			'category_name_clean'	=> 'entertainment',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 11,
			'parent_id'		=> 1,
			'left_id'		=> 18,
			'right_id'		=> 19,
			'category_type'	=> 1,
			'category_name'	=> 'CAT_MISC',
			'category_name_clean'	=> 'misc',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 12,
			'parent_id'		=> 2,
			'left_id'		=> 22,
			'right_id'		=> 23,
			'category_type'	=> 2,
			'category_name'	=> 'CAT_BOARD_STYLES',
			'category_name_clean'	=> 'board_styles',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 13,
			'parent_id'		=> 2,
			'left_id'		=> 24,
			'right_id'		=> 25,
			'category_type'	=> 2,
			'category_name'	=> 'CAT_SMILIES',
			'category_name_clean'	=> 'smilies',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 14,
			'parent_id'		=> 2,
			'left_id'		=> 26,
			'right_id'		=> 27,
			'category_type'	=> 2,
			'category_name'	=> 'CAT_AVATARS',
			'category_name_clean'	=> 'avatars',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 15,
			'parent_id'		=> 2,
			'left_id'		=> 28,
			'right_id'		=> 29,
			'category_type'	=> 2,
			'category_name'	=> 'CAT_RANKS',
			'category_name_clean'	=> 'ranks',
			'category_desc'			=> '',
		),
		array(
			'category_id'	=> 16,
			'parent_id'		=> 2,
			'left_id'		=> 30,
			'right_id'		=> 31,
			'category_type'	=> 2,
			'category_name'	=> 'CAT_MISC',
			'category_name_clean'	=> 'misc',
			'category_desc'			=> '',
		),
	);

	$umil->table_row_insert(TITANIA_CATEGORIES_TABLE, $categories);
}

function titania_ext_groups($action)
{
	$ext_groups = array(
		TITANIA_ATTACH_EXT_CONTRIB		=> array('default_set' => array('zip'), 'sql' => array('upload_icon' => 'zip.png')),
		TITANIA_ATTACH_EXT_SCREENSHOTS	=> array('default' => 'Images'),
		TITANIA_ATTACH_EXT_SUPPORT		=> array('default' => array('Archives', 'Images')),
		TITANIA_ATTACH_EXT_FAQ			=> array('default' => array('Archives', 'Images')),
	);

	switch ($action)
	{
		case 'update' :
			titania_ext_groups('uninstall');
			titania_ext_groups('install');
		break;

		case 'install' :
			// Add Titania ext groups.
			foreach ($ext_groups as $group_name => $extra)
			{
				$sql_ary = array(
					'group_name'		=> $group_name,
					'cat_id'			=> 0,
					'allow_group'		=> 0,
					'download_mode'		=> 1,
					'upload_icon'		=> '',
					'max_filesize'		=> 0,
					'allowed_forums'	=> '',
					'allow_in_pm'		=> 0,
				);
				if (isset($extra['sql']))
				{
					$sql_ary = array_merge($sql_ary, $extra['sql']);
				}

				phpbb::$db->sql_query('INSERT INTO ' . EXTENSION_GROUPS_TABLE . ' ' . phpbb::$db->sql_build_array('INSERT', $sql_ary));
				$group_id = phpbb::$db->sql_nextid();

				if (isset($extra['default']))
				{
					$sql_ary = array(
						'SELECT'	=> 'e.extension',

						'FROM'		=> array(EXTENSION_GROUPS_TABLE 	=> 'g'),

						'LEFT_JOIN'	=> array(
							array(
								'FROM'	=> array(EXTENSIONS_TABLE 		=> 'e'),
								'ON'	=> 'e.group_id = g.group_id'
							),
						),

						'WHERE'		=> ((is_array($extra['default'])) ? phpbb::$db->sql_in_set('g.group_name', $extra['default']) : "g.group_name = '{$extra['default']}'"),
					);
					$sql = phpbb::$db->sql_build_query('SELECT', $sql_ary);
					$result = phpbb::$db->sql_query($sql);

					$sql_ary = array();

					while ($row = phpbb::$db->sql_fetchrow($result))
					{
						$sql_ary[] = array(
							'group_id'		=> $group_id,
							'extension'		=> $row['extension'],
						);
					}

					phpbb::$db->sql_freeresult($result);

					phpbb::$db->sql_multi_insert(EXTENSIONS_TABLE, $sql_ary);
				}
				else if (isset($extra['default_set']))
				{
					$sql_ary = array();
					foreach ($extra['default_set'] as $extension)
					{
						$sql_ary[] = array(
							'group_id'		=> $group_id,
							'extension'		=> $extension,
						);
					}
					phpbb::$db->sql_multi_insert(EXTENSIONS_TABLE, $sql_ary);
				}
			}
		break;

		case 'uninstall':
			// Get group ids Titania ext groups.
			$sql = 'SELECT group_id
				FROM ' . EXTENSION_GROUPS_TABLE . '
				WHERE ' . phpbb::$db->sql_in_set('group_name', array_keys($ext_groups));
			$result = phpbb::$db->sql_query($sql);

			while ($row = phpbb::$db->sql_fetchrow($result))
			{
				$sql = 'DELETE FROM ' . EXTENSIONS_TABLE . '
					WHERE group_id = ' . $row['group_id'];
				phpbb::$db->sql_query($sql);
			}
			phpbb::$db->sql_freeresult($result);

			$sql = 'DELETE FROM ' . EXTENSION_GROUPS_TABLE . '
				WHERE ' . phpbb::$db->sql_in_set('group_name', array_keys($ext_groups));
			phpbb::$db->sql_query($sql);
		break;
	}

	phpbb::$cache->destroy('_titania_extensions');
}
