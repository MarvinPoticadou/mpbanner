<?php

namespace Mp\Module\MpBanner\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Lang;

/**
 * @ORM\Entity
 * @ORM\Table("ps_mpbanner_lang")
 */
class BannerLang
{
    /**
     * @var Banner
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mp\Module\MpBanner\Entity\Banner", inversedBy="bannerLangs")
     * @ORM\JoinColumn(name="id_mpbanner", referencedColumnName="id_mpbanner", nullable=false)
     */
    private $banner;

    /**
     * @var Lang
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
     * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
     */
    private $lang;

    /**
     * @var string
     * @ORM\Column(name="title")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="sub_title")
     */
    private $subTitle;

    /**
     * @var string
     * @ORM\Column(name="cta")
     */
    private $cta;

    /**
     * @var string
     * @ORM\Column(name="flag")
     */
    private $flag;

    /**
     * @var string
     * @ORM\Column(name="description")
     */
    private $description;

    /**
     * @return Banner
     */
    public function getBanner(): Banner
    {
        return $this->banner;
    }

    /**
     * @param Banner $banner
     * @return Banner
     */
    public function setBanner(Banner $banner): self
    {
        $this->banner = $banner;
        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang(): Lang
    {
        return $this->lang;
    }

    /**
     * @param Lang $lang
     * @return Banner
     */
    public function setLang(Lang $lang): self
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Banner
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @param string $subTitle
     * @return Banner
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getCta()
    {
        return $this->cta;
    }

    /**
     * @param string $cta
     * @return Banner
     */
    public function setCta($cta)
    {
        $this->cta = $cta;
        return $this;
    }

    /**
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param string $flag
     * @return Banner
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Banner
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getSubtitleAndDescription(): string
    {
        return $this->subTitle . PHP_EOL . $this->description;
    }

//    public function getImagePath(): ?string
//    {
//        return $this->getFilename()
//            ? _PS_IMG_ . 'modules/pwadvancedbanner/' . $this->getFilename()
//            : null;
//    }
//
//    public function getMobileImagePath(): ?string
//    {
//        return $this->getMobileFilename()
//            ? _PS_IMG_ . 'modules/pwadvancedbanner/' . $this->getMobileFilename()
//            : null;
//    }

    public function getPaddingBottom()
    {
        if (($sizes = @getimagesize(_PS_ROOT_DIR_ . $this->getImagePath())) != false) {
            return $sizes[1] / $sizes[0] * 100;
        }

        return 0;
    }
}
