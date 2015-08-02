# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Sort fields by order, asc or desc

# Introduction #

This is a very useful feature. Before and after the field titles will appear to arrows showing the possibility to sort the fields order 'up' or 'down'

You can also disable field sorting by doing this:

```
$grid->updateColumn('field',array('order'=>true));
$grid->updateColumn('field',array('order'=>false));
```

More information about fields options [here](GridOptions.md)