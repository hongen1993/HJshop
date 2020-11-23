<?php 

namespace App\Service\Cart;

use App\Repository\PostsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $postsRepository;

    public function __construct(SessionInterface $session, PostsRepository $postsRepository)
    {
        $this->session = $session;
        $this->postsRepository = $postsRepository;
    }
    public function add(int $id){
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }
        
         
       $this->session->set('cart', $cart);
    }

    public function remove(int $id){
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }

    public function getFullCart() : array {
        $cart = $this->session->get('cart',[]);
        
        $cartWithData = [];

        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'post' => $this->postsRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithData;

    }

    public function getTotal() : float {
        $total = 0;
        
        foreach($this->getFullCart() as $item){
            $totalItem = $item['post']->getPrecio() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
    }
}