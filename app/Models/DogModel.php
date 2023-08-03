<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * DogModel
 *
 * @package App\Models
 * @author Lee Benedict Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogModel extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'dog';

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'url', 'created_at', 'updated_at'];

    /**
     * fetchDog
     * @since 2023.08.02
     * @return array
     */
    public function fetchDog() : array
    {
        return self::orderBy('created_at', 'desc')->get()->toArray();
    }

    /**
     * fetchDogById
     * @param int $iId
     * @since 2023.08.02
     * @return array
     */
    public function fetchDogById(int $iId) : array
    {
        return self::find($iId)->toArray();
    }

    /**
     * storeDog
     * @since 2023.08.02
     * @param array $aFormData
     * @return bool
     */
    public function storeDog(array $aFormData) : bool
    {
        return self::fill($aFormData)->save();
    }

    /**
     * updateDog
     * @since 2023.08.02
     * @param int $iId
     * @param array $aFormData
     * @return bool
     */
    public function updateDog(int $iId, array $aFormData) : bool
    {
        return self::where('id', $iId)->update($aFormData);
    }

    /**
     * deleteDog
     * @since 2023.08.02
     * @param int $iId
     * @return int
     */
    public function deleteDog(int $iId) : int
    {
        return self::destroy($iId);
    }
}
