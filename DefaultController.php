<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Panier;
use FrontBundle\Entity\Panier_element;
use FrontBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }

    public function accueilAction()
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        return $this->render('@Front/Default/index.html.twig',array('produit'=>$produit));
    }

    public function proposAction()
    {
        return $this->render('@Front/Default/propos.html.twig');
    }

    public function evenementsAction()
    {
        return $this->render('@Front/Default/evenements.html.twig');
    }

    public function produitAction()
    {
        return $this->render('@Front/Default/produit.html.twig');
    }

    public function wishlistAction()
    {
        return $this->render('@Front/Default/wishlist.html.twig');
    }

    public function promotionAction()
    {
        return $this->render('@Front/Default/promotion.html.twig');
    }


    public function PanierAction()
    {
        return $this->render('@Front/Default/Panier.html.twig');
    }

    public function CheckoutAction()
    {
        return $this->render('@Front/Default/Checkout.html.twig');
    }

    public function blogsAction()
    {
        return $this->render('@Front/Default/blogs.html.twig');
    }


    public function documentationAction()
    {
        return $this->render('@Front/Default/documentation.html.twig');
    }

    public function contactAction()
    {
        return $this->render('@Front/Default/contact.html.twig');
    }
    public  function  commandeAction(){
        //nfaslou fil cookies fi lista mta3 des produit
        $panier = explode(",", $_COOKIE["card"]);
        $paneirObjext = [];
        $i = 0;
        foreach ($panier as $card) {
            $i++;
            //nbadlou les produits l json
            $cardObject = str_replace('&#44', ',', $card);
            if ($i <> 0)
                //raj3ouhom objet php
                $cardObj = json_decode($cardObject);
            //najouti les produit mte3na
            array_push($paneirObjext, $cardObj);
        }
        $total = 0;
        for ($j = 1; $j < sizeof($paneirObjext); $j++) {
            $total += $paneirObjext[$j]->prix;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $panier = new Panier();
        $panier->setTotal($total);
        $panier->setDate(new \DateTime());
        $entityManager->persist($panier);
        for ($k = 1; $k < sizeof($paneirObjext); $k++) {
            $panier_element = new Panier_element();
            $panier_element->setNom($paneirObjext[$k]->nom);
            $panier_element->setPrix($paneirObjext[$k]->prix);
            $panier_element->setPanier($panier);
            $entityManager->persist($panier_element);

        }
        //unset($_COOKIE['card']);
       // setcookie("card", "", time() - 3600);


        $entityManager->flush();

 return $this->redirectToRoute('accueil');

    }


    public function ppanierAction()
    {
        return $this->render('@Front/Default/ppanier.html.twig');
    }
}
