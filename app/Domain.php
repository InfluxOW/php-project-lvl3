<?php

namespace App;

use App\Enums\DomainState;
use Illuminate\Database\Eloquent\Model;
use SM\Factory\Factory as SMFactory;
use SM\SMException;

/**
 * App\Domain
 *
 * @property int $id
 * @property int|null $content_length
 * @property int|null $response_code
 * @property string|null $body
 * @property string $name
 * @property string|null $h1
 * @property string|null $description
 * @property string|null $keywords
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereContentLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereResponseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{
    protected $fillable = ['name', 'content_length', 'response_code', 'body', 'h1', 'description', 'keywords', 'state'];
    protected $hidden = ['body'];
    protected $attributes = [
        'state' => DomainState::WAITING,
    ];

    /**
     * @throws SMException
     */
    public function stateMachine()
    {
        $factory = new SMFactory(config('state-machine'));

        return $factory->get($this, self::class);
    }
}
