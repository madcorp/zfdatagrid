# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary All the options available for fields customization



# Introduction #
we can't even imagine the things we want to display or how do we want to display.
Fortunately there is a way to help you.

Below are a list of options that can be applied to any Bvb\_Grid\_Source`_``*`
# Available Options #


## callback ##
A callback to be applied to the field

Usage:
```
$grid->updateColumn('field',array('callback'=>array('function'=>'my_function','params'=>array('param1','{{field}}'))));
```



## class ##
A CSS class to be used

Usage:
```
$grid->updateColumn('field',array('class'=>'my_css_class'));
```


## colspan ##
number of columns that the field spans in display. If == '**', the full table width is used. If < 0, the table width less this value is used (so if the table has 5 columns, and a column had colspan = -1, it would be rendered with colspan=4.) Anything else is passed straight to the markup.`*`**


## decorator ##
Use this options to add you own text or html to the field. As the name indicates, it decorates the field.

Usage:
```
$grid->updateColumn('field',array('decorator'=>'This field value is: {{field}}'));
```

Please that you can use {{FIELD\_NAME}} to insert the expected field value

### Special Decorators ###
#### Operations ####
You can use the result of a callback, helper and format option in your decorator.

Use one of those options {{format}} {{callback}} {{helper}}.

_Note:_ These special tags will only be available when you make use of the correspondent action

#### Crud Links ####
You can also make use of these tags {{addUrl}}  {{editUrl}}  {{deleteUrl}} to create the respective links to the operation.

_Note:_ These tags will only work when you have permissions to perform the respective action

## escape ##
Escape the field or not, and how...

Usage:
```
//Won't escape the field
$grid->updateColumn('field',array('escape'=>false));

//Will escape the field based on default escape
$grid->updateColumn('field',array('escape'=>true));

//Will escape the field based on default escape
$grid->updateColumn('field',array('escape'=>'my_callback_function'));
```


## format ##
Format is a simple way for you to format content (date, time, currency, bool, etc).
Check this page for more info on [Formatters](Formatters.md)

Usage:
```
$grid->updateColumn('field',array('format'=>'number'));
$grid->updateColumn('field',array('format'=>array('number',array('param1','param2'))));
```


## hidden ##
This option is similar to the _remove_ option. But while the _remove_ option is made by the Bvb\_Grid\_Data class, the class responsible for hiding the column is the deploy class.

**Possible values**: true|false
Usage:
```
$grid->updateColumn('field',array('hidden'=>true));
```


## helper ##
This is a View Helper.

Like formText, FormRadio, Url, etc, etc.

Usage:
```
$grid->updateColumn('field',array('helper'=>array('name'=>'formInput','params'=>array('name','value'))));
//Please refer to the view helper you want to use for possible params
```


## hRow ##
This is very useful for you to group results. Imagine you have a list of countries and want to group them by continent like here: http://zfdatagrid.com/grid/default/site/hrow

_Notice_: You can only use this option once per grid. The last defined will prevail over the others.

Usage (this is case sensitive. hrow != hRow):
```
$grid->updateColumn('field',array('hRow'=>true));
```


## newrow ##
If != false, cell starts on a new row. May be an associative array('class'=>$class\_for\_the\_new\_row, 'style'=>$style\_for\_the\_new\_row) `*`

## order ##
**Possible Values**: true|false
Use this option if you don't want to give the user the possibility to order this field. One reason may be the use of an expression the build field

Usage:
```
$grid->updateColumn('field',array('order'=>true));
```


## orderField ##
This is useful if you are using decorators or any other custom content. Instead ordering by the field that corresponds to that column, the order will be made by other specified.


Usage:
```
$grid->updateColumn('field',array('orderField'=>'field2'));
```


## position ##
Use this option to specify the position where a column will appear

**Possible Values:** first, last, next, number (not the word. 1, 2,3 ,4 )

Usage:
```
$grid->updateColumn('field',array('position'=>'last'));
$grid->updateColumn('field',array('position'=>'first'));
$grid->updateColumn('field',array('position'=>'2'));
$grid->updateColumn('field',array('position'=>'3'));
```


## remove ##
This option is used to remove the field from the grid, but not from the query. You may want to use the value of the _id_ field in a decorator, but not to show the id in the grid.

**Possible values**: true|false
Usage:
```
$grid->updateColumn('field',array('remove'=>true));
```

## rowspan ##
Works just like rowspan in HTML.`*`

## search ##
How the search will be performed, or if it will be performed.

To not allow search on a particularly field:
Usage:
```
$grid->updateColumn('field',array('search'=>false));
```

To use full-text search:
Simple usage:
```
$grid->updateColumn('field',array('search'=>array('fulltext'=>true)));
```

Specify indexes (if no index is specified the field name will be used):
```
$grid->updateColumn('field',array('search'=>array('fulltext'=>true,'indexes'=>'field,field2')));
```

Specify in boolean mode (default):
```
$grid->updateColumn('field',array('search'=>array('fulltext'=>true,'extra'=>'boolean')));
```

Specify with query expansion:
```
$grid->updateColumn('field',array('search'=>array('fulltext'=>true,'extra'=>'queryExpansion')));
```


## searchType ##
The search operand that will be used.

Available operators:
| `sqlExp` |
|:---------|
| `like`   |
| `llike`  |
| rlike    |
| `equal`, `=` |
| `>=`     |
| `>`      |
| `!=`, `<>` |
| `<=`     |
| `<`      |
| `r:` (will apply a regexp) |



Usage:
```
$grid->updateColumn('field',array('searchType'=>'='));
$grid->updateColumn('field',array('searchType'=>'>='));
$grid->updateColumn('field',array('searchType'=>'llike'));
```

## searchSqlExp ##

Use this to perform a sql expression.

The {{value}} tag will be quoted and replaced with user's input value
```
$grid->updateColumn('Name',array('searchType'=>'sqlExp','searchSqlExp'=>'Name !={{value}} '));
```


## searchTypeFixed ##
The user has the ability to alter the search operand by using one of the available options check: [Faq#Supported\_search\_operators](http://code.google.com/p/zfdatagrid/wiki/Faq#Supported_search_operators)

If you don't want to give the user this option, set searchTypeFixed to false.

**Possible values**: true|false
Usage:
```
$grid->updateColumn('field',array('searchTypeFixed'=>true));
```


## style ##
A CSS style to be used

Usage:
```
$grid->updateColumn('field',array('style'=>'text-decoration:underline'));
```


## title ##
This is the title for the column the user will see.

Usage:
```
$grid->updateColumn('user_email',array('title'=>'Email Address'));
```

## translate ##
Whether to translate fields values. Useful for locale data.

Usage:
```
$grid->updateColumn('country',array('translate'=>true));
```

`*` Table only