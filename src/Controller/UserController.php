<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
	/**
	 * @Route("/users", name="users")
	 * @param UserService $userService
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function Users(UserService $userService)
    {
	    $userList = $userService->getUsers();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
	        'user_list' => $userList
        ]);
    }
    
    /**
     * @Route("/user/new", name="user_new")
     */
    public function UserNew()
    {
        return $this->render('user/form.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
	
	/**
	 * @Route("/user/add", name="user_add")
	 * @param UserService $userService
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
    public function UserAdd(UserService $userService, Request $request)
    {
	    $userService->createUser($request->get('data'));
	    return $this->redirectToRoute('users');
    }
	
	/**
	 * @Route("/user/edit/{id}", name="user_edit")
	 * @param UserService $userService
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
    public function UserEdit(UserService $userService, $id)
    {
    	$user = $userService->getUserById($id);
        return $this->render('user/form.html.twig', [
            'controller_name' => 'UserController',
	        'user' => $user
        ]);
    }
	
	/**
	 * @Route("/user/update", name="user_update")
	 * @param UserService $userService
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
    public function UserUpdate(UserService $userService, Request $request)
    {
	    $userService->updateUser($request->get('data'));
	    return $this->redirectToRoute('users');
    }
	
	/**
	 * @Route("/user/remove/{id}", name="user_remove")
	 * @param UserService $userService
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
    public function UserRemove(UserService $userService, $id)
    {
	    $userService->removeUser($id);
	    return $this->redirectToRoute('users');
    }
}
