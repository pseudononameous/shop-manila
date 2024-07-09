<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\Mail;

class BaseController extends Controller
{
    
    /**
     * Create unique slugs
     * @param  string $name  slug
     * @param  string $model App\Model format
     * @return string
     */
    public function makeSlug($name, $model) {
        
        $m = App::make($model);
        
        $slug = str_slug($name);
        
        $count = $m->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        
        $s = $count ? "{$slug}-{$count}" : $slug;
        
        return $s;
    }


    /**
     * Send email using Mail facade
     * @param  string $view    layout file
     * @param  array $data
     * @param  string $to
     * @param  string $subject
     */
    public function send($view, $data, $to, $subject)
    {

        Mail::send($view, $data, function ($message) use ($data, $to, $subject) {

            $message->to($to)->subject($subject);
        });
    }

    public function makeRelatedItemCode($itemName, $storeId) {

    }

}
