# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Show a detailed page with more fields

# Introduction #

If you have a lot of fields to show, they probably will take more space than the available on screen.

You can set the fields that appear on the grid list and fields that appear on a detailed view.

|<font color='red'><b>Attention:</b></font> This is optional. If you don't set nothing, all fields will be showed on the grid page. |
|:----------------------------------------------------------------------------------------------------------------------------------|

To define the fields that appear in the grid view:

```
$grid->setGridColumns(array);
//$grid->setGridColumns('name','address','age');
```

And to define which will appear in the detailed view:

```
$grid->setDetailColumns(array);
//$grid->setDetailColumns('name','address','age','country');
```

If you want to show all your fields on the detailed view, leave the method empty:

```
$grid->setDetailColumns();
```

The code above will show all fields available.