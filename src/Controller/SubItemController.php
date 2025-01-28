<?php

namespace App\Controller;

use App\DTO\SubItemDTO;
use App\Entity\SubItem;
use App\Form\SubItemForm;
use App\Repository\SubItemRepository;
use App\Service\SubItemService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubItemController extends AbstractController
{
    public function __construct(
        private SubItemRepository $subItemRepository,
        private EntityManagerInterface $entityManager,
        private SubItemService $subItemService,
    )
    {
    }

    #[Route('/api/sub-item', methods: ['GET'])]
    public function getSubItem(): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => 'List created successfully',
                'data' => $this->subItemRepository->getAllSubItem(),

            ],
            JsonResponse::HTTP_OK
        );
    }

    #[Route('/api/sub-item', methods: ['POST'])]
    public function addSubItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse([
                'error' => 'Invalid JSON payload',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $subItemDto = new SubItemDTO();
        $form = $this->createForm(SubItemForm::class, $subItemDto);
        $form->submit($data);
        if ($form->isValid()) {
            $subItem = $this->subItemService->addSubItem($subItemDto);
            return new JsonResponse([
                'message' => 'Sub Item added successfully',
                'data' => $subItem,
            ], JsonResponse::HTTP_CREATED);
        }
        return  new JsonResponse([$form->getErrors(true)], JsonResponse::HTTP_BAD_REQUEST);
    }

    #[Route('/api/sub-item/{id}', methods: ['PUT'])]
    public function updateSubItem(Request $request, string $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse([
                'error' => 'Invalid JSON payload',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $subItem = $this->entityManager->getRepository(SubItem::class)->find($id);

        if (!$subItem) {
            return new JsonResponse(['error' => 'Sub Item not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $subItemDto = new SubItemDTO();
        $form = $this->createForm(SubItemForm::class, $subItemDto);
        $form->submit($data);
        if ($form->isValid()) {
            $subItem = $this->subItemService->updateSubItem($subItemDto, $subItem);
            return new JsonResponse([
                'message' => 'Sub Item updated successfully',
                'data' => $subItem,
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return  new JsonResponse([$form->getErrors(true)], JsonResponse::HTTP_BAD_REQUEST);
    }

    #[Route('/api/delete/sub-item/{id}', methods: ['DELETE'])]
    public function deleteItem(Request $request, string $id): JsonResponse
    {
        $subItem = $this->entityManager->getRepository(SubItem::class)->find($id);

        if (!$subItem) {
            return new JsonResponse([
                'error' => 'Sub Item not found',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->subItemService->removeSubItem($subItem);

        return new JsonResponse([
            'message' => 'Sub Item deleted successfully',
        ], JsonResponse::HTTP_NO_CONTENT);

    }
}
