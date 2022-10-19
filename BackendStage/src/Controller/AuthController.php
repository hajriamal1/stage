<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
class AuthController extends  ApiController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public  function  register (Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em =$this-> getDoctrine() -> getManager();
        $request = $this-> transformJsonBody ($request);
        $username= $request->get('username');
        $password= $request->get('password');
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $email=$request->get('email');
        $telephone=$request->get('telephone');


        if (empty($username) || empty($password) ) {
            return $this->respondValidationError("Invalid Username or Password ");
        }
            $user = new User($username);
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setUsername($username);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);
            $user->setTelephone($telephone);

            $em->persist($user);
            $em->flush();
            return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
        }

        /**
         * @param UserInterface $user
         * @param JWTTokenManagerInterface $JWTManager
         * @return JsonResponse
         */
        public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

}