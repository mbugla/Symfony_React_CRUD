<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var UserRepository */
    private $userRepository;

    /**
     * UsersController constructor.
     * @param ValidatorInterface $validator
     * @param UserRepositoryInterface $userRepository
     */
    const USERS_PER_PAGE = 20;

    public function __construct(ValidatorInterface $validator, UserRepositoryInterface $userRepository)
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    public function getUsersAction(Request $request): Response
    {
        $page = $request->get('page', 1);

        $offset = ($page - 1) * self::USERS_PER_PAGE + 1;
        $users = $this->userRepository->getAll(self::USERS_PER_PAGE, $offset);

        return new JsonResponse($users);
    }


    public function getUserAction($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user);
    }

    public function postUsersAction(Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true);
        $userDto = UserDto::createFromData($requestBody);

        $errors = $this->validator->validate($userDto);

        if (count($errors) > 0) {

            return $this->errorResponse($errors);
        }

        $user = User::createFromDto($userDto);
        $this->userRepository->store($user);

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    public function putUserAction(Request $request, $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $requestBody = json_decode($request->getContent(), true);
        $userDto = UserDto::createFromUser($user);


        $userDto->updateFromArray($requestBody);

        $errors = $this->validator->validate($userDto);

        if (count($errors) > 0) {

            return $this->errorResponse($errors);
        }

        $user->updateFromDto($userDto);

        $this->userRepository->store($user);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    public function deleteUserAction($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->userRepository->delete($user);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function optionsUsersAction()
    {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE');

        return $response;
    }

    /**
     * @param $errors
     * @return JsonResponse
     */
    protected function errorResponse(ConstraintViolationListInterface $errors): JsonResponse
    {
        $errList = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $errList[] = [
                'value' => $error->getInvalidValue(),
                'property' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }

        return new JsonResponse($errList, Response::HTTP_BAD_REQUEST);
    }

}
