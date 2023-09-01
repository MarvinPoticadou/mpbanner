<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mp\Module\MpBanner\Core\Module as MpModule;
use Mp\Module\MpBanner\Entity\Banner;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShopBundle\Entity\Repository\TabRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class MpBanner extends MpModule implements WidgetInterface
{
    public function __construct()
    {
        $this->author = 'Marvin POTICADOU';
        $this->name = 'mpbanner';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.7.6', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName = $this->trans('MpBanner', [], 'Modules.Mpbanner.Admin');
        $this->description = $this->trans('Allow to create multiple banners with title, sub-title, image, cta, flag & description', [], 'Modules.Mpbanner.Admin');
    }

    public function install(): bool
    {
        @mkdir(self::getImagesDir(), 0777, true);

        return parent::install() && $this->installTab();
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallTab()
            ;
    }

    public function enable($force_all = false)
    {
        return parent::enable($force_all)
            && $this->installTab()
            ;
    }

    public function disable($force_all = false)
    {
        return parent::disable($force_all)
            && $this->uninstallTab()
            ;
    }

    private function installTab()
    {
        $tabRepository = $this->get('prestashop.core.admin.tab.repository');
        $tabId = (int) $tabRepository->findOneIdByClassName('MpBannerController');
        if (!$tabId) {
            $tabId = null;
        }

        $tab = new Tab($tabId);
        $tab->active = 1;
        $tab->class_name = 'MpBannerController';
        $tab->route_name = 'admin_mpbanner_list';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Banner', array(), 'Modules.Mpbanner.Admin', $lang['locale']);
        }
        $tab->id_parent = (int) $tabRepository->findOneIdByClassName('AdminParentModulesSf');
        $tab->module = $this->name;

        return $tab->save();
    }

    private function uninstallTab()
    {
        $tabRepository = $this->get('prestashop.core.admin.tab.repository');
        $tabId = (int) $tabRepository->findOneIdByClassName('MpBannerController');
        if (!$tabId) {
            return true;
        }

        $tab = new Tab($tabId);

        return $tab->delete();
    }

    public static function getImagesDir(): string
    {
        return _PS_IMG_DIR_ . 'modules/mpbanner';
    }

    public static function getImagePath($imageFilename): string
    {
        return !empty($imageFilename) && file_exists(self::getImagesDir() . '/' . $imageFilename)
            ? _PS_IMG_ . 'modules/mpbanner/' . $imageFilename
            : '';
    }

    public function getContent(): void
    {
        Tools::redirectAdmin($this->context->link->getAdminLink(null, true, [
            'route' => 'admin_mpbanner_list',
        ]));
    }

    public function renderWidget($hookName, array $configuration): string
    {
        if (!$this->isEnabledForShopContext()) {
            return '';
        }
        if (!isset($configuration['page']) || 'index' !== $configuration['page']) {
            return '';
        }
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:mpbanner/templates/front/banners.tpl');
    }

    public function getWidgetVariables($hookName, array $configuration): array
    {
        $container = $this->context->controller->getContainer();

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $banners = $entityManager->getRepository(Banner::class)->findBy(['status' => '1'], ['position' => 'ASC']);

        if (!$banners) {
            return [];
        }
        return [
            'banners' => $banners,
            'lang' => $this->context->language->id,
        ];
    }
}
