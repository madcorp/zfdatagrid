# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Decorate you output


# What are decorators? #
Decorators, as the name itself indicates, decorate the result.
You can use a special code to specify the value of a certain field.
Lets assume you want to suffix the field value with a letter or a text.
The field name is _Population_ and you want the result something like this:

|has 12000 persons|
|:----------------|

where 12000 is the field value coming from the db

To achieve this you only need to add a decorator:


```
$grid->updateColumn('Population',array('decorator'=>'has {{Population}} persons'));
```

Resulting in: |has 12000 persons |
|:-----------------|

The expression {{Population}} will be replaced by the field value _Population_

Although you are in the _Population_ column you can use others fields as well.
```
$grid->updateColumn('Population',array('decorator'=>'{{Country}} has {{Population}} persons'));
```

Resulting in: |Portugal has 12000 persons |
|:--------------------------|