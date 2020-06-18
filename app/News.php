<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon;

class News extends Model
{
    protected $table = 'news';


     protected $appends = ['news_picture','create_date'];

     public function getNewsPictureAttribute()
        {
            if ($this->attributes['image_url']) {

                return $this->attributes['image_url'];
                
            } else {
                return url('images/no-image-default.jpg');
            }
        }

   
      public function getCreateDateAttribute()
        {
            if ($this->attributes['created_at']) {

               $createDate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $this->attributes['created_at'])->format('d M Y h:i a');

                return  $createDate;
                
            } 
         }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function ScopeFilteredNews($q) 
    {

    	$user = Auth::user();
        if($user->profile && $user->profile->session ) {
             $userSession =  $user->profile->session_id;
            }
            else {
            	 $userSession = null;
        }
        if($user->profile && $user->profile->department ) {

            $userDepartment =  $user->profile->department_id;
            }  

   			 else {
            	 $userDepartment = null;
            }    
   	    if($user->profile && $user->profile->institution ) {

        $userInstitute =   $user->profile->institution_id;
         }

         else {
            	 $userInstitute = null;
            }
        
         
         if($userSession) {

            $q->where('session_id',  $userSession)
              ->orWhereNull('department_id');

          }

          else 
          {
              $q->whereNull('department_id');
          }

         if($userDepartment) {

            $q->where('department_id', $userDepartment)
              ->orWhereNull('department_id');

            }

          else 
          {
              $q->whereNull('department_id');
          }

          if($userInstitute) {

            $q->where('institution_id', $userInstitute)
               ->orWhereNull('institution_id');
            }

          else 
            {
              $q->whereNull('institution_id');
           }

           return $q;
    }

     public function activities()
    {
        return $this->morphMany('App\UserActivity','relatable');
    }

}
