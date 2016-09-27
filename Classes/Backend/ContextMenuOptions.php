<?php

namespace CedricZiel\TtcontentToTxnews\Backend;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\ClickMenu\ClickMenu;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Adds relevant items to conversion
 */
class ContextMenuOptions
{
    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * Initialize
     */
    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    /**
     * Main function, adding the item to input menuItems array
     *
     * @param ClickMenu $backRef   References to parent clickmenu objects.
     * @param array     $menuItems Array of existing menu items accumulated. New element added to this.
     * @param string    $table     Table name of the element
     * @param int       $uid       Record UID of the element
     *
     * @return array Modified menuItems array
     */
    public function main(&$backRef, $menuItems, $table, $uid)
    {
        $localItems = [];

        /*
         * Add 'convert tt-content row to tx-news' item
         */
        if ($table === 'tt_content') {
            $LL = $this->includeLL();

            $url = BackendUtility::getModuleUrl(
                'web_TtcontentToTxnewsTtconv',
                [
                    'tx_ttcontenttotxnews_web_examplesexamples[action]'     => 'convert',
                    'tx_ttcontenttotxnews_web_examplesexamples[controller]' => 'TtContent',
                    'tx_ttcontenttotxnews_web_examplesexamples[ce]'         => $uid,
                    'id'                                                    => GeneralUtility::_GP('id'),
                ]
            );

            $localItems[] = $backRef->linkItem(
                $GLOBALS['LANG']->getLLL('be.csm.convertbutton', $LL),
                $backRef->excludeIcon(
                    $this->iconFactory->getIcon('actions-system-cache-clear-impact-high', Icon::SIZE_SMALL)->render()
                ),
                $backRef->urlRefForCM($url),
                true
            );

            $menuItems = array_merge($menuItems, $localItems);
        }

        return $menuItems;
    }

    /**
     * Includes the [extDir]/locallang.xlf and returns the translations found in that file.
     *
     * @return array Local lang array
     */
    public function includeLL()
    {
        return $GLOBALS['LANG']->includeLLFile(
            'EXT:ttcontent_to_txnews/Resources/Private/Language/locallang.xlf',
            false
        );
    }
}
