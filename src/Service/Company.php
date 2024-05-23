<?php

namespace App\Service;

use App\Entity\Company as CompanyEntity;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class Company implements \App\Contract\Company
{
    private const CACHE_KEY_SHOW = 'app_service_company_show';
    private const CACHE_KEY_LIST = 'app_service_company_list';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CompanyRepository $repository,
        private readonly CacheInterface $cache,
    ) {
    }

    public function create(CompanyEntity $company): void
    {
        $this->entityManager->persist($company);
        $this->entityManager->flush();

        $this->cache->deleteItem(self::CACHE_KEY_LIST);
    }

    public function update(CompanyEntity $company): void
    {
        $this->entityManager->flush();

        $this->cache->deleteItem(self::CACHE_KEY_SHOW . $company->getId());
        $this->cache->deleteItem(self::CACHE_KEY_LIST);
    }

    public function delete(CompanyEntity $company): void
    {
        $this->entityManager->remove($company);
        $this->entityManager->flush();

        $this->cache->deleteItem(self::CACHE_KEY_SHOW . $company->getId());
        $this->cache->deleteItem(self::CACHE_KEY_LIST);
    }

    public function show(int $companyId): ?CompanyEntity
    {
        return $this->cache->get(self::CACHE_KEY_SHOW . $companyId, function (CacheItemInterface $item) use ($companyId) {
            $model = $this->repository->find($companyId);
            $item->set($model);

            return $model;
        });
    }

    public function list(): array
    {
        return $this->cache->get(self::CACHE_KEY_LIST, function (CacheItemInterface $item) {
            $model = $this->repository->findAll();
            $item->set($model);

            return $model;
        });
    }
}