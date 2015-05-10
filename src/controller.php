<?php

/**
 * Implements basic mapping for any http request
 * Functions must return a string name of corresponding resource html file
 * First functions's parameter's name represents http method and next parameters
 * represent url hierarchy, e.g:
 *
 * function any_function_name($GET, $user, $profile) {
 *      return "html_file_name";
 * }
 *
 * function is responsible for GET method with url /user/profile
 *
 * function main($GET) {
 *      return "gradle-please.html";
 * }
 *
 * GET '/' request
 * */

class Controller {

    function any_function_name($GET, $user, $profile)
    {
        return "gradle-please.html";
    }

    function main($GET) {
        return "gradle-please.html";
    }
}