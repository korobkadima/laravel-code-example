<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use App\Entities\PhotoStore;
use App\Entities\User;
use App\Entities\Photo;

class PhotoStoreRepository extends Repository implements RepositoryContract
{
    /**
     * @var PhotoStore placeholder
     */
    protected $entity;

    /**
     * @param PhotoStore $entity
     */
    public function __construct(PhotoStore $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Return Entity's raw query builder
     *
     * @return PhotoStore
     */
    public function entity()
    {
        return $this->entity;
    }

    /**
     * Check are the user buy this photo by credits
     * 
     * @param User $user
     * @param Photo $photo
     * @return PhotoStore
     */
    public function findByPhoto(User $user, Photo $photo)
    {
       return $this->entity()
            ->where('user_id',  $user->id)
            ->where('photo_id', $photo->id)
            ->first();
    }

    /**
     * Create new Photo buy by user
     *
     * @param Photo $photo
     * @param User $user
     * @return PhotoStore
     */
    public function setNewPhoto(User $user, Photo $photo)
    {
        return $this->entity
            ->create([
                'user_id'  => $user->id,
                'photo_id' => $photo->id,
            ]);
    }
}