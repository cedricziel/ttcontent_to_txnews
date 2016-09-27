<?php

namespace CedricZiel\TtcontentToTxnews\Service;

/**
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

use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContextMenuOptions
{
    /**
     * Adds a sample item to the CSM
     *
     * @param \TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject Back-reference to the calling object
     * @param array $menuItems                                     Current list of menu items
     * @param string $table                                        Name of the table the clicked on item belongs to
     * @param int $uid                                         Id of the clicked on item
     *
     * @return array Modified list of menu items
     */
    public function main(\TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject, $menuItems, $table, $uid)
    {

        // Only activate for tt_content
        if ('tt_content' === $table) {
            $baseUrl = \TYPO3\CMS\Backend\Utility\BackendUtility::getModuleUrl(
                'web_TtcontentToTxnewsTtconv',
                [
                    'tx_ttcontenttotxnews_web_examplesexamples[action]' => 'convert',
                    'tx_ttcontenttotxnews_web_examplesexamples[controller]' => 'TtContent',
                    'tx_ttcontenttotxnews_web_examplesexamples[ce]' => $uid,
                    'id' => GeneralUtility::_GP('id')
                ]
            );

            // Add new menu item with the following parameters:
            // 1) Label
            // 2) Icon
            // 3) URL
            // 4) = 1 disable item in docheader
            $menuItems[] = $parentObject->linkItem(
                $GLOBALS['LANG']->sL('LLL:EXT:ttcontent_to_txnews/Resources/Private/Language/locallang.xlf:be.csm.convertbutton'),
                IconUtility::getSpriteIcon('actions-system-refresh'),
                $parentObject->urlRefForCM($baseUrl),
                1
            );
        }

        return $menuItems;
    }
}
