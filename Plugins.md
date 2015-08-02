# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Format content like date, numbers, currency, etc, etc
# Details #

Format is a way to format content using plugins.

This is special useful to format date, time, bool, currency, and any other content.

You must first register you format whiting the grid:

```
$grid->addFormatterDir('My/Grid/Formatter','My_Grid_Formatter');   
```

After this you can start using you format plugins.

```
$grid->updateColumn('amount',array('format'=>"currency"));   
```

The ZFDatagrid will look for a class called My\_Grid\_Formatter\_Currency and for a method called format().

The field value will be passed to the format method.

Alternatively you can pass optional params to the format.

```
$grid->updateColumn('amount', array('format'=> array('currency',array('arg'=>1, 'arg'=>'{{amount}}'))));   
```

_Note_ The second argument will be converted in the value for the amount field. You can use {{field}} for any field


## Field placeholder tags (ex. {{field}}) ##

The value of any field can be accessed in arguments to decorators, format plugins, callbacks, etc. via placeholders in the following format: {{field}}

Note that after a field has been modified by a format plugin, the {{field}} placeholder will be replaced by the modified content, not the original field value.

You can access the original, unmodified field value using placeholders in the following format: {{=field}}

To enable access to unmodified field values in this way, you must set "enableUnmodifiedFieldPlaceholders" option to true in your grid config. Ex. in your grid .ini file:

grid.enableUnmodifiedFieldPlaceholders = 1;