<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_no',
        'employee_id',
        'password',
        'is_active',
        'status',
        'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = array('fullNameWithId');


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userCollection(){
        return $this->hasMany(AmountCollection::class,'user_id','id');
    }

    public function childUser(){
        return $this->hasMany(User::class,'parent_id','id')->where('parent_id','!=',0);
    }

    public function getFullNameWithIdAttribute(){
         return ucfirst($this->name). ' (' . ucfirst($this->employee_id) . ')';
    }

    public static function parentUser(){
        $allcategories = User::get();

         $parentUsers = $allcategories->where('parent_id',0);
         return $parentUsers;
    }

    public static function allTree($data){
        $allcategories = User::get();

         $rootCategories = $allcategories->where('parent_id',0);

        self::formatTree($rootCategories,$allcategories);

        return $rootCategories;
    }

    public static function tree($data){
        $allcategories = User::get();

         $rootCategories = $allcategories->where('id',$data);

        self::formatTree($rootCategories,$allcategories);

        return $rootCategories;
    }

    private static function formatTree($categories,$allcategories){
        foreach ($categories as $key => $category) {

            $category->children =   $allcategories->where('parent_id',$category->id)->values();

            if($category->children->isNotEmpty()){
                self::formatTree($category->children,$allcategories);
            }
        }
    }

    public static function children($parent_id)
    {
        $children = DB::table('user_children as uc')
            ->select('u.name as user_name', 'u.employee_id as employee_id', 'u.id as user_id')
            ->join('users as u', 'u.id', '=', 'uc.child_id')
            ->where('uc.parent_id', $parent_id)
            ->get()
            ->toArray();
    
        $childrenWithDescendants = self::getChildHierarchy($children);
    
        return $childrenWithDescendants;
    }
    
    public static function getChildHierarchy($children)
    {
        $childrenArray = [];
        
        foreach ($children as $child) {
            $childId = $child->user_id;

            $grandchildren = DB::table('user_children as uc')
                ->select('u.name as user_name', 'u.employee_id as employee_id', 'u.id as user_id')
                ->join('users as u', 'u.id', '=', 'uc.child_id')
                ->where('uc.parent_id', $childId)
                ->get()
                ->toArray();

            $childHierarchy = self::getChildHierarchy($grandchildren);
            
            $childrenArray[] = [
                'user_name' => $child->user_name,
                'employee_id' => $child->employee_id,
                'user_id' => $child->user_id,
                'children' => $childHierarchy
            ];
        }
    
        return $childrenArray;
    }

     public function parents()
     {
         return $this->hasMany(UserChild::class, 'child_id');
     }

    
}
