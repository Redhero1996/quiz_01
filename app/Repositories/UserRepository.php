<?php 

namespace App\Repositories;

use App\User;
use Image;
use Storage;

class UserRepository extends Repository {
    function model()
    {
        return new User();
    }

    public function handleUploadImage($boolean = false, $image, $user = null) {
        if ($boolean == true) {
            if (!is_null($image)) {
                $avatar = $image;
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($avatar)->resize(200, 200)->save($location);

                return $this->avatar = $filename;    
            } else {
                return $this->avatar = 'avatar-two.png';
            }
        } else {
            if (!is_null($image)) {
                $avatar = $image;
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($avatar)->resize(200, 200)->save($location);
                if (isset($user)) {
                    // get the old photo
                    $oldImage = $user->avatar;
                    // update the database
                    $user->avatar = $filename;
                    // delete the old photo
                    Storage::delete($oldImage);

                    return $this->avatar = $filename;
                } else {
                    return $this->avatar = $user->avatar;
                }  
            }
        }
    }
}
