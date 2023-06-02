<?php

namespace JoeDixon\Translation;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Language extends Model
{
    use QueryCacheable;

   // protected static $flushCacheOnUpdate = true;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('translation.database.connection');
        $this->table = config('translation.database.languages_table');
    }

    protected function cacheForValue()
    {
        return config('translation.cache_options.ttl');
    }

    protected function cacheTagsValue()
    {
        return config('translation.cache_options.tags');
    }

    protected function cachePrefixValue()
    {
        return  config('translation.cache_options.prefix');
    }

    protected function cacheDriverValue()
    {
        return config('translation.cache_options.driver');
    }
    
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function updateOrCreate(array $options = [])
    {
        $result = parent::updateOrCreate($options);

        if ($result) {
            $this->flushCache();
        }

        return $result;
    }
}
