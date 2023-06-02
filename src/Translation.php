<?php

namespace JoeDixon\Translation;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Translation extends Model
{
    use QueryCacheable;

   // protected static $flushCacheOnUpdate = true;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('translation.database.connection');
        $this->table = config('translation.database.translations_table');
        logger("STARTED");
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
    
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public static function getGroupsForLanguage($language)
    {
        return static::whereHas('language', function ($q) use ($language) {
            $q->where('language', $language);
        })->whereNotNull('group')
            ->where('group', 'not like', '%single')
            ->select('group')
            ->distinct()
            ->get();
    }

    public function updateOrCreate(array $options = [])
    {
        logger("SAVE CALLED");
        $result = parent::updateOrCreate($options);

        if ($result) {
            $this->flushCache();
        }

        return $result;
    }
}
