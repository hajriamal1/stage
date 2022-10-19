<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\shared\ErrorHttp;
use App\shared\Globals;
use function MongoDB\BSON\toJSON;



/**
 * Class VolController
 * @package App\Controller
 */


class VolController extends AbstractController
{
    private Globals $globals;
    public function   __construct(VolRepository $volRepository, Globals $globals)
    {
        $this->globals = $globals;
        $this->volRepo = $volRepository;
    }

    /**
     * @param VolRepository $volRepository
     * @return JsonResponse
     * @Route ("/vol", name="vols", methods={"GET"})
     */
    public function getVols(VolRepository $volRepository): JsonResponse
    {
        $data = $volRepository->findAll();
        return $this->json($data);

    }

    /**
     * @param VolRepository $volRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/vol/{id}", name="vol_get", methods={"GET"})
     */
    public function getVol (VolRepository$volRepository, $id):JsonResponse
    {
       $vol= $volRepository->find($id);
       if (!$vol) {
           $data = [
                'status' => 404,
                'errors' => "Vol not found",
            ];
            return $this->json($data, 404);
        }
        return $this->json($vol);
         }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param EntityManagerInterface $entityManager
     * @param VolRepository $volRepository
     * @return JsonResponse
     * @Route ("/vol",name="add_vol",methods={"POST"})
     */
    public function addVol (\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, VolRepository $volRepository)
    {
        try{
            $request = $this->transformJsonBody($request);
            if(!$request || !$request->get('villeDepart')|| !$request->get('villeArrivee')|| !$request->get('dateVol')){
                throw new \Exception();
            }
            $vol = new Vol();
            $vol->setVilleDepart($request->get('villeDepart'));
            $vol->setVilleArrivee($request->get('villeArrivee'));
            $d=$request->get('dateVol');
            $dt= new \DateTime($d);
            $vol->setDateVol($dt);
            $entityManager->persist($vol);
            $entityManager->flush();


            $data = [
                'status' => 200,
                'success' => "Vol added successfully",
            ];
            return $this->response($data);
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return  $this->response($data,422);
        }
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param VolRepository $volRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/vol/{id}", name="put_vol",methods={"PUT"})
     */
    public function updateVol(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, VolRepository $volRepository, $id)
    {
        try {
            $vol = $volRepository->find($id);

            if (!$vol) {
                $data = [
                    'status' => 404,
                    'errors' => "Vol not found",
                ];
                return $this->response($data, 404);
            }
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('villeDepart') || !$request->request->get('villeArrivee') || !$request->get('dateVol')) {
                throw new \Exception();
            }

            $vol->setVilleDepart($request->get('villeDepart'));
            $vol->setVilleArrivee($request->get('villeArrivee'));
            $d=$request->get('dateVol');
            $dt= new \DateTime($d);
            $vol->setDateVol($dt);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'errors' => "Vol updated successfully",
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
     * @param VolRepository $volRepository
     * @param $id
     * @return JsonResponse|void
     * @ROUTE ("/vol/{id}", name="delete_vol", methods={"DELETE"})
     */
    public function  deleteVol (EntityManagerInterface $entityManager, VolRepository $volRepository, $id){
        $vol=$volRepository->find($id);
        if ($vol) {
            $data= [
                'status' => 404,
                'errors' => "vol not found",
            ];
            $entityManager->remove($vol);
            $entityManager->flush();
            $data=[
                'status' => 200,
                'errors' => "vol deleted successfully",
            ];
            return $this->json($data);
        }
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
