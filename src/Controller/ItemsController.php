<?php

namespace App\Controller;

use App\DTO\ItemDTO;
use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemsRepository;
use App\Service\ItemsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    use FormErrorTrait;

    public function __construct(
        private ItemsRepository $itemsRepository,
        private ItemsService $itemsService,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/api/items', methods: ['GET'])]
    public function getItems(): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => 'List created successfully',
                'data' => $this->itemsRepository->getAllItems(),

            ],
            JsonResponse::HTTP_OK
        );
    }

    #[Route('/api/item', methods: ['POST'])]
    public function addItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse([
                'error' => 'Invalid JSON payload',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        $itemDto = new ItemDTO();
        $form = $this->createForm(ItemType::class, $itemDto);
        $form->submit($data);
        if ($form->isValid()) {
            $item = $this->itemsService->addItem($itemDto);
            return new JsonResponse([
                'message' => 'Item added successfully',
                'data' => $item,
            ], JsonResponse::HTTP_CREATED);
        }
        return  new JsonResponse([$form->getErrors(true)], JsonResponse::HTTP_BAD_REQUEST);
    }

    #[Route('/api/item/{id}', methods: ['PUT'])]
    public function updateItem(Request $request, string $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse([
                'error' => 'Invalid JSON payload',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $item = $this->entityManager->getRepository(Item::class)->find($id);

        if (!$item) {
            return new JsonResponse(['error' => 'Item not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $itemDto = new ItemDTO();
        $form = $this->createForm(ItemType::class, $itemDto);
        $form->submit($data);
        if ( $form->isValid()) {
            $item = $this->itemsService->updateItem($item, $itemDto);
        }

        return new JsonResponse([
            'message' => 'Item updated successfully',
            'data' => $item,
        ], JsonResponse::HTTP_ACCEPTED);

    }

    #[Route('/api/delete/item/{id}', methods: ['DELETE'])]
    public function deleteItem(Request $request, string $id): JsonResponse
    {
        $item = $this->entityManager->getRepository(Item::class)->find($id);

        if (!$item) {
            return new JsonResponse([
                'error' => 'Item not found',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->itemsService->removeItem($item);

        return new JsonResponse([
            'message' => 'Item deleted successfully',
        ], JsonResponse::HTTP_NO_CONTENT);

    }


}
