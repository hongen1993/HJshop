<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    /**
     * @Route("/carrito", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {  
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
            ]);
    }
    /**
     * @Route("/carrito/add/{id}", name="cart_add")
     */
    public function addCart($id, CartService $cartService,Request $request)
    {
        $cartService->add($id);
        
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("carrito/remove/{id}", name="cart_remove")
     */
    public function removeCart($id, CartService $cartService)
    {
       $cartService->remove($id);

        return $this->redirectToRoute('cart_index');
    }
        /**
     * @Route("/minicart", name="minicart")
     */
    public function minicart(CartService $cartService): Response
    {  
        return $this->render('cart/minicart.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
            ]);
    }
    /**
     * @Route("/pagar", name="pagar")
     */
    public function pagar(Request $request, CartService $cartService)
    {  
        \Stripe\Stripe::setApiKey("sk_test_51HyylkJtahhmAdPzIXlla1MfNtnJ1nhHiu5OMBODIZUWLrrnMqafxac5wHU2ysWqtiOtsquNoQ7NdEZQ6kpbEBjF008x7zfhn3");

        \Stripe\Charge::create(array(
            "amount" => 2000,
            "currency" => "eur",
            "source" => "tok_mastercard",
            "description" => "test"
        ));
        return $this->render('cart/pagar.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
            ]);
    }
    /**
     * @Route("/success", name="success")
     */
    public function success(CartService $cartService): Response
    {  
        return $this->render('cart/success.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
            ]);
    }
        /**
     * @Route("carrito/removeAll", name="cart_removeAllCart")
     */
    public function removeAllCart(CartService $cartService,Request $request)
    {      
         $cartService->removeAll($request);

        return $this->redirectToRoute('dashboard');
    }
    public function helloAction($name)
{
    // The second parameter is used to specify on what object the role is tested.
    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

    // Old way:
    // if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    //     throw $this->createAccessDeniedException('Unable to access this page!');
    // }

    // ...
}
}

