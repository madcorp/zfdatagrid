# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary External Filters



# Introduction #
This is very useful if you want to associate an external input to the grid as a filter.

Check this example for a possible example: http://zfdatagrid.com/grid/default/site/filters


## Example ##
```
        //First Argument the input ID
        //Second argument the callback to apply
        $grid->addExternalFilter('new_filter', 'people');
```

The callback will receive 3 args.

  * The input id
  * The input value
  * The select Object

```
 function people ($inputId, $value, $select)
    {
        $select->where('Population>?', $value);
    }
```


And in your view.
```
    //$this->grid is the grid object passed from controller.
    //The onchange function is gridChangeFilters() prefixed with your grid id. 
    //If your grid id is _one_ the function will be called _onegridChangeFilters()_
    echo $this->formSelect('new_filter',$this->grid->getParam('new_filter'),array('onChange'=>'gridChangeFilters()'),$array);
```
