<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Form\ApiUserModifyType;
use App\Form\ApiUserAddType;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/api", name="app_api")
 * 
 * @OA\Tag(name="user")
 */
class UserController extends AbstractController
{
    /**
     * Renvoie l'utilisateur correspondant au JWT Token
     * 
     * @Route("/user/profile", name="_read_user", methods={"GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Returns one user",
     *     @OA\JsonContent(ref=@Model(type=User::class, groups={"readUser"}))
     * )
     * 
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found"
     * )
     *
     * @return JsonResponse
     */
    public function read(): JsonResponse
    { 
        // On récupére l'utilisateur courant
        $user = $this->getUser();
        // Si aucun utilisateur n'est connecté
        if ($user === null) {
            // On renvoie un code reponse 404
            return $this->json("Aucun utilisateur n'est connecté !",Response::HTTP_NOT_FOUND);
        }
        // Sinon on renvoie l'utilisateur avec un code reponse 200
        return $this->json($user,Response::HTTP_OK,[],["groups"=>["readUser"]]);
    }

    /**
     * Crée un nouvel utilisateur
     * 
     * @Route("/user/add", name="_add_user", methods={"POST"})
     * 
     * @OA\RequestBody(
     *     @Model(type=ApiUserAddType::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="New user created"
     * )
     * 
     * @OA\Response(
     *     response=400,
     *     description="The information provided does not respect the constraints"
     * )
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * 
     * 
     */
    public function add(EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator, UserPasswordHasherInterface $hasher): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $jsoncontent = $request->getContent();
        
        $user = $serializerInterface->deserialize($jsoncontent, User::class, 'json');
        $errorsList = $validator->validate($user);

        if (count($errorsList) > 0) {
            return $this->json(
                $errorsList,
                Response::HTTP_BAD_REQUEST,
                [],
                []
            );
        };

        $textPassword = $user->getPassword();
        $hashedPassword = $hasher->hashPassword(
            $user,
            $textPassword
        );
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new DateTime());
        $user->setRoles(["ROLE_USER"]);
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();

        return $this->json(
            $user,
            Response::HTTP_CREATED,
            [],
            [
                "groups" => [
                    "readUser"
                ]
            ]
        );

    }
    

    /**
     * Modifie l'utilisateur correspondant à l'id 
     * 
     * @Route("/user/{id}", name="_modify_user", requirements={"id":"\d+"}, methods={"PATCH"})
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * @OA\RequestBody(
     *     @Model(type=ApiUserModifyType::class)
     * )
     * 
     * @OA\Response(
     *     response=200,
     *     description="User has been updated"
     * )
     * 
     * @OA\Response(
     *     response=403,
     *     description="User id in url not same the current user"
     * )
     * 
     * @OA\Response(
     *     response=400,
     *     description="The information provided does not respect the constraints"
     * )
     */
    public function modify(int $id, EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator, UserRepository $userRepository, UserPasswordHasherInterface $hasher): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $user = $userRepository->find($id);
        // On compare l'utilisateur connecté et celui donnée dans l'url
        if ($user != $this->getUser()) {
            return $this->json(
                "Vous n'étes pas autorisé à modifier cette utilisateur",
                Response::HTTP_FORBIDDEN,
                [],
                []
            );
        }
        $jsoncontent = $request->getContent();
        
        $userModify = $serializerInterface->deserialize($jsoncontent, User::class, 'json');
        $errorsList = $validator->validate($userModify);
        if (count($errorsList) > 0) {
            return $this->json(
                $errorsList,
                Response::HTTP_BAD_REQUEST,
                [],
                []
            );
        };
        
        if ($userModify->getLastName() != null) {
            $user->setLastName($userModify->getLastName());
        }
        if ($userModify->getFirstName() != null) {
            $user->setFirstName($userModify->getFirstName());
        }
        if ($userModify->getAdress() != null) {
            $user->setAdress($userModify->getAdress());
        }
        if ($userModify->getBirthdate() != null) {
            $user->setBirthdate($userModify->getBirthdate());
        }
        if ($userModify->getPhone() != null) {
            $user->setPhone($userModify->getPhone());
        }
        if ($userModify->getBirthdate() != null) {
            $user->setBirthdate($userModify->getBirthdate());
        }
        
        $user->setUpdatedAt(new DateTime());
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "readUser"
                ]
            ]
        );
        
    }

    /**
     * Supprime l'utilisateur correspondant à l'id
     * 
     * @OA\Response(
     *     response=200,
     *     description="User is delete"
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * 
     * @OA\Response(
     *     response=403,
     *     description="User id in url not same the current user"
     * )
     * 
     * @Route("/user/{id}", name="_delete_user", requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @param integer $id
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function delete(int $id, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository): JsonResponse
    {
        // On récupére l'utilisateur
        $user = $userRepository->find($id);
        // Si l'utilisateur n'existe pas
        if ($user == null) {
            return $this->json("Aucun utilisateur ne correspond à cet id !",Response::HTTP_NOT_FOUND);
        }
        // On compare l'utilisateur connecté et celui donnée dans l'url
        else if ($user != $this->getUser()) {
            return $this->json(
                "Vous n'étes pas autorisé à supprimer cette utilisateur",
                Response::HTTP_FORBIDDEN,
                [],
                []
            );
        }
        
        // On récupére ses favoris
        $userFavorites = $user->getFavorites();
        // Si il y a des favories
        if ($userFavorites !== null) {
            // On boucle sur le tableau pour les supprimer
            foreach ($userFavorites as $favorite) {
                $entityManagerInterface->remove($favorite);
            }
        }
        // On récupére ses commandes
        $userOrders = $user->getOrders();
        // Si il y a des commandes
        if ($userOrders !== null) {
        
            // On boucle sur le tableau pour les supprimer
            foreach ($userOrders as $order) {
                // Avant de supprimer la commande il faut supprimer leurs orderlist
                $orderOrderlists = $order->getOrderlists();
                // On boucle sur le tableau pour les supprimer
                foreach ($orderOrderlists as $orderlist) {
                    $entityManagerInterface->remove($orderlist);
                }
                // Puis on supprime la commande
                $entityManagerInterface->remove($order);
            }
        }
        // On récupére ses commentaires
        $userComments = $user->getComments();
        // Si il y a des commandes
        if ($userComments !== null) {
        
            // On boucle sur le tableau pour supprimer leur utilisateur associé
            foreach ($userComments as $comment) {
                $comment->setUser(null);
            }
        }
            // On supprime l'utilisateur
        $entityManagerInterface->remove($user);
        // On le supprime de la DB
        $entityManagerInterface->flush();

        return $this->json("Utilisateur supprimé",Response::HTTP_OK);
        
    }

}
