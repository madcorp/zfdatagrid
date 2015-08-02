# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How to use formatters


# Introduction #

Formatters are useful to format field content such number, currency, date, etc, etc.

You can create your own formatters and then use them in the grid.

## Code Sample ##
```
class My_Formatter_Currency implements Bvb_Grid_Formatter_Interface
{

    function __construct($options)
    {
        
    } 

    function format($value)
    {
        if(!Zend_Registry::isRegistered('Zend_Locale'))
        {
            return $value;
        }

        $currency = new Zend_Currency(Zend_Registry::get('Zend_Locale'));
        return $currency->toCurrency($value);
    }

}
```

You must implement the Bvb\_Grid\_Formatter\_Interface.

Your formatter may receive options that will be passed to the constructor

```
//No options
$grid->updateColumn('amount',array('format'=>'currency'));

//With options
$grid->updateColumn('amount',array('format'=>array('currency','pt_PT')));//Will pass the pt_PT value to the constructor. 
$grid->updateColumn('amount',array('format'=>array('currency',array('value1','{{amount}}','somehtingElse')))); //Will pass the array to the constructor
```

## Add You Dir ##
To know where to look for formatters, you must first tell grid where to look for them.

You can accomplish that using the addFormatterDir() method

```
$grid->addFormatterDir('Bvb/Grid/Formatter','Bvb_Grid_Formatter');
```


## Default Formatters ##
ZFDatagrid comes with 3 defaults formatters.
  * urrency
  * ate
  * mage

### Currency ###

Sample:
```
$grid->updateColumn('field',array('format'=>'currency'));
```

ZFDatagrid will look for a key in Zend\_Registry with the name Zend\_Locale and set the locale.

> Alternately you can set the locale to use:

```
$grid->updateColumn('field',array('format'=>array('currency','pt_PT')));
```

> ### Date ###

> ZFDatagrid will  for a key in Zend\_Registry with the name Zend\_Locale and use it.

> You can also pass as argument a instance of Zend\_Locale or an array with the following options
    * locale
    * date\_format
    * type

```
  $grid->updateColumn('field',array('format'=>'date'));
```

> ### Image ###
> This is a simple formatter and will expect the image URL.
```
$grid->updateColumn('field',array('format'=>'image'));
```
