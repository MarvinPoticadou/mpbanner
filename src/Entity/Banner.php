<?php

namespace Mp\Module\MpBanner\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("ps_mpbanner")
 */
class Banner
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id_mpbanner")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="filename", nullable=true)
     */
    private $filename;

    /**
     * @var string|null
     * @ORM\Column(name="cover_filename", nullable=true)
     */
    private $coverFilename;

    /**
     * @var string|null
     * @ORM\Column(name="mobile_filename", nullable=true)
     */
    private $mobileFilename;

    /**
     * @var string|null
     * @ORM\Column(name="mobile_background_color", nullable=true)
     */
    private $mobileBackgroundColor;

    /**
     * @var string|null
     * @ORM\Column(name="url", nullable=true)
     */
    private $url;

    /**
     * @var int
     * @ORM\Column(name="cover_position")
     */
    private $coverPosition;

    /**
     * @var int
     * @ORM\Column(name="position")
     */
    private $position;

    /**
     * @var int
     * @ORM\Column(name="status")
     */
    private $status;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Mp\Module\MpBanner\Entity\BannerLang", cascade={"persist", "remove"}, mappedBy="banner")
     */
    private $bannerLangs;

    public function __construct()
    {
        $this->bannerLangs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     *
     * @return Banner
     */
    public function setFilename(?string $filename): Banner
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoverFilename(): ?string
    {
        return $this->coverFilename;
    }

    /**
     * @param string|null $coverFilename
     *
     * @return Banner
     */
    public function setCoverFilename(?string $coverFilename): Banner
    {
        $this->coverFilename = $coverFilename;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobileFilename(): ?string
    {
        return $this->mobileFilename;
    }

    /**
     * @param string|null $mobileFilename
     * @return Banner
     */
    public function setMobileFilename(?string $mobileFilename)
    {
        $this->mobileFilename = $mobileFilename;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobileBackgroundColor(): ?string
    {
        return $this->mobileBackgroundColor;
    }

    /**
     * @param string|null $mobileBackgroundColor
     * @return Banner
     */
    public function setMobileBackgroundColor(?string $mobileBackgroundColor)
    {
        $this->mobileBackgroundColor = $mobileBackgroundColor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Banner
     */
    public function setUrl(?string $url): Banner
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return int
     */
    public function getCoverPosition(): int
    {
        return $this->coverPosition;
    }

    /**
     * @param int $coverPosition
     *
     * @return Banner
     */
    public function setCoverPosition(int $coverPosition): Banner
    {
        $this->coverPosition = $coverPosition;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return Banner
     */
    public function setPosition(int $position): Banner
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Banner
     */
    public function setStatus(int $status): Banner
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBannerLangs(): Collection
    {
        return $this->bannerLangs;
    }

    /**
     * @param BannerLang $bannerLang
     *
     * @return Banner
     */
    public function addBannerLangs(BannerLang $bannerLang): Banner
    {
        $this->bannerLangs->add($bannerLang);

        return $this;
    }

    /**
     * @param BannerLang $bannerLang
     *
     * @return Banner
     */
    public function removeBannerLangs(BannerLang $bannerLang): Banner
    {
        $this->bannerLangs->remove($bannerLang);

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->getFilename()
            ? _PS_IMG_ . 'modules/mpbanner/' . $this->getFilename()
            : null;
    }

    public function getCoverImagePath(): ?string
    {
        return $this->getCoverFilename()
            ? _PS_IMG_ . 'modules/mpbanner/' . $this->getCoverFilename()
            : null;
    }

    public function getMobileImagePath(): ?string
    {
        return $this->getMobileFilename()
            ? _PS_IMG_ . 'modules/mpbanner/' . $this->getMobileFilename()
            : null;
    }

    public function getPaddingBottom()
    {
        if (($sizes = @getimagesize(_PS_ROOT_DIR_ . $this->getImagePath())) != false) {
            return $sizes[1] / $sizes[0] * 100;
        }

        return 0;
    }

    /**
     * @param int $langId
     * @return BannerLang|null
     */
    public function getBannerLangByLangId(int $langId)
    {
        foreach ($this->bannerLangs as $bannerLang) {
            if ($langId === $bannerLang->getLang()->getId()) {
                return $bannerLang;
            }
        }
        return null;
    }
}
