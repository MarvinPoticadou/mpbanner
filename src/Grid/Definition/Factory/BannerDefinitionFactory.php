<?php
namespace Mp\Module\MpBanner\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\PositionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

class BannerDefinitionFactory extends AbstractGridDefinitionFactory
{
    protected function getId(): string
    {
        return 'banner';
    }

    protected function getName(): string
    {
        return $this->trans('Banners', [], 'Modules.Mpbanner.Admin');
    }

    protected function getColumns(): ColumnCollectionInterface
    {
        return (new ColumnCollection())
            ->add(
                (new DataColumn('id'))
                    ->setName($this->trans('ID', [], 'Admin.Global'))
                    ->setOptions([
                        'field' => 'id_mpbanner',
                    ])
            )
            ->add(
                (new PositionColumn('position'))
                    ->setName($this->trans('Position', [], 'Admin.Global'))
                    ->setOptions([
                        'id_field' => 'id_mpbanner',
                        'position_field' => 'position',
                        'update_route' => 'admin_mpbanner_update_positions',
                        'update_method' => 'POST',
                        'record_route_params' => [
                            'id_mpbanner' => 'bannerId',
                        ],
                    ])
            )
            ->add(
                (new ToggleColumn('status'))
                    ->setName($this->trans('Status', [], 'Admin.Global'))
                    ->setOptions([
                        'field' => 'status',
                        'primary_field' => 'id_mpbanner',
                        'route' => 'admin_mpbanner_update_status',
                        'route_param_name' => 'bannerId',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add(
                                (new LinkRowAction('edit'))
                                    ->setIcon('edit')
                                    ->setOptions([
                                        'route' => 'admin_mpbanner_edit',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id_mpbanner',
                                    ])
                            )
                            ->add(
                                (new SubmitRowAction('delete'))
                                    ->setName($this->trans('Delete', [], 'Admin.Actions'))
                                    ->setIcon('delete')
                                    ->setOptions([
                                        'route' => 'admin_mpbanner_delete',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id_mpbanner',
                                        'confirm_message' => $this->trans('Delete selected item?', [], 'Admin.Notifications.Warning'),
                                    ])
                            ),
                    ])
            );
    }
}
