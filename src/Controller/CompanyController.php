<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use App\Contract\Company as CompanyContractInterface;
use App\Form\CompanyType;
use App\Response\Error;
use App\Response\Success;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/company')]
class CompanyController extends AbstractController
{
    public function __construct(
        private readonly CompanyContractInterface $service,
    ) {
    }

    #[Route('', name: 'app_company_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->service->list());
    }

    #[Route('/new', name: 'app_company_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $this->service->create($company);

            return $this->json(new Success(), Response::HTTP_CREATED);
        }

        return $this->json(new Error($form), Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->json($this->service->show($id));
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['PATCH', 'PUT'])]
    public function edit(Request $request, Company $company): JsonResponse
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $this->service->update($company);

            return $this->json(new Success());
        }

        return $this->json(new Error($form), Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['DELETE'])]
    public function delete(Company $company): Response
    {
        $this->service->delete($company);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
