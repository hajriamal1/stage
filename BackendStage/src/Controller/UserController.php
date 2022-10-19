<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\shared\ErrorHttp;
use App\shared\Globals;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use function MongoDB\BSON\toJSON;

/**
 * Class UserController
 * @package App\Controller\Api\v1\secure
 * @Route("/api")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserController extends AbstractController
{
    private UserRepository $userRepo;
    private Globals $globals;

    public function   __construct(UserRepository $userRepo, Globals $globals)
    {
        $this->globals = $globals;
        $this->userRepo = $userRepo;
    }

    /**
     * @Route("/users", name="users", methods={"GET"})
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function users (UserRepository $userRepository): JsonResponse
    {
       /** return $this->globals->success([
            'users' => array_map(function(User $user){
                return $user->tojson();
            }, $this->userRepo->findAll())
        ]);
        * */
        $em=$this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        /* @var $users User[] */

        $formatted = [];
        foreach ($users as $user) {
            $formatted[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'telephone' => $user->getTelephone(),
                'roles' => $user->getRoles()[0]
            ];
        }
        return new JsonResponse($formatted);
    }



    /**
     * @Route("/user/{id}", name="user", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function user(int $id): JsonResponse
    {
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);

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
     * @Route("/save", name="save", methods={"POST"})
     * @return JsonResponse
     */
    public function save(): JsonResponse
    {
        $data = $this->globals->jsondecode();
        if (!isset(
            $data->username,
            $data->nom,
            $data->prenom,
            $data->email,
            $data->telephone,
            $data->role
        )) return $this->globals->error(ErrorHttp::FORM_INVALID);

        if ($this->userRepo->findOneBy(['username' => $data->username]) !== null)
            return $this->globals->error(ErrorHttp::USERNAME_EXIST);


        if (!in_array($data->role, ['ROLE_ADMIN', 'ROLE_USER'], true))
            return $this->globals->error(ErrorHttp::ROLE_NOT_FOUND);

        $user = (new User())

            ->setUsername($data->username)
            ->setNom($data->nom)
            ->setPrenom($data->prenom)
            ->setEmail($data->email)
            ->setTelephone($data->telephone)
            ->setRoles([$data->role]);

        $user->setPassword($this->globals->encoder()->encodePassword($user, str_shuffle('qwertyuioasdfghjkxcvbnm234567890')));

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->globals->success($user->tojson());
    }


    /**
     * @Route("/update/{id}", name="update", methods={"PUT"})
     * @return JsonResponse
     */
    public function update(Request $request, int$id): JsonResponse
    {
       $data = $this->globals->jsondecode();

        $user = $this->userRepo->findOneBy(['id' => $id]);
        if (!$user)
            return $this->globals->error(ErrorHttp::USER_NOT_FOUND);

        $checkByUsername = $this->userRepo->findOneBy(['username' => $data->username]);
        if ($checkByUsername !==  null && $checkByUsername !== $user)
            return $this->globals->error(ErrorHttp::USERNAME_EXIST);



        if (!in_array($data->role, ['ROLE_ADMIN', 'ROLE_USER'], true))
            return $this->globals->error(ErrorHttp::ROLE_NOT_FOUND);

        $user
            ->setUsername($data->username)
            ->setNom($data->nom)
            ->setPrenom($data->prenom)
            ->setEmail($data->email)
            ->setTelephone($data->telephone)
            ->setRoles([$data->role]);


            $user->setPassword($this->globals->encoder()->encodePassword($user, str_shuffle('qwertyuioasdfghjkxcvbnm234567890')));

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        // envoi du mail apres mis a jour de l'utilisateur
        return $this->globals->success($user->tojson());

    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        /** $em=$this->getDoctrine()->getManager();

        $id = $request->query->get('id');
        if (!$id)
            return $this->globals->error(ErrorHttp::PARAM_GET_NOT_FOUND);

        $user = $this->userRepo->findOneBy(['id' => $id]);
        if (!$user){
            return $this->globals->error(ErrorHttp::USER_NOT_FOUND);

        }else
        {
            $em->remove($user);

            $em->flush();
            return $this->globals->success();
        }*/

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);

        if (!$user){
            return $this->json('No project found for id' . $id, 404);
        }
        $em->remove($user);
        $em->flush();
        return $this->globals->success();
    }
    

}
