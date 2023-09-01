<?php

namespace Mp\Module\MpBanner\Action\Admin;

use PrestaShop\PrestaShop\Core\Grid\Position\Exception\PositionDataException;
use PrestaShop\PrestaShop\Core\Grid\Position\Exception\PositionUpdateException;
use PrestaShop\PrestaShop\Core\Grid\Position\GridPositionUpdaterInterface;
use PrestaShop\PrestaShop\Core\Grid\Position\PositionDefinition;
use PrestaShop\PrestaShop\Core\Grid\Position\PositionUpdateFactory;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionUpdateAction extends FrameworkBundleAdminController
{
    public function __invoke(Request $request, int $bannerId): Response
    {
        $positionsData = [
            'positions' => $request->request->get('positions', null),
        ];

        /** @var PositionDefinition $positionDefinition */
        $positionDefinition = $this->get('mp.module.mpbanner.grid.position_definition');
        /** @var PositionUpdateFactory $positionUpdateFactory */
        $positionUpdateFactory = $this->get('prestashop.core.grid.position.position_update_factory');

        try {
            $positionUpdate = $positionUpdateFactory->buildPositionUpdate($positionsData, $positionDefinition);
        } catch (PositionDataException $e) {
            $this->flashErrors([$e->toArray()]);

            return $this->redirectToRoute('admin_mpbanner_list');
        }

        /** @var GridPositionUpdaterInterface $updater */
        $updater = $this->get('prestashop.core.grid.position.doctrine_grid_position_updater');
        try {
            $updater->update($positionUpdate);
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));
        } catch (PositionUpdateException $e) {
            $this->flashErrors([$e->toArray()]);
        }

        return $this->redirectToRoute('admin_mpbanner_list');
    }
}
