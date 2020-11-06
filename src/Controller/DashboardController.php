<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Posts::class)->BuscarTodosLosPosts();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('dashboard/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
