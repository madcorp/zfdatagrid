# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How to add extra columns



# Introduction #

You can add extra columns to the grid, placed at right or left.

## Example ##

```
$right = new Bvb_Grid_Extra_Column();
$right->position('right')->name('unique_name')->title('Right')->decorator("<strong>{{Population}}</strong>");

$left = new Bvb_Grid_Extra_Column();
$left->position('left')->name('unique_name2')->title('Left')->decorator("<input  type='checkbox' name='number[]'>");

$grid->addExtraColumns($right, $left);
```

## Options available for extra columns ##

| Name | Propose | Expects  |
|:-----|:--------|:---------|
| position| Define colum position | (left|right) |
| name | The name for the column | unique\_value |
| title | The title for the column | any text |
| class | CSS class | A css class to apply |
| decorator | Add extra html to the column | HTML|text |
| style | CSS style | Style to be applied tot he column |
| helper | Easy access to View Helpers |  A registered View Helper |
| callback | execute a callback function | valid callback.  |
| format | Format column value | A registered format |


## In which order are they applied ##

  * format
  * callback
  * helper
  * decorator
  * class
  * style

## Full Example ##

```
$left = new Bvb_Grid_Extra_Column();
$left->position('left')
->name('Left')
->format('number')
->callback(array('function'=>'my_function','params'=>array('my','params')))
->decorator("|{{field}}|")
->helper(array('formText'=>array('name','value',array())))
->class('extraFields')
->title('MyTitle')
->style('text-decoration:underline;');

```