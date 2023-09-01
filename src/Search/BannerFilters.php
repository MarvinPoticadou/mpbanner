<?php
namespace Mp\Module\MpBanner\Search;

use PrestaShop\PrestaShop\Core\Search\Filters;

final class BannerFilters extends Filters
{
    public static function getDefaults(): array
    {
        return [
            'limit' => 0,
            'offset' => 0,
            'orderBy' => 'position',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
