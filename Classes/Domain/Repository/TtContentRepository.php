<?php
namespace CedricZiel\TtcontentToTxnews\Domain\Repository;

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
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: cziel
 * Date: 31.08.14
 * Time: 19:35
 */
class TtContentRepository extends Repository {

	/**
	 * @param int $pidOfOperation
	 *
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByPid($pidOfOperation) {

		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		return $query->matching(
			$query->equals('pid', $pidOfOperation)
		)->execute();
	}
}