<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\RepeatCost;
use App\Factory\RepeatCostFactoryInterface;
use App\Form\RepeatCostType;
use App\Repository\RepeatCostRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/repeat-cost')]
class RepeatCostController extends AbstractController
{
    public function __construct(
        private readonly RepeatCostFactoryInterface $repeatCostFactory,
        private readonly RepeatCostRepositoryInterface $repeatCostRepository,
    ) {
    }

    #[Route('/', name: 'app_repeat_cost_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/repeat-cost/index.html.twig', [
            'repeatCosts' => $this->repeatCostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_repeat_cost_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $repeatCost = $this->repeatCostFactory->createBlankObject();

        $form = $this->createForm(RepeatCostType::class, $repeatCost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repeatCostRepository->save($repeatCost);

            return $this->redirectToRoute(
                'app_repeat_cost_show',
                ['id' => $repeatCost->getId()],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('admin/repeat-cost/new.html.twig', [
            'repeatCost' => $repeatCost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repeat_cost_show', methods: ['GET'])]
    public function show(RepeatCost $repeatCost): Response
    {
        return $this->render('admin/repeat-cost/show.html.twig', [
            'repeatCost' => $repeatCost,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_repeat_cost_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RepeatCost $repeatCost): Response
    {
        $form = $this->createForm(RepeatCostType::class, $repeatCost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repeatCostRepository->save();

            return $this->redirectToRoute(
                'app_repeat_cost_show',
                ['id' => $repeatCost->getId()],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('admin/repeat-cost/edit.html.twig', [
            'repeatCost' => $repeatCost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repeat_cost_delete', methods: ['POST'])]
    public function delete(Request $request, RepeatCost $repeatCost): Response
    {
        $token = (string) $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $repeatCost->getId(), $token)) {
            $this->repeatCostRepository->delete($repeatCost);
        }

        return $this->redirectToRoute('app_repeat_cost_index', [], Response::HTTP_SEE_OTHER);
    }
}
