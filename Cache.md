# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Using cache

# Introduction #

When performing intensive queries or using sources as files, is a good idea to use cache for performance improvement.

## How? ##

It's really easy.

```
$grid->setCache(array('use'=>array('form'=>'true|false', 'db'=>'true|false'), 'instance'=>Zend_Cache $cache,'tag'=>'my_tag'));
```

## And affects ##

When using cache all of your queries will be put on cache and they will use the tag provided.

After performing CRUD operations all the cache based on the tag will be erased.