<?php
	/**
	 * Created by PhpStorm.
	 * User: denissok
	 * Date: 2019-03-07
	 * Time: 21:28
	 */
	
	namespace App\Services;
	
	
	use App\Entity\User;
	use Doctrine\ORM\EntityManager;
	
	class UserService
	{
		/**
		 * @var EntityManager
		 */
		private $em;
		
		public function __construct(EntityManager $em)
		{
			$this->em = $em;
		}
		
		/**
		 * @return array|object[]
		 */
		public function getUsers()
		{
			return $this->em->getRepository(User::class)->findAll();
		}
		
		/**
		 * @param int $id
		 * @return User
		 * @throws \Exception
		 */
		public function getUserById(int $id): User
		{
			$user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
			if (!$user instanceof User) {
				throw new \Exception('User not found');
			}
			return $user;
		}
		
		/**
		 * @param $data
		 * @return User
		 * @throws \Doctrine\ORM\ORMException
		 * @throws \Doctrine\ORM\OptimisticLockException
		 */
		public function updateUser($data): User
		{
			/** @var User $user */
			$user = $this->getUserById($data['id']);
			if (!$this->_validationFrom($data)) {
				throw new \Exception('form not valid');
			}
			$user->setLastname($data['lastname']);
			$user->setFirstname($data['firstname']);
			$user->setPhone($data['phone']);
			$this->em->flush();
			return $user;
		}
		
		/**
		 * @param $data
		 * @return User
		 * @throws \Doctrine\ORM\ORMException
		 * @throws \Doctrine\ORM\OptimisticLockException
		 */
		public function createUser($data): User
		{
			$user = new User();
			if (!$this->_validationFrom($data)) {
				throw new \Exception('form not valid');
			}
			$user->setLastname($data['lastname']);
			$user->setFirstname($data['firstname']);
			$user->setPhone($data['phone']);
			$date = new \DateTime();
			$user->setCreated($date->getTimestamp());
			$this->em->persist($user);
			$this->em->flush();
			return $user;
		}
		
		/**
		 * @param int $id
		 * @throws \Doctrine\ORM\ORMException
		 * @throws \Doctrine\ORM\OptimisticLockException
		 */
		public function removeUser(int $id)
		{
			/** @var User $user */
			$user = $this->getUserById($id);
			$this->em->remove($user);
			$this->em->flush();
		}
		
		/**
		 * @param $data
		 * @return bool
		 */
		private function _validationFrom($data): bool
		{
			if (!isset($data['lastname']) || $data['lastname'] == '') {
				return false;
			}
			
			if (!isset($data['firstname']) || $data['firstname'] == '') {
				return false;
			}
			
			return true;
		}
	}