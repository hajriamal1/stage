<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\shared\Globals;
use function MongoDB\BSON\toJSON;

/**
 * Class NewsController
 * @package App\Controller\Api\v1\secure
 */
class NewsController extends AbstractController
{
    private Globals $globals;

    public function  __construct( Globals $globals){
        $this->globals=$globals;
    }
    /**
     * @param NewsRepository $newsRepository
     * @return JsonResponse
     * @Route ("/news", name="news", methods={"GET"})
     */
    public function  getNews (NewsRepository $newsRepository): JsonResponse{


        $em=$this->getDoctrine()->getManager();
        $news=$em->getRepository(News::class)->findAll();

        /* @var $news News[] */

        $formatted = [];
        foreach ($news as $news) {
            $formatted[] = [
                'id' => $news->getId(),
                'titre' => $news->getTitre(),
                'contenu' => $news->getContenu(),
                'photo' => $news->getPhoto()
            ];
        }
        return new JsonResponse($formatted);
    }

    /**
     * @param NewsRepository $newsRepository
     * @param int $id
     * @return JsonResponse
     * @Route ("/new/{id}", name="new", methods={"GET"})
     */
    public  function New (int $id, NewsRepository $newsRepository):JsonResponse{

        /**$new = $this->getDoctrine()->getRepository(News::class)->find($id);
        if (!$new){
            return $this->json('No News found for id  ' . $id, 404);
        }
        return $this->globals->success([
            'New' => $new->tojson()
        ]);*/


    /**    $new =$newsRepository->find($id);
    if(!$new){
        $data=[
            'status' => 404,
            'errors' => "News not found",
        ];
        return  $this->response($data,404);
        }
    return $this->response($new);*/

        $em=$this->getDoctrine()->getManager();
        $new=$em->getRepository(News::class)->find($id);

        if(!$new){
            $data=[
                'status' => 404,
                'errors' => "News not found",
            ];
            return  $this->response($data,404);
        }


            $formatted = [
            'id' => $new->getId(),
                'titre' => $new->getTitre(),
                'contenu' => $new->getContenu(),
                'photo' => $new->getPhoto()
           ] ;

        return new JsonResponse($formatted);

    }




    /**
     * @param NewsRepository $newsRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @Route ("/newsUp/{id}", name="newUp", methods={"PUT"})
     */
    public function updateNews ( EntityManagerInterface $entityManager , NewsRepository $newsRepository, int $id, \Symfony\Component\HttpFoundation\Request $request): JsonResponse
    {
        try {
            $news = $newsRepository->find($id);
            if (!$news) {
                $data = [
                    'status' => 404,
                    'errors' => "News not found",
                ];
                return $this->response($data, 404);
            }
            $request = $this->transformJsonBody($request);

            if (!$news || !$request->get('titre') || !$request->get('contenu')) {
                throw new \Exception();
            }

            $news->setTitre($request->get('titre'));
            $news->setContenu($request->get('contenu'));
            $news->setPhoto($request->get('photo'));
            $entityManager->flush();;

            $data = [
                'status' => 200,
                'errors' => "News updated successfully",
            ];
            return $this->json($data);

        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->json($data, 422);

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
    public function response($data, $status = 200, array $headers = [])
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

    #[Route('/news', name: 'app_news')]
    public function index(): Response
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
