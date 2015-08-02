# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How to define SQL expressions


# Introduction #

If you are displaying data like annual results, or other similar, you may need to add some function to calculate the grand total, average, or something else.

Defining SQL expressions will add an extra row at the bottom of the table with the expressions you defined:

## Examples ##
```
$this->setSqlExp(array('credit'=>array('functions'=>array('COUNT'),'value'=>'credit')));
//If no value option is defined the field name will be used.
```

This will count all records from the credit field

```
$this->setSqlExp( array('credit'=>array('functions'=>array('AVG'),'value'=>'credit')));
```

This will make the average from the credit field

### More Options ###

You can also apply a format to the field and add a CSS class

```
$this->setSqlExp( array('credit'=>array('functions'=>array('AVG'),'value'=>'credit','format'=>'currency','class'=>'annual_results')));
//If this field is already using a format from the grid the same format will be applied here. If you don't want that
//please define the format option as an empty string
$this->setSqlExp( array('credit'=>array('functions'=>array('AVG'),'value'=>'credit','format'=>'','class'=>'annual_results')));
```

## Other sources ##
If you are using other source then a DB, you can also use "SQL" expressions.

At this moment six are supported: (min, max, avg, sum, product, count)