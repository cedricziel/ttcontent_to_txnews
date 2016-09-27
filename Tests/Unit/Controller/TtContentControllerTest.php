<?php

namespace CedricZiel\TtcontentToTxnews\Tests\Unit\Controller;

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

use CedricZiel\TtcontentToTxnews\Controller\TtContentController;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class TtContentControllerTest extends UnitTestCase
{
    /**
     * @var TtContentController
     */
    protected $subject = null;

    /**
     * @test
     */
    public function listActionFetchesAllTtContentsFromRepositoryAndAssignsThemToView()
    {
        $allTtContents = $this->getMock(ObjectStorage::class, [], [], '', false);

        $ttContentRepository = $this->getMock('', ['findAll'], [], '', false);
        $ttContentRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTtContents));
        $this->inject($this->subject, 'ttContentRepository', $ttContentRepository);

        $view = $this->getMock(ViewInterface::class);
        $view->expects($this->once())->method('assign')->with('ttContents', $allTtContents);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    protected function setUp()
    {
        $this->subject = $this->getMock(
            TtContentController::class,
            ['redirect', 'forward', 'addFlashMessage'],
            [],
            '',
            false
        );
    }

    protected function tearDown()
    {
        unset($this->subject);
    }
}
