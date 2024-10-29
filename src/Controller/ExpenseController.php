<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Expense;
use App\Factory\ExpenseFactoryInterface;
use App\Form\ExpenseType;
use App\Repository\ExpenseRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/expense')]
class ExpenseController extends AbstractController
{
    public function __construct(
        private readonly ExpenseFactoryInterface $expenseFactory,
        private readonly ExpenseRepositoryInterface $expenseRepository,
    ) {
    }

    #[Route('/', name: 'app_expense_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('expense/index.html.twig', [
            'expenses' => $this->expenseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_expense_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $expense = $this->expenseFactory->createBlankObject();

        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->expenseRepository->save($expense);

            return $this->redirectToRoute('app_expense_show', ['id' => $expense->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expense/new.html.twig', [
            'expense' => $expense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expense_show', methods: ['GET'])]
    public function show(Expense $expense): Response
    {
        return $this->render('expense/show.html.twig', [
            'expense' => $expense,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_expense_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Expense $expense): Response
    {
        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->expenseRepository->save();

            return $this->redirectToRoute('app_expense_show', ['id' => $expense->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expense/edit.html.twig', [
            'expense' => $expense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expense_delete', methods: ['POST'])]
    public function delete(Request $request, Expense $expense): Response
    {
        $token = (string) $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $expense->getId(), $token)) {
            $this->expenseRepository->delete($expense);
        }

        return $this->redirectToRoute('app_expense_index', [], Response::HTTP_SEE_OTHER);
    }
}
