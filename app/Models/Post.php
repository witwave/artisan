<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RHelper;

/* Columns
 *
 * id           (increment)
 * title        (string, 255)
 * slug         (string, 255)
 * content      (text)
 * featured     (boolean, default true)
 * private      (boolean, default true)
 * category_id  (integer, unsigned)
 * created_at   (dateTime)
 * updated_at   (dateTime)
 *
 */

class Post extends Model
{
    protected $table = 'posts';
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translatable');
    }
    
    public function delete()
    {
        // Delete all images
        foreach ($this->images as $image) {
            $image->delete();
        }
        
        // Delete all translations
        $this->translations()->delete();
        
        // Delete asset images folder
        $upload_dir = \Config::get('image.upload_dir');
        $deleteFolder = new Image;
        $url_path = RHelper::joinPaths($upload_dir, $this->table, $this->id);
        $deleteFolder->deleteFiles($url_path);
        
        return parent::delete();
    }
}
