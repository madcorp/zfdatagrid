# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Multiple Instances

# Introduction #

When you need to present several table in one page, and in every table you need to sort, filters, or any other action, usually they affect the others grids in the page.

To avoid that, when instantiating a grid you can pass it an id, that will serve as reference for actions taken on that table.

```
$grid = Bvb_Grid::factory('Bvb_Grid_Deploy_Table',Zend_Config $config, 'my_id');
```

$this id will prefix all params used on that grid.

Even CRUD operations can be performed with multiple grids per page