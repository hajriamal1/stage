<?php

namespace App\Controller;

use App\Entity\Companie;
use App\Repository\CompanieRepository;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CompanieController
 * @package App\Controller
 * @Route("/api", name="companie_post")
 */
class CompanieController extends AbstractController
{

    /**
     * @param CompanieRepository $companieRepository
     * @return JsonResponse
     * @Route ("/companies", name="companies", methods={"GET"})
     */
    public function getCompanies(CompanieRepository $companieRepository): JsonResponse
    {
        $data = $companieRepository->findAll();
        return $this->json($data);

    }

    /**
     * @param CompanieRepository $companieRepository
     * @return JsonResponse
     * @Route ("/companie", name="companies", methods={"POST"})
     */
    public function addCompanie(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, CompanieRepository $companieRepository)
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('nom') || !$request->request->get('description')) {
                throw new \Exception();
            }

            $companie = new Companie();
            $companie->SetNom($request->get('nom'));
            $companie->setDescription($request->get('description'));
            $entityManager->persist($companie);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Companie added successfully",
            ];
            return $this->response($data);
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);

        }

    }

    /**
     * @param CompanieRepository $companieRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/companie/{id}", name="get_companie", methods={"GET"})
     */
    public function getCompanie(CompanieRepository $companieRepository, $id):JsonResponse
    {
        $companie= $companieRepository->find($id);

        if(!$companie){
            $data = [
                'status' =>404,
                'errors' => "companie Not found",
            ];
            return  $this->json($data,404);
        }
        return $this->json($companie);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CompanieRepository $companieRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/companies/{id}", name="put_companie",methods={"PUT"})
     */
    public function updateCompanie(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, CompanieRepository $companieRepository, $id)
    {
        try {
            $companie = $companieRepository->find($id);

            if (!$companie) {
                $data = [
                    'status' => 404,
                    'errors' => "Companie not found",
                ];
                return $this->response($data, 404);
            }
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('nom') || !$request->request->get('description')) {
                throw new \Exception();
            }

            $companie->setNom($request->get('nom'));
            $companie->setDescription($request->get('description'));
            $entityManager->flush();

            $data = [
                'status' => 200,
                'errors' => "Companie updated successfully",
            ];
            return $this->response($data);
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param CompanieRepository $companieRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/companies/{id}", name="companoe_delete", methods={"DELETE"})
     */
    public function deleteCompanie(EntityManagerInterface $entityManager, CompanieRepository $companieRepository, $id)
    {
        $companie = $companieRepository->find($id);

        if (!$companie) {
            $data = [
                'status' => 404,
                'errors' => "Companie not found",
            ];
            return $this->response($data, 404);
        }
        $entityManager->remove($companie);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => "Companie deleted successfully",
        ];
        return $this->response($data);

    }


    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

}