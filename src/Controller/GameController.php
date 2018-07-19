<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="game_index", methods="GET")
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', ['games' => $gameRepository->findAll()]);
    }

    /**
     * @Route("/user", name="game_results", methods="GET")
     */
    public function userresults(UserRepository $userRepository, GameRepository $gameRepository, AuthorizationCheckerInterface $authChecker): Response
    {
        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            $pastgames = $gameRepository->pastgGames();
            $classement = $userRepository->getClassement();
            $nbuser = $userRepository->getnbuser()[0][1];
            $usernbpronos = $userRepository->getusernbpronos(NULL);
            $userbonpronos = $userRepository->getuserbonpronos(NULL);
            $successpercent = round($userbonpronos[0][1]/$usernbpronos[0][1]*100, 1, PHP_ROUND_HALF_UP);
            //dump($userbonprono);
            $multiples = $this->getParameter('multiples');
            return $this->render('game/adminresults.html.twig', [
              'games' => $pastgames,
              'classement' => $classement,
              'nbuser' => $nbuser,
              'multiples' => $multiples,
              'usernbpronos' => $usernbpronos[0][1],
              'userbonpronos' => $userbonpronos[0][1],
              'successpercent' => $successpercent,
              'title' => "Résultats",
              'subtitle' => "Vérifiez vos pronosticks"
            ]);
        } else {
            $usergames = $userRepository->pastUserGames($this->getUser()->getId());
            $classement = $userRepository->getClassement();
            $usernbpronos = $userRepository->getusernbpronos($this->getUser()->getId());
            $userbonpronos = $userRepository->getuserbonpronos($this->getUser()->getId());
            $successpercent = round($userbonpronos[0][1]/$usernbpronos[0][1]*100, 1, PHP_ROUND_HALF_UP);
            //dump($userbonprono);
            $multiples = $this->getParameter('multiples');
            //dump($multiples);
            //dump($classement);
            return $this->render('game/userresults.html.twig', [
              'games' => $usergames,
              'classement' => $classement,
              'multiples' => $multiples,
              'usernbpronos' => $usernbpronos[0][1],
              'userbonpronos' => $userbonpronos[0][1],
              'successpercent' => $successpercent,
              'title' => "Résultats",
              'subtitle' => "Vérifiez vos pronosticks"
            ]);
        }

    }

    /**
     * @Route("/all", name="game_allresults", methods="GET")
     */
    public function allresults(GameRepository $gameRepository): Response
    {
        $pastgames = $gameRepository->pastgGames();
        //dump($pastgames);
        return $this->render('game/allresults.html.twig', [
          'games' => $pastgames,
          'title' => "Résultats",
          'subtitle' => "Vérifiez vos pronosticks"
        ]);
    }

    /**
     * @Route("/new", name="game_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $game->setScore1(0);
        $game->setScore2(0);
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_show", methods="GET")
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/{id}/edit", name="game_edit", methods="GET|POST")
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_results');
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_delete", methods="DELETE")
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('game_index');
    }
}
