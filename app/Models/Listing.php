<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Listing extends Model{

    use HasFactory;

    //use basetable 'laragigs';
    //protected $table = 'listings'; only use this when the name of the table different

    protected $fillable = [
        'title', 'company', 'email', 'website', 'location', 'tags', 'description', 'logo','user_id'
    ];
    // avoid the use of this by using the Model::unguard(); in the  appservice provider file



    public function scopeFilter($query, array $filters){
        //dd($filters['tag']);
        if($filters['tag'] ?? false){
            $query->where('tags', 'like','%'. request('tag') .'%');
        }

        if($filters['search'] ?? false){
            $query->where('title', 'like','%'. request('search') .'%')
            ->orWhere('description', 'like','%'. request('search') .'%')
            ->orWhere('tags', 'like','%'. request('search') .'%')
            ->orWhere('location', 'like','%'. request('search') .'%')
            ->orWhere('company', 'like','%'. request('search') .'%');
        }

        
    }
        # Relationship to user
       public function user(){
        return $this->belongsTo(User::class);
      }



}