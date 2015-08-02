# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How to add extra Rows

# Introduction #

You may need to add info in some part of the grid.

This can be achieved by using the Bvb\_Grid\_ExtraRows class

## Example ##

```
$rows = new Bvb_Grid_Extra_Rows();
$rows->addRow('beforeHeader',array(
                '', // empty field
                array( 'colspan' => 1, 'class' => 'myclass', 'content'=>'my content'),
                array('colspan' => 2, 'class' => 'myotherclass','content'=>'some '),
                array('colspan' => 1, 'class' => 'myclass', 'content'=>'flowers:) '),
            ));
$grid->addExtraRows($rows);
```


The first argument is the position in the grid.

## Available positions ##

  * beforeHeader
  * afterHeader
  * beforeTitles
  * afterTitles
  * beforeFilters
  * afterFilters
  * beforeSqlExpTable
  * afterSqlExpTable
  * beforePagination
  * afterPagination


**Note:** You don't need to worry about colspan from extra fields. It's auto calculated. And you only use the colspan option  if the number of columns you want differ from the number in the grid

## Available Options for each field ##

  * colspan => the colspan to be applied. Please see the note above
  * class => A CSS class to be applied
  * content => The content to be displayed