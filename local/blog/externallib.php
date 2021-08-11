<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/07/21
 * Time: 12:48 م
 */
require_once($CFG->libdir . '/externallib.php');

class local_get_blog_data extends external_api
{




    public static function get_blog_data_parameters() {
        return new external_function_parameters (
            array(
                'categoryid' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'category id'), 'Array of category id', VALUE_DEFAULT, array()
                ),
            )
        );
    }

    /**
     * Returns a list of blog in a provided list of courses,
     * if no list is provided all blog that the user can view will be returned.
     *
     * @param array $courseids the course ids
     * @return array of blog details
     * @since Moodle 3.0
     */
    public static function get_blog_data() {
        global $CFG, $DB;

        $returnedbooks = array();


        $books = $DB->get_records("blog");
        foreach ($books as $book) {
            $bookdetails = array();
            // First, we return information that any user can see in the web interface.
            $bookdetails['id'] = $book->id;
            $bookdetails['title']      = $book->title;
            $bookdetails['desc']      = $book->description;
            $returnedbooks[] = $bookdetails;
        }

        $result = array();
        $result['blog'] = $returnedbooks;

        return $result;
    }
    /**
     * Describes the get_books_by_courses return value.
     *
     * @return external_single_structure
     * @since Moodle 3.0
     */
    public static function get_blog_data_returns() {
        return new external_single_structure(
            array(
                'blog' => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'id' => new external_value(PARAM_INT, 'Blog id'),
                            'title' => new external_value(PARAM_RAW, 'Blog name'),
                            'desc' => new external_value(PARAM_RAW, 'Blog name'),
                        ), 'Blog'
                    )
                )
            )
        );
    }


}
