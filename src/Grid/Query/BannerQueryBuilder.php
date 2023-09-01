<?php
namespace Mp\Module\MpBanner\Grid\Query;

use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class BannerQueryBuilder extends AbstractDoctrineQueryBuilder
{
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria)
            ->select('*')
            ->orderBy($searchCriteria->getOrderBy(), $searchCriteria->getOrderWay());

        if ($searchCriteria->getLimit() > 0) {
            $qb
                ->setFirstResult($searchCriteria->getOffset())
                ->setMaxResults($searchCriteria->getLimit());
        }

        return $qb;
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        return $this->getQueryBuilder($searchCriteria)->select('COUNT(s.id_mpbanner)');
    }

    private function getQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->connection->createQueryBuilder()
            ->from($this->dbPrefix . 'mpbanner', 's');

        foreach ($searchCriteria->getFilters() as $name => $value) {
            $qb
                ->andWhere(sprintf('s.%s LIKE :%s', $name, $name))
                ->setParameter($name, '%' . $value . '%');
        }

        return $qb;
    }
}
