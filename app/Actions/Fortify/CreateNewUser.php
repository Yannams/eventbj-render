<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;



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
            'num_user' => ['required', 'string', 'max:30'],
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
        
        if(isset($input['profil_user']))
        {

            $image = $input['profil_user'];
            $destinationPath = public_path('UsersProfiles'); // Le chemin de destination où vous souhaitez déplacer le fichier

            // Assurez-vous que le répertoire de destination existe
            if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true);
            }
    
            $uniqueFileName = uniqid() . '_' . $image->getClientOriginalName();

            $image->move($destinationPath, $uniqueFileName);
            
            $profilePhotoPath = 'UsersProfiles/'.$uniqueFileName;

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
