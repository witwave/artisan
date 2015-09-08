<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RHelper;

/* Columns
 *
 * id               (increment)
 * name             (string, 255)
 * short_description (string, 255)
 * long_description (text, nullable)
 * active           (boolean, default true)
 * options          (text, nullable)
 * category_id      (integer, unsigned)
 * created_at       (dateTime)
 * updated_at       (dateTime)
 *
 */

class Portfolio extends Model
{
    protected $table = 'portfolios';
    
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
