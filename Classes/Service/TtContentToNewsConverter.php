<?php

namespace CedricZiel\TtcontentToTxnews\Service;

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
use GeorgRinger\News\Domain\Model\FileReference as NewsFileReference;
use GeorgRinger\News\Domain\Model\News;
use GeorgRinger\News\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class TtContentToNewsConverter
{
    /**
     * @var \GeorgRinger\News\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @param \GeorgRinger\News\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param TtContent $ce
     * @param array     $settings
     *
     * @return News
     */
    public function convertSingleEntity(TtContent $ce, $settings = [])
    {
        $newsRecord = new News();
        $newsRecord->setPid((int) $settings['targetPid']);

        if (null !== $settings['targetCategoryUid']) {
            $categoryQuery = $this->categoryRepository->createQuery();
            $categoriesFromDb = $categoryQuery->matching(
                $categoryQuery->in(
                    'uid',
                    explode(',', $settings['targetCategoryUid'])
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
                /** @var NewsFileReference $image */
                $newRef = new NewsFileReference();
                $newRef->setFileUid($image->getOriginalResource()->getUid());
                $newRef->setAlternative($image->getOriginalResource()->getAlternative());
                $newRef->setDescription($image->getOriginalResource()->getDescription());
                $newRef->setLink($image->getOriginalResource()->getLink());
                $newRef->setTitle($image->getOriginalResource()->getTitle());

                $newsRecord->addFalMedia($newRef);
            }
        }

        if (null !== $ce->getAssets()) {
            foreach ($ce->getAssets() as $image) {
                /** @var NewsFileReference $image */
                $newRef = new NewsFileReference();
                $newRef->setFileUid($image->getOriginalResource()->getUid());
                $newRef->setAlternative($image->getOriginalResource()->getAlternative());
                $newRef->setDescription($image->getOriginalResource()->getDescription());
                $newRef->setLink($image->getOriginalResource()->getLink());
                $newRef->setTitle($image->getOriginalResource()->getTitle());

                $newsRecord->addFalMedia($newRef);
            }
        }

        return $newsRecord;
    }
}
