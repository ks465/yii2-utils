#Setting Class
Contains all the semi-static values for the applications.
Use internal SQLite or something for hibernating settings.

Add cache for settings
Cache APIs

All cache components have the same base class yii\caching\Cache and thus support the following APIs:

    get(): retrieves a data item from cache with a specified key. A false value will be returned if the data item is not found in the cache or is expired/invalidated.
    set(): stores a data item identified by a key in cache.
    add(): stores a data item identified by a key in cache if the key is not found in the cache.
    getOrSet(): retrieves a data item from cache with a specified key or executes passed callback, stores return of the callback in a cache by a key and returns that data.
    multiGet(): retrieves multiple data items from cache with the specified keys.
    multiSet(): stores multiple data items in cache. Each item is identified by a key.
    multiAdd(): stores multiple data items in cache. Each item is identified by a key. If a key already exists in the cache, the data item will be skipped.
    exists(): returns a value indicating whether the specified key is found in the cache.
    delete(): removes a data item identified by a key from the cache.
    flush(): removes all data items from the cache.



    // Create a dependency on the modification time of file example.txt.
    $dependency = new \yii\caching\FileDependency(['fileName' => 'example.txt']);
    
    // The data will expire in 30 seconds.
    // It may also be invalidated earlier if example.txt is modified.
    $cache->set($key, $data, 30, $dependency);
    
    // The cache will check if the data has expired.
    // It will also check if the associated dependency was changed.
    // It will return false if any of these conditions are met.
    $data = $cache->get($key);
    
    Below is a summary of the available cache dependencies:
    
        yii\caching\ChainedDependency: the dependency is changed if any of the dependencies on the chain is changed.
        yii\caching\DbDependency: the dependency is changed if the query result of the specified SQL statement is changed.
        yii\caching\ExpressionDependency: the dependency is changed if the result of the specified PHP expression is changed.
        yii\caching\FileDependency: the dependency is changed if the file's last modification time is changed.
        yii\caching\TagDependency: associates a cached data item with one or multiple tags. You may invalidate the cached data items with the specified tag(s) by calling yii\caching\TagDependency::invalidate().
    
        Note: Avoid using exists() method along with dependencies. It does not check whether the dependency associated with the cached data, if there is any, has changed. So a call to get() may return false while exists() returns true.
