<?php

require_once (__DIR__ . '/../../config.php');



$PAGE->set_url(new moodle_url('/local/blog/category.php'));

$PAGE->set_context(context_system::instance());


$systemcontext = context_system::instance();



global $DB,$USER;
$PAGE->set_title('Manage Blog Categories');


if (!has_capability('local/blog:category', $systemcontext)) {
    print_error('accessdenied', 'admin');
}


echo $OUTPUT->header();

global  $DB;

$blog_categories = $DB->get_records('blog_categories');

echo "<h2 class='text-center'>Blog Categories Parent</h2>";
echo "<hr>";
echo "<br>";

if (has_capability('local/blog:categoryedit', $systemcontext)) {
    echo "<a href='/moodle/local/blog/categoryedit.php' class='btn btn-success' style='margin:20px 0px'>Add new Category</a>";
}

function getPath($id){

    global $DB;
    $string = "";
    $i = 0;

    do{
        $categry= $DB->get_record('blog_categories',['id'=>$id]);
        if ($categry->parent !== 0){
            $string = $string . "/$categry->name";
        }

        $i = $categry->parent;
        $id = $categry->parent;

    }while ($i !=0 );

    return $string;
}


function getParent($id){
    global  $DB;

    $categry= $DB->get_record('blog_categories',['id'=>$id]);

    if ($categry->parent != 0){
        $parent = $DB->get_record('blog_categories',['id'=>$categry->parent]);

        return $parent->name;
    }

    return 'Top';
}


$table = new html_table();
$table->head   = array('id','Title','Description', 'Path','Parent','Actions');

foreach ($blog_categories as $category)
{
    $table->data[] = array(
        $category->id,
        $category->name,
        $category->description,
        getPath($category->id),
        getParent($category->id),
        "<a href='/moodle/local/blog/categoryedit.php?id=$category->id'><i class = 'fa fa-edit'></i></a>" . ' ' .
        "<a onClick=\"alert('Ara U sure')\" href =/moodle/local/blog/categorydelete.php?id=$category->id><i class = 'fa fa-remove'></i> </a>"
    );
}
echo html_writer::table($table);

/*
echo "<table class ='table table-responsive table-fluid'>
        <tr style='background-color: #0a477e; color: #fff'>
            <th>Blog Category </th>
            <th>Category Number </th>
            <th>Category Description </th>
            <th>Category Path</th>
            <th>Category Parent</th>
            <th>Operation</th>    
        </tr>
    ";


foreach ($blog_categories as $category)
{
    echo
    "<tr>
            <td>$category->name</td>
            <td>$category->idnumber</td>
            <td>$category->description</td>
            <td>" . getPath($category->id) . "</td>
            <td>" . getParent($category->id) . "</td>
            ";
            echo "<td>";
            // get the records of parent
            if (has_capability('local/blog:categoryedit', $systemcontext)) {
                echo "<a href =/moodle/local/blog/categoryedit.php?id=$category->id><i class = 'fa fa-edit'></i> </a>";
                echo "<a onClick=\"alert('Ara U sure')\" href =/moodle/local/blog/categorydelete.php?id=$category->id><i class = 'fa fa-remove'></i> </a>";
            }
            echo "</td>";
       echo"</tr>";

}


echo "</table>";

echo "<br>";

*/

echo $OUTPUT->footer();





