<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PropertySearch;
use App\Form\PostType;
use App\Form\JsonResponse;
use App\Form\PropertySearchType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\File\Exception\FormSizeFileException;
use Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Symfony\Component\HttpFoundation\File\Exception\NoTmpDirFileException;
use Symfony\Component\HttpFoundation\File\Exception\PartialFileException;



/**
 * @Route("/")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/articulos", name="posts_index", methods={"GET", "POST"})
     */

        public function index(PaginatorInterface $paginator, Request $request): Response
        {
            $search = new PropertySearch();
            $form = $this->createForm(PropertySearchType::class, $search);
            $form ->handleRequest($request);
            
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Posts::class)->findAllVisibleQuery($search);
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                24 /*limit per page*/
            );
            return $this->render('posts/index.html.twig', [
                    'pagination' => $pagination,
                    'form' => $form->createView()
            ]);
        }
        

    /**
     * @Route("articulo/nuevo", name="posts_new", methods={"GET","POST"})
     */
    public function new(Request $request,SluggerInterface $slugger): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form->get('foto')->getData();
            $brochureFileB = $form->get('fotoB')->getData();

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
            if ($brochureFileB) {
                $originalFilename = pathinfo($brochureFileB->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFileB->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFileB->move(
                        $this->getParameter('fotos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('ERROR');
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFotoB($newFilename);
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

    public function show(Posts $post, $id): Response
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

    public function edit(Request $request, Posts $post,SluggerInterface $slugger): Response
    {
        
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('foto')->getData();
            $brochureFileB = $form->get('fotoB')->getData();
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
                    throw new \Exception('ERROR');
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
                }
                 if ($brochureFileB) {
                    $originalFilename = pathinfo($brochureFileB->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFileB->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFileB->move(
                            $this->getParameter('fotos_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        throw new \Exception('ERROR');
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $post->setFotoB($newFilename);
                }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('posts/edit.html.twig', [
            'posts' => $post,
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
     * @Route("/categoria/{category}/index", name="category_id_index", methods={"GET", "POST"})
     */
    public function categoryindex(Request $request,$category, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Posts::class)->findBy(
            ['category' => $category],
            ['precio' => 'ASC']
        );
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
        return $this->render('posts/category_post.html.twig', [
            'pagination' => $pagination
        ]);
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
    /**
     * @Route("/administrador", name="administrador", methods={"GET"})
     */
    public function administrador(Request $request, PaginatorInterface $paginator): Response
    { 
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Posts::class)->BuscarTodosLosPosts();
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/
            );
            return $this->render('posts/administrador.html.twig', [
                    'pagination' => $pagination
            ]);
    }
    public function searchBar(){
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('handlesearch'))
        ->add('Nombre',TextType::class)
        ->add('Buscar', SubmitType::class)
        ->getForm();
        return $this->render('posts/searchbar.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/buscar", name="handlesearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, PostsRepository $postsRepository){
        $query = $request->request->get('form')['Nombre'];
        if($query){
            $posts = $postsRepository->findPostsByName($query);
        }
        return $this->render('posts/results.html.twig',[
            'posts' => $posts
        ]);
    }
}
