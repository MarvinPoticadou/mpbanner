<?php
namespace Mp\Module\MpBanner\Form\Model;

use Mp\Module\MpBanner\Entity\Banner;
use Mp\Module\MpBanner\Entity\BannerLang;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class BannerData
{
    /**
     * @var array
     * @Assert\Type("array")
     */
    public $title;

    /**
     * @var array
     * @Assert\Type("array")
     */
    public $subTitle;

    /**
     * @var array
     * @Assert\Type("array")
     */
    public $cta;

    /**
     * @var array
     * @Assert\Type("array")
     */
    public $flag;

    /**
     * @var array
     * @Assert\Type("array")
     */
    public $description;

    /**
     * @var string
     * @Assert\Type("string")
     */
    public $url;

    /**
     * @var File
     */
    public $imageFile;

    /**
     * @var File
     */
    public $coverImageFile;

    /**
     * @var File
     */
    public $mobileImageFile;

    /**
     * @var string
     */
    public $mobileBackgroundColor;

    /**
     * @var int
     */
    public $coverPosition;

    /**
     * @var int
     * @Assert\Type("int")
     */
    public $status;

    public function __construct(Banner $banner = null)
    {
        if (!is_null($banner)) {
            /** @var BannerLang $bannerLang */
            foreach ($banner->getBannerLangs() as $bannerLang) {
                $this->title[$bannerLang->getLang()->getId()] = $bannerLang->getTitle();
                $this->subTitle[$bannerLang->getLang()->getId()] = $bannerLang->getSubTitle();
                $this->cta[$bannerLang->getLang()->getId()] = $bannerLang->getCta();
                $this->flag[$bannerLang->getLang()->getId()] = $bannerLang->getFlag();
                $this->description[$bannerLang->getLang()->getId()] = $bannerLang->getDescription();
            }
            $this->url = $banner->getUrl();
            $this->status = $banner->getStatus();
            $this->mobileBackgroundColor = $banner->getMobileBackgroundColor();
            $this->coverPosition = $banner->getCoverPosition();
        }
    }
}
