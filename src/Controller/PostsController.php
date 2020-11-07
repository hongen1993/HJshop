<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Form\JsonResponse;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/articulos", name="posts_index", methods={"GET"})
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
            return $this->render('posts/index.html.twig', [
                    'pagination' => $pagination
            ]);
        }

    /**
     * @Route("articulos/nuevo", name="posts_new", methods={"GET","POST"})
     */
    public function new(Request $request,SluggerInterface $slugger): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form['foto']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('fotos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Ha ocurrido un error');
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
            }
            $user = $this->getUser();
            $post->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('posts_index');
        }
        return $this->render('posts/new.html.twig', [
            'posts' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/articulo/{id}", name="posts_show", methods={"GET"})
     */

    public function show(Posts $posts, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Posts::class)->find($id);
        return $this->render('posts/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/articulo/editar/{id}", name="posts_edit", methods={"GET","POST"})
     */

    public function edit(Request $request, Posts $posts): Response
    {
        $form = $this->createForm(PostType::class, $posts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('posts/edit.html.twig', [
            'posts' => $posts,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $posts): Response
    {
        if ($this->isCsrfTokenValid('delete'.$posts->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($posts);
            $entityManager->flush();
        }

        return $this->redirectToRoute('posts_index');
    }

    /**
     * @Route("/Likes", options={"expose"=true}, name="Likes")
     */
    public function Like(Request $request){
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $id = $request->request->get('id');
            $post = $em->getRepository(Posts::class)->find($id);
            $likes = $post->getLikes();
            $likes .= $user->getId().',';
            $post->setLikes($likes);
            $em->flush();
            return new JsonResponse(['likes' =>$likes]);
        }else{
            throw new \Exception('Hacking FAIL');
        }        
    }
}
