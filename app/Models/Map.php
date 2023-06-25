<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Map extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'maps';

    protected $fillable = ['name','map'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'map' => AsCollection::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
	
}
