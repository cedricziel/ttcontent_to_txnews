<?php
namespace CedricZiel\TtcontentToTxnews\Service;

use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Cedric Ziel <cedric@cedric-ziel.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the text file GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
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
