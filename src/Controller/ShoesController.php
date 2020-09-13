<?php

namespace App\Controller;

use App\Entity\Shoes;
use App\Repository\ShoesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @Route("/", name="_list")
     */
    public function list(Request $request)
    {
        $offset = max(0, $request->query->getInt('offset'));
        $paginator = $this->shoesRepository->getShoesPaginator($offset);

        return $this->render('shoes/list.html.twig', [
            'shoesList' => $paginator,
            'previous' => $offset - ShoesRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ShoesRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/{slug}", name="_single")
     */
    public function single(string $slug)
    {
        $shoes = $this->shoesRepository->findOneBy(['slug' => $slug]);
        if (!$shoes) {
            throw new NotFoundHttpException('Shoes do not exist');
        }

        return $this->render('shoes/single.html.twig', ['shoes' => $shoes]);
    }
}
