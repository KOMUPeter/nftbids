<?php
namespace App\Controller;

use App\Entity\User;
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
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST', 'GET', 'PUT', 'DELETE'])] 
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($request->getMethod() === 'GET') {
            // Handle GET request to fetch list of users or specific user info
            $users = $entityManager->getRepository(User::class)->findAll();
            
            $responseData = [
                'users' => $users,
            ];

            return new JsonResponse($responseData);
        } elseif ($request->getMethod() === 'PUT') {
            // Handle PUT request to update user info
            $data = json_decode($request->getContent(), true);
            $userId = $data['id'];
            $user = $entityManager->getRepository(User::class)->find($userId);
        
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setEmail($data['email']);
            $user->setGender($data['gender']);
            $user->setDateOfBirth(new \DateTime($data['dateOfBirth']));
            
            // Assuming 'lives' is a OneToOne or ManyToOne relation, you might need to handle it differently
            // For simplicity, assuming lives is a property of User entity
            $user->getLives()->setCity($data['lives']['city']); // Assuming there's a 'city' field in 'lives'
            $user->setRoles($data['roles']);
            
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

            $responseData = [
                'message' => 'Registration successful',
            ];

            return new JsonResponse($responseData, Response::HTTP_CREATED);
        }

        $formErrors = $this->getFormErrors($form);

        return new JsonResponse(['errors' => $formErrors], Response::HTTP_BAD_REQUEST);
    }

    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }
        return $errors;
    }
    }
















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
