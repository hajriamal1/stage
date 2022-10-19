<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\shared\Globals;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ServiceController
 * @package App\Controller
 */
class ServiceController extends AbstractController
{
   private Globals $globals;

   public function __construct( ServiceRepository $serviceRepository){
       return
           $this->serRepo = $serviceRepository;
   }

    /**
     * @param ServiceRepository $serviceRepository
     * @return JsonResponse
     * @Route ("/service", name="services", methods={"GET"})
     */
   public function getServices( ServiceRepository $serviceRepository):JsonResponse{
       $services= $serviceRepository->findAll();
       return $this->json($services);
   }

    /**
     * @param ServiceRepository $serviceRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/service/{id}",name="service", methods={"GET"})
     */
    public function getService (ServiceRepository $serviceRepository, $id):JsonResponse
    {
        $service= $serviceRepository->find($id);
        if (!$service) {
            $data = [
                'status' => 404,
                'errors' => "Service not found",
            ];
            return $this->json($data, 404);
        }
        return $this->json($service);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param EntityManagerInterface $entityManager
     * @param ServiceRepository $serviceRepository
     * @return JsonResponse
     * @Route ("/service", name="add_service",methods={"POST"})
     */
    public function addService (\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, ServiceRepository $serviceRepository)
    {
        try{
            $request = $this->transformJsonBody($request);
            if(!$request || !$request->get('nom')|| !$request->get('description')|| !$request->get('prix')){
                throw new \Exception();
            }
            $service = new Service();
            $service->setNom($request->get('nom'));
            $service->setDescription($request->get('description'));
            $service->setPrix($request->get('prix'));
            $entityManager->persist($service);
            $entityManager->flush();


            $data = [
                'status' => 200,
                'success' => "Service added successfully",
            ];
            return $this->json($data);
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return  $this->json($data,422);
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param EntityManagerInterface $entityManager
     * @param ServiceRepository $serviceRepository
     * @param $id
     * @return JsonResponse
     * @Route ("/service/{id}",name="update_service",methods={"PUT"})
     */
    public function updatService(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager, ServiceRepository $serviceRepository, $id)
    {
        try {
            $service = $serviceRepository->find($id);

            if (!$service) {
                $data = [
                    'status' => 404,
                    'errors' => "Service not found",
                ];
                return $this->response($data, 404);
            }
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('nom') || !$request->request->get('description') || !$request->get('prix')) {
                throw new \Exception();
            }

            $service->setNom($request->get('nom'));
            $service->setDescription($request->get('description'));
            $service->setPrix($request->get('prix'));
            $entityManager->flush();

            $data = [
                'status' => 200,
                'msg' => "Service updated successfully",
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
     * @param ServiceRepository $serviceRepository
     * @param $id
     * @return JsonResponse|void
     * @Route ("/service/{id}", name="delete_ser", methods={"DELETE"})
     */
    public function  deleteService (EntityManagerInterface $entityManager, ServiceRepository $serviceRepository, $id){
        $service=$serviceRepository->find($id);
        if ($service) {
            $data= [
                'status' => 404,
                'errors' => "vol not found",
            ];
            $entityManager->remove($service);
            $entityManager->flush();
            $data=[
                'status' => 200,
                'msg' => "vol deleted successfully",
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
