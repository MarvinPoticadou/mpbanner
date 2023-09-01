<?php

namespace Mp\Module\MpBanner\Action\Admin;

use Mp\Module\MpBanner\Search\BannerFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class BannerListAction extends FrameworkBundleAdminController
{
    public function __invoke(): Response
    {
        $gridFactory = $this->get('mp.module.mpbanner.grid.factory.banner');

        $grid = $this->presentGrid($gridFactory->getGrid(BannerFilters::buildDefaults()));

        return $this->render('@Modules/mpbanner/templates/admin/banner_list.html.twig', [
            'grid' => $grid,
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'layoutTitle' => $this->trans('Banners', 'Modules.Mpbanner.Admin'),
        ]);
    }

    private function getToolbarButtons(): array
    {
        return [
            'add' => [
                'href' => $this->generateUrl('admin_mpbanner_create'),
                'desc' => $this->trans('New banner', 'Modules.Mpbanner.Admin'),
                'icon' => 'add_circle_outline',
            ],
        ];
    }
}
