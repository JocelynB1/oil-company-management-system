<?php

namespace App;
Use App\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function roles(){
        return $this->belongsToMany('Role','users_roles');
    }

    
    /**
     * Find out if user has a specific role
     *
     * $return boolean
     */
    public function hasRole($check)
    {
        return in_array($check, array_pluck($this->roles->toArray(), 'name'));
    }

    /**
     * Get key in array with corresponding value
     *
     * @return int
     */
    private function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key;
            }
        }

        throw new UnexpectedValueException;
    }


      /**
      * Add roles to user 
      */
     public function makeEmployee($title)
     {
         $assigned_roles = array();
 
         $roles = array_pluck(Role::all()->toArray(), 'Description');
 
         switch ($title) {
             case 'Administrator'||'1':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Administrator');
                 break;
             case 'General_manager'||'2':
                 $assigned_roles[] = $this->getIdInArray($roles, 'General_manager');
                 break;
            case 'Stock_manager'||'3':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Stock_manager');
                 break;
            case 'Human_resources_manager'||'3':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Human_resources_manager');
                 break;
            case 'Accountant'||'4':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Accountant');
                 break;
            case 'Rate_manager'||'5':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Rate_manager');
                 break;
            case 'Output_manager'||'6':
                 $assigned_roles[] = $this->getIdInArray($roles, 'Output_manager');
                 break;
            default:
                 throw new \Exception("Role does not exist");
         }
 
         $this->roles()->attach($assigned_roles);
     }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
