# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Perform multiple actions at once


# Introduction #
Mass actions allows you to perform the same action on several records, by adding an extra column into the left of the grid and adding checkboxs into them.

This is an automated process, your primary keys will be added to field value and you will receive a post argument with the name **_postMassIds_** with commas separating the various values.

## Example ##

```
$massActions = array(
                                array(
                                        'url' => $grid->getUrl(),//For form action
                                        'caption' => 'Remove (Nothing will happen)',//Select Captions
                                        'confirm' => 'Are you sure?'),//Confirmation message (Optional)
                                array(
                                        'url' => $grid->getUrl() . '/nothing/happens',
                                        'caption' => 'Some other action',
                                        'confirm' => 'Another confirmation message?')
                                );

$grid->setMassActions($massActions);
```