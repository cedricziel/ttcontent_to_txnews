<?php

namespace CedricZiel\TtcontentToTxnews\Controller;

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

use CedricZiel\TtcontentToTxnews\Domain\Model\TtContent;
use CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository;
use GeorgRinger\News\Domain\Model\FileReference as NewsFileReference;
use GeorgRinger\News\Domain\Model\News;
use GeorgRinger\News\Domain\Repository\CategoryRepository;
use GeorgRinger\News\Domain\Repository\FileRepository;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class TtContentController extends ActionController
{
    /**
     * @var \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository
     * @inject
     */
    protected $ttContentRepository;

    /**
     * @var \GeorgRinger\News\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @var \GeorgRinger\News\Domain\Repository\NewsRepository
     * @inject
     */
    protected $newsRepository;

    /**
     * @var \GeorgRinger\News\Domain\Repository\FileRepository
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
     * @param \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository $ttContentRepository
     */
    public function injectTtContentRepository(TtContentRepository $ttContentRepository)
    {
        $this->ttContentRepository = $ttContentRepository;
    }

    /**
     * @param \GeorgRinger\News\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param \GeorgRinger\News\Domain\Repository\NewsRepository $newsRepository
     */
    public function injectNewsRepository(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param \GeorgRinger\News\Domain\Repository\FileRepository $fileRepo
     */
    public function injectFileRepository(FileRepository $fileRepo)
    {
        $this->fileRepository = $fileRepo;
    }

    /**
     * Pulls in the PID
     */
    public function initializeAction()
    {
        $this->pidOfOperation = GeneralUtility::_GP('id');
    }

    /**
     * @return void
     */
    public function listAction()
    {
        $ttContents = $this->ttContentRepository->findByPid((int) $this->pidOfOperation);
        $this->view->assignMultiple(
            [
                'ttContents' => $ttContents,
                'pid'        => $this->pidOfOperation,
            ]
        );
    }

    /**
     * @param TtContent $ce
     */
    public function convertAction(TtContent $ce)
    {
        $newsRecord = new News();
        $newsRecord->setPid((int) $this->settings['targetPid']);

        if (null !== $this->settings['targetCategoryUid']) {
            $categoryQuery = $this->categoryRepository->createQuery();
            $categoriesFromDb = $categoryQuery->matching(
                $categoryQuery->in(
                    'uid',
                    explode(',', $this->settings['targetCategoryUid'])
                )
            )->execute();

            if (null !== $categoriesFromDb) {
                $categories = new ObjectStorage();
                foreach ($categoriesFromDb as $categoryFromDb) {
                    $categories->attach($categoryFromDb);
                }
                $newsRecord->setCategories($categories);
            }
        }

        $newsRecord->setTitle('CONVERTED: '.$ce->getHeader());
        $newsRecord->setBodytext($ce->getBodytext());
        $newsRecord->setDatetime($ce->getTstamp());
        $newsRecord->setCrdate($ce->getCrdate());

        if (null !== $ce->getImage()) {
            foreach ($ce->getImage() as $image) {
                /** @var FileReference $image */
                $newRef = new NewsFileReference();
                $newRef->setFileUid($image->getOriginalResource()->getUid());
                $newRef->setAlternative($image->getOriginalResource()->getAlternative());
                $newRef->setDescription($image->getOriginalResource()->getDescription());
                $newRef->setLink($image->getOriginalResource()->getLink());
                $newRef->setTitle($image->getOriginalResource()->getTitle());

                $newsRecord->addFalMedia($newRef);
            }
        }

        $this->newsRepository->add($newsRecord);

        $this->addFlashMessage(
            'Record ' . $newsRecord->getTitle() . ' migrated',
            'Success!',
            FlashMessage::OK
        );

        if (null !== $this->settings['backupPid']) {
            $ce->setPid((int) $this->settings['backupPid']);
            $this->ttContentRepository->update($ce);

            $this->addFlashMessage(
                'Record ' . $ce->getHeader() . ' moved',
                'Success!',
                FlashMessage::INFO
            );
        }

        $this->redirect('list');
    }
}
