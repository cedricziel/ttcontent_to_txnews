<?php
namespace CedricZiel\TtcontentToTxnews\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Cedric Ziel <cedric@cedric-ziel.com>
 *  			
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
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class CedricZiel\TtcontentToTxnews\Controller\TtContentController.
 *
 * @author Cedric Ziel <cedric@cedric-ziel.com>
 */
class TtContentControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \CedricZiel\TtcontentToTxnews\Controller\TtContentController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('CedricZiel\\TtcontentToTxnews\\Controller\\TtContentController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllTtContentsFromRepositoryAndAssignsThemToView() {

		$allTtContents = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$ttContentRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$ttContentRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTtContents));
		$this->inject($this->subject, 'ttContentRepository', $ttContentRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('ttContents', $allTtContents);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}
}
