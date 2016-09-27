<?php

namespace CedricZiel\TtcontentToTxnews\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Model for a tt_content row
 */
class TtContent extends AbstractEntity
{

    /**
     * @var int $crdate
     */
    protected $crdate;

    /**
     * @var \DateTime $tstamp
     */
    protected $tstamp;

    /**
     * @var string
     */
    protected $CType;

    /**
     * @var string
     */
    protected $header;

    /**
     * @var string
     */
    protected $headerPosition;

    /**
     * @var string
     */
    protected $bodytext;

    /**
     * @var int
     */
    protected $colPos;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $image;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $assets;

    /**
     * @var int
     */
    protected $imagewidth;

    /**
     * @var int
     */
    protected $imageorient;

    /**
     * @var string
     */
    protected $imagecaption;

    /**
     * @var int
     */
    protected $imagecols;

    /**
     * @var int
     */
    protected $imageborder;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $media;

    /**
     * @var string
     */
    protected $layout;

    /**
     * @var int
     */
    protected $cols;

    /**
     * @var string
     */
    protected $subheader;

    /**
     * @var string
     */
    protected $headerLink;

    /**
     * @var string
     */
    protected $imageLink;

    /**
     * @var string
     */
    protected $imageZoom;

    /**
     * @var string
     */
    protected $altText;

    /**
     * @var string
     */
    protected $titleText;

    /**
     * @var string
     */
    protected $headerLayout;

    /**
     * @var string
     */
    protected $listType;

    /**
     * @var int
     */
    protected $pid;

    /**
     * @var int
     */
    protected $sorting;

    /**
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param int $crdate
     *
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param $tstamp
     *
     * @return void
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return string
     */
    public function getCType()
    {
        return $this->CType;
    }

    /**
     * @param $ctype
     *
     * @return void
     */
    public function setCType($ctype)
    {
        $this->CType = $ctype;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param $header
     *
     * @return void
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getHeaderPosition()
    {
        return $this->headerPosition;
    }

    /**
     * @param $headerPosition
     *
     * @return void
     */
    public function setHeaderPosition($headerPosition)
    {
        $this->headerPosition = $headerPosition;
    }

    /**
     * @return string
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * @param $bodytext
     *
     * @return void
     */
    public function setBodytext($bodytext)
    {
        $this->bodytext = $bodytext;
    }

    /**
     * Get the colpos
     *
     * @return int
     */
    public function getColPos()
    {
        return (int)$this->colPos;
    }

    /**
     * Set colpos
     *
     * @param int $colPos
     *
     * @return void
     */
    public function setColPos($colPos)
    {
        $this->colPos = $colPos;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     *
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getImagewidth()
    {
        return $this->imagewidth;
    }

    /**
     * @param $imagewidth
     *
     * @return void
     */
    public function setImagewidth($imagewidth)
    {
        $this->imagewidth = $imagewidth;
    }

    /**
     * @return int
     */
    public function getImageorient()
    {
        return $this->imageorient;
    }

    /**
     * @param $imageorient
     *
     * @return void
     */
    public function setImageorient($imageorient)
    {
        $this->imageorient = $imageorient;
    }

    /**
     * @return string
     */
    public function getImagecaption()
    {
        return $this->imagecaption;
    }

    /**
     * @param $imagecaption
     *
     * @return void
     */
    public function setImagecaption($imagecaption)
    {
        $this->imagecaption = $imagecaption;
    }

    /**
     * @return int
     */
    public function getImagecols()
    {
        return $this->imagecols;
    }

    /**
     * @param $imagecols
     *
     * @return void
     */
    public function setImagecols($imagecols)
    {
        $this->imagecols = $imagecols;
    }

    /**
     * @return int
     */
    public function getImageborder()
    {
        return $this->imageborder;
    }

    /**
     * @param $imageborder
     *
     * @return void
     */
    public function setImageborder($imageborder)
    {
        $this->imageborder = $imageborder;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     *
     * @return void
     */
    public function setMedia($media)
    {
        if (null === $this->media) {
            $this->media = new ObjectStorage();
        }

        $this->media = $media;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     *
     * @return void
     */
    public function setAssets($assets)
    {
        if (null === $this->media) {
            $this->assets = new ObjectStorage();
        }

        $this->assets = $assets;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param $layout
     *
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param $cols
     *
     * @return void
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
    }

    /**
     * @return string
     */
    public function getSubheader()
    {
        return $this->subheader;
    }

    /**
     * @param $subheader
     *
     * @return void
     */
    public function setSubheader($subheader)
    {
        $this->subheader = $subheader;
    }

    /**
     * @return string
     */
    public function getHeaderLink()
    {
        return $this->headerLink;
    }

    /**
     * @param $headerLink
     *
     * @return void
     */
    public function setHeaderLink($headerLink)
    {
        $this->headerLink = $headerLink;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @param $imageLink
     *
     * @return void
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;
    }

    /**
     * @return string
     */
    public function getImageZoom()
    {
        return $this->imageZoom;
    }

    /**
     * @param $imageZoom
     *
     * @return void
     */
    public function setImageZoom($imageZoom)
    {
        $this->imageZoom = $imageZoom;
    }

    /**
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * @param $altText
     *
     * @return void
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;
    }

    /**
     * @return string
     */
    public function getTitleText()
    {
        return $this->titleText;
    }

    /**
     * @param $titleText
     *
     * @return void
     */
    public function setTitleText($titleText)
    {
        $this->titleText = $titleText;
    }

    /**
     * @return string
     */
    public function getHeaderLayout()
    {
        return $this->headerLayout;
    }

    /**
     * @param $headerLayout
     *
     * @return void
     */
    public function setHeaderLayout($headerLayout)
    {
        $this->headerLayout = $headerLayout;
    }

    /**
     * @return string
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param $listType
     *
     * @return void
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }
}
