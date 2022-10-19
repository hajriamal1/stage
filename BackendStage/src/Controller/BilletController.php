<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\User;
use App\Entity\Vol;
use App\Form\BilletType;
use App\Repository\BilletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BilletController extends AbstractController
{
    /**
     * @param BilletRepository $billetRepository
     * @return JsonResponse
     * @Route ("/billet", name="billets",methods={"GET"})
     */
    public function index(BilletRepository $billetRepository): JsonResponse
    {
        $billet = $billetRepository->findAll();
        return $this->json($billet);
    }

    /**
     * @param string $username
     * @return JsonResponse
     * @Route ("/username/{username}", name="username",methods={"GET"})
     */
    public function getByUsername(string $username): JsonResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(array('username' => $username));
        if (!$user) {
            $data = [
                'status' => 404,
                'errors' => "user not found",
            ];
            return $this->json($data, 404);
        }
        return $this->json($user);
    }

    /**
     * @param string $villeDepart
     * @param string $villeArrivee
     * @return JsonResponse
     * @Route ("/volMul/{villeDepart}/{villeArrivee}", name="user_username",methods={"GET"})
     */
    public function getvolbyVille(string $villeDepart, string $villeArrivee)
    {
        $vol = $this->getDoctrine()->getRepository(Vol::class)->findBy(array('villeDepart' => $villeDepart, 'villeArrivee' => $villeArrivee));
        return $this->json($vol);
    }
    /**
    #[Route('/new', name: 'app_billet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BilletRepository $billetRepository): Response
    {
        $billet = new Billet();
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billetRepository->add($billet);
            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('billet/new.html.twig', [
            'billet' => $billet,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_billet_show', methods: ['GET'])]
    public function show(Billet $billet): Response
    {
        return $this->render('billet/show.html.twig', [
            'billet' => $billet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_billet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Billet $billet, BilletRepository $billetRepository): Response
    {
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billetRepository->add($billet);
            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('billet/edit.html.twig', [
            'billet' => $billet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_billet_delete', methods: ['POST'])]
    public function delete(Request $request, Billet $billet, BilletRepository $billetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billet->getId(), $request->request->get('_token'))) {
            $billetRepository->remove($billet);
        }

        return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
    }
*/
}
