<?php namespace Dimsog\Blog\Models;

use Illuminate\Database\Eloquent\Collection;
use Model;
use System\Models\File;

/**
 * Post Model
 */
class Post extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dimsog_blog_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'tags' => [PostTag::class]
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'category' => Category::class
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'image' => [File::class, 'delete' => true]
    ];
    public $attachMany = [];


    public function getCategoryIdOptions(): array
    {
        return Category::lists('name', 'id');
    }

    public function getTypeIdOptions(): array
    {
        return PostType::lists('name', 'id');
    }

    public function updateViews(): void
    {
        static::where('id', $this->id)
            ->increment('views');
    }

    public static function findActiveBySlug(string $slug): ?static
    {
        return static::where('slug', $slug)
            ->where('active', 1)
            ->first();
    }
}
