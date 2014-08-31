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
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
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
	 * @var \Tx_News_Domain_Repository_CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;

	/**
	 * @var \Tx_News_Domain_Repository_NewsRepository
	 * @inject
	 */
	protected $newsRepository;

	/**
	 * @var \Tx_News_Domain_Repository_FileRepository
	 * @inject
	 */
	protected $fileRepository;

	/**
	 * PID the converter should operate on
	 *
	 * @var int
	 */
	protected $pidOfOperation;

	/**
	 * @var \TYPO3\CMS\Core\Resource\ResourceFactory
	 */
	protected $resourceFactory;

	/**
	 * @param \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository $ttContentRepository
	 */
	public function injectTtContentRepository(\CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository $ttContentRepository) {

		$this->ttContentRepository = $ttContentRepository;
	}

	/**
	 * @param \Tx_News_Domain_Repository_CategoryRepository $categoryRepository
	 */
	public function injectCategoryRepository(\Tx_News_Domain_Repository_CategoryRepository $categoryRepository) {

		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * @param \Tx_News_Domain_Repository_NewsRepository $newsRepository
	 */
	public function injectNewsRepository(\Tx_News_Domain_Repository_NewsRepository $newsRepository) {

		$this->newsRepository = $newsRepository;
	}

	/**
	 * @param \Tx_News_Domain_Repository_FileRepository $fileRepo
	 */
	public function injectFileRepository(\Tx_News_Domain_Repository_FileRepository $fileRepo) {

		$this->fileRepository = $fileRepo;
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

	public function initializeConvertAction() {

		$this->resourceFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
	}

	/**
	 * @param TtContent $ce
	 */
	public function convertAction(TtContent $ce) {

		/** @var Category $category */
		$category = NULL;
		if (NULL !== $this->settings['targetCategoryUid']) {
			$qResult = $this->categoryRepository->findByUid($this->settings['targetCategoryUid']);
			$category = $qResult;
		}

		$newsRecord = new \Tx_News_Domain_Model_News();
		$newsRecord->setPid($this->settings['targetPid']);
		if (NULL !== $category) {
			$categories = new ObjectStorage();
			$categories->attach($category);
			$newsRecord->setCategories($categories);
		}

		$newsRecord->setTitle($ce->getHeader());
		$newsRecord->setBodytext($ce->getBodytext());
		$newsRecord->setDatetime($ce->getCrdate());

		DebuggerUtility::var_dump($ce->getImage());

		if (NULL !== $ce->getImage()) {

			foreach ($ce->getImage() as $image) {
				/** @var FileReference $image */
				$newRef = new \Tx_News_Domain_Model_FileReference();
				$newRef->setFileUid($image->getOriginalResource()->getUid());

				$newsRecord->addFalMedia($newRef);
			}
		}

		$this->newsRepository->add($newsRecord);

		$this->redirect('list');
		DebuggerUtility::var_dump($ce);
		DebuggerUtility::var_dump($newsRecord);
	}
}