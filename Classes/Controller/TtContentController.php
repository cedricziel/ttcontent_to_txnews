<?php
namespace CedricZiel\TtcontentToTxnews\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Cedric Ziel <cedric@cedric-ziel.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use CedricZiel\TtcontentToTxnews\Domain\Model\TtContent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * TtContentController
 */
class TtContentController extends ActionController {

	/**
	 * @var \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository
	 * @inject
	 */
	protected $ttContentRepository;

	/**
	 * PID the converter should operate on
	 *
	 * @var int
	 */
	protected $pidOfOperation;

	/**
	 * @param \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository $ttContentRepository
	 */
	public function injectTtContentRepository(\CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository $ttContentRepository) {

		$this->ttContentRepository = $ttContentRepository;
	}

	/**
	 * Pulls in the PID
	 */
	public function initializeAction() {

		$this->pidOfOperation = GeneralUtility::_GP('id');
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		$ttContents = $this->ttContentRepository->findByPid($this->pidOfOperation);
		$this->view->assignMultiple(array(
			'ttContents' => $ttContents,
			'pid' => $this->pidOfOperation
		));
	}

	/**
	 * @param TtContent $ce
	 */
	public function convertAction(TtContent $ce) {

		DebuggerUtility::var_dump($this->settings);
		//$this->redirect('list');
	}

}