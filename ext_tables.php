<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CedricZiel.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'tools'
		'ttconv',	// Submodule key
		'',						// Position
		array(
			'TtContent' => 'list',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_ttconv.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'tt_content to tx_news converter');

if (!isset($GLOBALS['TCA']['tt_content']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['tt_content']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['tt_content']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['tt_content']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$GLOBALS['TCA']['tt_content']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:ttcontent_to_txnews/Resources/Private/Language/locallang_db.xlf:tx_ttcontenttotxnews.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(),
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);
}

$GLOBALS['TCA']['tt_content']['types']['Tx_TtcontentToTxnews_TtContent']['showitem'] = $TCA['tt_content']['types']['1']['showitem'];
$GLOBALS['TCA']['tt_content']['types']['Tx_TtcontentToTxnews_TtContent']['showitem'] .= ',--div--;LLL:EXT:ttcontent_to_txnews/Resources/Private/Language/locallang_db.xlf:tx_ttcontenttotxnews_domain_model_ttcontent,';
$GLOBALS['TCA']['tt_content']['types']['Tx_TtcontentToTxnews_TtContent']['showitem'] .= '';

$GLOBALS['TCA']['tt_content']['columns'][$TCA['tt_content']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ttcontent_to_txnews/Resources/Private/Language/locallang_db.xlf:tt_content.tx_extbase_type.Tx_TtcontentToTxnews_TtContent','Tx_TtcontentToTxnews_TtContent');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', $GLOBALS['TCA']['tt_content']['ctrl']['type'],'','after:' . $TCA['tt_content']['ctrl']['label']);
