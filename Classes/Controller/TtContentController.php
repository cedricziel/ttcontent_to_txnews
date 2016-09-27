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
use CedricZiel\TtcontentToTxnews\Service\TtContentToNewsConverter;
use GeorgRinger\News\Domain\Repository\CategoryRepository;
use GeorgRinger\News\Domain\Repository\FileRepository;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class TtContentController extends ActionController
{
    /**
     * @var \CedricZiel\TtcontentToTxnews\Domain\Repository\TtContentRepository
     * @inject
     */
    protected $ttContentRepository;

    /**
     * @var \GeorgRinger\News\Domain\Repository\NewsRepository
     * @inject
     */
    protected $newsRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \CedricZiel\TtcontentToTxnews\Service\TtContentToNewsConverter
     * @inject
     */
    protected $ttContentConverter;

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
     * @param \GeorgRinger\News\Domain\Repository\NewsRepository $newsRepository
     */
    public function injectNewsRepository(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager
     */
    public function injectPersistenceManagerRepository(PersistenceManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * @param \CedricZiel\TtcontentToTxnews\Service\TtContentToNewsConverter $converter
     */
    public function injectTtContentConverter(TtContentToNewsConverter $converter)
    {
        $this->ttContentConverter = $converter;
    }

    /**
     * Pulls in the PID
     */
    public function initializeAction()
    {
        $this->pidOfOperation = GeneralUtility::_GP('id');

        $querySettings = $this->ttContentRepository
            ->createQuery()
            ->getQuerySettings();

        $querySettings->setIgnoreEnableFields(true)
            ->setRespectStoragePage(false)
            ->setRespectSysLanguage(false);

        $this->ttContentRepository->setDefaultQuerySettings($querySettings);
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

    public function initializeConvertAction()
    {
        $contentElementUid = $this->request->getArgument('ce');
        $contentElement = $this->ttContentRepository->findOneByUid((int) $contentElementUid);

        $this->request->setArgument('ce', $contentElement);
    }

    /**
     * @param \CedricZiel\TtcontentToTxnews\Domain\Model\TtContent $ce
     */
    public function convertAction(TtContent $ce)
    {
        $newsRecord = $this->ttContentConverter->convertSingleEntity($ce);

        $this->newsRepository->add($newsRecord);

        $this->addFlashMessage(
            'Record ' . $newsRecord->getTitle() . ' migrated',
            'Success!',
            FlashMessage::OK
        );

        $this->persistenceManager->persistAll();

        if (null !== $this->settings['backupPid'] && '' !== $this->settings['backupPid']) {
            $ce->setPid((int) $this->settings['backupPid']);
            $this->ttContentRepository->update($ce);

            $this->persistenceManager->persistAll();

            $this->addFlashMessage(
                'Record ' . $ce->getHeader() . ' moved',
                'Success!',
                FlashMessage::INFO
            );
        }

        $this->redirect('list');
    }
}
