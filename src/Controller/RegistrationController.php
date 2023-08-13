<?php
namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\User;
use App\Entity\City;
use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/updateanddelete', name: 'app_update', methods: ['PUT', 'DELETE'])] 

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($request->getMethod() === 'PUT') {
            // Handle PUT request to update user info
            $data = json_decode($request->getContent(), true);
            $userId = $data['id'];
            $user = $entityManager->getRepository(User::class)->find($userId);
        
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setEmail($data['email']);
            $user->setGender($data['gender']);
            $user->setDateOfBirth(new \DateTime($data['dateOfBirth']));
            
            // Create a new Adresse entity for lives
            $lives = new Adresse();
            $lives->setLine1($data['lives']['line1']);
            $city = $entityManager->getRepository(City::class)->find($data['lives']['city']);
            $lives->setCity($city);
            
            // Set the lives property of the user
            $user->setLives($lives);
            
            // $user->setRoles($data['roles']);
            $validRoles = ['BUYER', 'SELLER'];
            if (isset($data['roles']) && is_array($data['roles'])) {
                $filteredRoles = array_intersect($data['roles'], $validRoles);
                $user->setRoles($filteredRoles);
            }
            
            // Handling plainPassword depend on your authentication/security logic
            if (isset($data['plainPassword'])) {
                $encodedPassword = $userPasswordHasher->hashPassword($user, $data['plainPassword']);
                $user->setPassword($encodedPassword);
            }
        
            $entityManager->flush();
            
            $responseData = [
                'message' => 'User updated successfully',
            ];
        
            return new JsonResponse($responseData);
        }

        elseif ($request->getMethod() === 'DELETE') {
            // Handle DELETE request to delete a user
            $data = json_decode($request->getContent(), true);
            $userId = $data['id'];
            $user = $entityManager->getRepository(User::class)->find($userId);

            $entityManager->remove($user);
            $entityManager->flush();

            $responseData = [
                'message' => 'User deleted successfully',
            ];
        
            return new JsonResponse($responseData);
        }

        // Handle POST request for registration
        $user = new User();
        $lives = new Adresse();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $lives->setLine1($form->get('lives')['line1']->getData());
            $city = $entityManager->getRepository(City::class)->find($form->get('lives')['city']->getData());
            $lives->setCity($city);

            $user->setLives($lives);

            $entityManager->persist($user);
            $entityManager->flush();

            $responseData = [
                'message' => 'Registration successful',
            ];

            return new JsonResponse($responseData, Response::HTTP_CREATED);
        } else {
            // Handle form validation errors

            $formErrors = $this->getFormErrors($form);

            return new JsonResponse(['errors' => $formErrors], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }
        return $errors;
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function registerUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        // Handle POST request for registration
        $user = new User();
        $lives = new Adresse();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $lives->setLine1($form->get('lives')['line1']->getData());
            $city = $entityManager->getRepository(City::class)->find($form->get('lives')['city']->getData());
            $lives->setCity($city);

            $user->setLives($lives);

            $entityManager->persist($user);
            $entityManager->flush();

            $responseData = [
                'message' => 'Registration successful',
            ];

            return new JsonResponse($responseData, Response::HTTP_CREATED);
        } else {
            // Handle form validation errors

            $formErrors = $this->getFormErrors($form);

            return new JsonResponse(['errors' => $formErrors], Response::HTTP_BAD_REQUEST);
        }
    }



    #[Route('/api/myusers', name: 'list_users', methods: ['GET'])]
    public function listUsers(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        // Handle fetching list of users or specific user info
        $users = $entityManager->getRepository(User::class)->findAll();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->getId(),
                'email' =>$user->getEmail(),
                'roles' =>$user->getRoles(),
                'firstName' => $user->getFirstName(),
                'lastName'  => $user->getLastName(),
                'gender'  => $user->getGender(),
                'dateOfBirth'  => $user->getDateOfBirth(),
                // 'nftOwner'  => $user->getNftOwner(),

                // ... other user properties ...
                'lives' => [
                    'line1' => $user->getLives()->getLine1(),
                    'city' => $user->getLives()->getCity(),
                    // ... other lives properties ...
                ],
            ];
        }

        $responseData = [
            'users' => $userData,
        ];

        $serializedUsers = $serializer->serialize($responseData, 'json', ['groups' => 'read']);
        return new JsonResponse($serializedUsers);
    }

}









//     if ($request->getMethod() === 'GET') {
    //         // Handle GET request to fetch list of users or specific user info
    //         $users = $entityManager->getRepository(User::class)->findAll();

    //         $userData = [];
    //         foreach ($users as $user) {
    //             $userData[] = [
    //                 'id' => $user->getId(),
    //                 'email' =>$user->getEmail(),
    //                 'roles' =>$user->getRoles(),
    //                 'firstName' => $user->getFirstName(),
    //                 'lastName'  => $user->getLastName(),
    //                 'gender'  => $user->getGender(),
    //                 'dateOfBirth'  => $user->getDateOfBirth(),
    //                 // 'nftOwner'  => $user->getNftOwner(),

    //                 // ... other user properties ...
    //                 'lives' => [
    //                     'line1' => $user->getLives()->getLine1(),
    //                     'city' => $user->getLives()->getCity(),
    //             // ... other lives properties ...
    //         ],
    //     ];
    // }
    //         $responseData = [
    //             'users' => $userData,
    //         ];
    //         return new JsonResponse($responseData);
    //     } 







/* namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            // return $this->redirectToRoute('app_nft');
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
*/
