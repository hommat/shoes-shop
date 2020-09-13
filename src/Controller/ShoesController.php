<?php

namespace App\Controller;

use App\Repository\ShoesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shoes", name="app_shoes")
 */
class ShoesController extends AbstractController
{
    private $shoesRepository;

    public function __construct(ShoesRepository $shoesRepository)
    {
        $this->shoesRepository = $shoesRepository;
    }

    /**
     * @Route("/list", name="_list")
     */
    public function list(Request $request)
    {
        $offset = max(0, $request->query->getInt('offset'));
        $paginator = $this->shoesRepository->getShoesPaginator($offset);

        return $this->render('shoes/index.html.twig', [
            'shoesList' => $paginator,
            'previous' => $offset - ShoesRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ShoesRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}
