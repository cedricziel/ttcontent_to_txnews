<?php

namespace CedricZiel\TtcontentToTxnews\Domain\Repository;

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

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Entity-repository for tt_content rows
 */
class TtContentRepository extends Repository
{
    /**
     * @param int $pidOfOperation

     *
*@return array|QueryResultInterface
     */
    public function findByPid($pidOfOperation)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->matching(
            $query->equals('pid', $pidOfOperation)
        )->execute();
    }
}
