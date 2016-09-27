<?php

namespace CedricZiel\TtcontentToTxnews\Tests\Unit\Domain\Model;

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
use TYPO3\CMS\Core\Tests\UnitTestCase;

class TtContentTest extends UnitTestCase
{
    /**
     * @var TtContent
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new TtContent();
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        $this->markTestIncomplete();
    }
}
