<?php

namespace App\Services;

use App\Entities\User;
use App\Entities\Photo;
use App\Repositories\PhotoStoreRepository;

class PhotoStoreService
{
    /**
     * @var PhotoStoreRepository
     */
    protected $repository;

    /**
     * @param PhotoStoreRepository $repository
     */
    public function __construct(PhotoStoreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check are the user buy this photo by credits
     *
     * @param User $user
     * @param Photo $photo
     * @return PhotoStoreRepository|null
     */
    public function findByPhoto(User $user, Photo $photo)
    {
        return $this->repository->findByPhoto($user, $photo);
    }

    /**
     * Set the store new photo by user
     *
     * @param User $user
     * @param Photo $photo
     * @return PhotoStoreRepository|null
     */
    public function setNewPhoto(User $user, Photo $photo)
    {
        return $this->repository->setNewPhoto($user, $photo);
    }

}