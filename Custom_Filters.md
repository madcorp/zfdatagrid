# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Build your own filters



# Introduction #
The most common practice for this is probably range selection, but not only. ZFDatagrid already ships with range selectors for numbers and dates.

## Example ##
```
        $filters = new Bvb_Grid_Filters();
        $filters->addFilter('Population', array('render' => 'number'));
        $grid->addFilters($filters);
```


## Building Custom Filters ##

Your class must implement Bvb\_Grid\_Filters\_Render\_Interface or extend Bvb\_Grid\_Filters\_Render\_Abstract

**Date Example**
```
       class Bvb_Grid_Filters_Render_Date extends Bvb_Grid_Filters_Render_Abstract
            {           
                function getChilds()
                {
                    return array('from', 'to');
                }
            
                function normalize($value, $part = '')
                {
                    return date('Y-m-d', strtotime($value));
                }
            
                public function getConditions()
                {
                    return array('from' => '>=', 'to' => '<=');
                }
            
                function render()
                {
                    $this->removeAttribute('id');
                    $this->setAttribute('style', 'width:80px !important;');
            
                    return '<span>' . $this->__('From') . ":</span>" . $this->getView()->formText($this->getFieldName() . '[from]', $this->getDefaultValue('from'), array_merge($this->getAttributes(), array('id' => 'filter_' . $this->getFieldName() . '_from'))) . "<br><span>" . $this->__('To') . ":</span>" . $this->getView()->formText($this->getFieldName() . '[to]', $this->getDefaultValue('to'), array_merge($this->getAttributes(), array('id' => 'filter_' . $this->getFieldName() . '_to')));
                }            
            }
```

The method hasConditions is used to determine if your render uses common filters ('<','>') or will use "complex" queries.

If this method return true the getConditions() method will be called and the value for each child will be applied. In this case to the _from_ value will be applied the _>=_ and to the to_the_<=

However, if the hasConditions() method returns false, a new method will be called, buildQuery($filters), where $filters contain an array like this
```
    array('from'=>'5000','to'=>'9000');
```

Then you can apply your custom query in this method doing something like this:

```
    public function buildQuery(array $filter)
    {
        $this->getSelect()->where($this->getFieldName().' >=?',$filter['from'] )->where($this->getFieldName().'<=?',$filter['to']);//Or any other query...
    }
```

Another method that my be useful is the normalize(). This method will be called before querying. It's mostly useful for date/time and to apply the strtotime().

## Adding your Filters to Grid ##
Add dirs containing yours custom filters using this code:

```
$grid->addFiltersRenderDir('My/Custom/Filters/Render', 'My_Custom_Filters_Render');
```
