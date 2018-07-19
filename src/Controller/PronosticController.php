<?php

namespace App\Controller;

use App\Entity\Pronostic;
use App\Form\PronosticType;
use App\Repository\PronosticRepository;
use App\Repository\UserRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/pronostic")
 */
class PronosticController extends Controller
{
    /**
     * @Route("/", name="pronostic_index", methods="GET")
     */
    public function index(PronosticRepository $pronosticRepository): Response
    {
        return $this->render('pronostic/index.html.twig', ['pronostics' => $pronosticRepository->findAll()]);
    }

    /**
     * @Route("/list", name="pronostic_list", methods="GET")
     */
    public function upcoming(GameRepository $gameRepository, UserRepository $userRepository): Response
    {
        $usergames = $userRepository->userGames($this->getUser()->getId());
        //dump($usergames);
        $upcominggames = $gameRepository->upcomingGames($usergames);
        //dump($upcominggames);

        return $this->render('pronostic/pronostic.html.twig', [
          'games' => $usergames,
          'games2' => $upcominggames,
          'title' => "Pronostiquer",
        ]);
    }


    /**
     * @Route("/new/{id}", name="pronostic_new", methods="GET|POST")
     */
    public function new(Request $request, GameRepository $gameRepository, $id): Response
    {
        $pronostic = new Pronostic();
        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);
        $game = $gameRepository->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $pronostic->setIdgame($game);
            $pronostic->setIduser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($pronostic);
            $em->flush();

            return $this->redirectToRoute('pronostic_list');
        }

        return $this->render('pronostic/new.html.twig', [
            'pronostic' => $pronostic,
            'form' => $form->createView(),
            'team1' => $game->getTeam1(),
            'team2' =>$game->getTeam2()
        ]);
    }

    /**
     * @Route("/{id}", name="pronostic_show", methods="GET")
     */
    public function show(Pronostic $pronostic): Response
    {
        return $this->render('pronostic/show.html.twig', ['pronostic' => $pronostic]);
    }

    /**
     * @Route("/{id}/edit", name="pronostic_edit", methods="GET|POST")
     */
    public function edit(Request $request, PronosticRepository $pronosticRepository, GameRepository $gameRepository, $id): Response
    {
        $pronostic = $pronosticRepository->findOneBy(array('iduser' => $this->getUser()->getId(), 'idgame' => $id));
        $game = $gameRepository->find($id);

        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pronostic_list');
        }

        return $this->render('pronostic/new.html.twig', [
            'pronostic' => $pronostic,
            'form' => $form->createView(),
            'team1' => $game->getTeam1(),
            'team2' =>$game->getTeam2()
        ]);
    }

    /**
     * @Route("/{id}", name="pronostic_delete", methods="DELETE")
     */
    public function delete(Request $request, Pronostic $pronostic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pronostic->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pronostic);
            $em->flush();
        }

        return $this->redirectToRoute('pronostic_index');
    }
}
