<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'num_user' => ['required', 'string', 'max:30','unique:users,num_user'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'profil_user'=>['nullable', 'image', 'max:1024'],
            'password' => $this->passwordRules(),
        ])->validate();
        $profil_user_cropped=$input['profil_user_cropped'];
        if(isset($input['profil_user_cropped']))
        {

            list($type, $profil_user_cropped) = explode(';', $profil_user_cropped);
            list(, $profil_user_cropped)      = explode(',', $profil_user_cropped);
            $profil_user_cropped = base64_decode($profil_user_cropped);
            $manager = new ImageManager(new Driver());
    
            // Décodage et création de l'image
            $image = $manager->read($profil_user_cropped) ;
        
            // Redimensionnement proportionnel avec une largeur maximale de 800px sans agrandir l'image
            $image = $image->scaleDown(width: 800);
        
            // Encodage de l'image en JPEG avec une qualité de 70%
            $encoded = $image->toJpeg(95); 
               
            $destinationPath=public_path('image_evenement');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.str_replace(' ','_',$input['name']).'.jpg';
            $encoded->save($destinationPath.'/'.$fileName);
            $profilePhotoPath='image_evenement/' . $fileName;
            
        } 
        else
        {
           $profilePhotoPath='UsersProfiles/WhatsApp Image 2024-07-20 à 10.51.52_ddc6fb0b.jpg';
        }
    
        $user= User::create([
            'name' => $input['name'],
            'num_user'=>$input['num_user'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'profil_user'=>$profilePhotoPath,
        ]);

        $user->assignRole('User');

        return $user;


        
    }
}
