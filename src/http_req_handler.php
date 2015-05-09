<?php
include 'controller.php';
include 'util.php';


function handle($request) {
    $method = method($request);
    $url = url($request);

    echo "looking for some mapping for $url and method $method \n";

    if (($html_name = get_mapped_html_name($method, $url)) === false) {
        echo "HTML NAME NOT FOUND";
        return wrap_html_to_response("404", 404);
    } else {
        echo "HTML NAME IS $html_name";
        //todo add some html from file loading
        return wrap_html_to_response("some html");
    }
}


/**
 * returns html file name for url and method, false otherwise
 * @param $method
 * @param $url
 */
function get_mapped_html_name($method, $url) {
    // functions defined in controller file
    $functions = get_class_methods('Controller');

//    echo "FUNCITONS: ";
//    var_dump($functions);

    foreach ($functions as $i => $val) {
        echo $val;
        $function = new ReflectionMethod(get_class(new Controller), $val);

        $parameters = new ArrayObject($function->getParameters());

//        echo "parameters: ";
//        var_dump($parameters);
        if (mathes($parameters, $method, $url)) {
            $html_name = $function->invokeArgs(new Controller(), $parameters->getArrayCopy());
            return $html_name;
        }
    }
    return false;
}

/**
 * $parameters from controller function
 * $url, $method from http request
 */
function mathes($parameters, $method, $url) {
    $parameters = new ArrayObject($parameters);

    $method_object = $parameters->offsetGet(0)->getName();
    var_dump($parameters->offsetGet(0)->getName());
    if ($method_object != $method) {
        var_dump($method);
        var_dump($method_object->name);
        echo "\n METHODS NOT EQUAL";
        return false;
    }
    $parameters->offsetUnset(0); //drop method name from arrayobj

    $url_words = explode("/", $url);
    $url_words = new ArrayObject($url_words);
    //clear from empty words
    foreach ($url_words as $i => $word) {
        if ($word === "") {
            $url_words->offsetUnset($i);
        }
    }

    echo "\n\n EVALUATE: url: $url \n URL WORDS FROM URL";
    var_dump($url_words);
    echo "\n METHOD PARAMETERS: ";
    var_dump($parameters);

    if ($url_words->count() != $parameters->count()) return false;
    foreach ($url_words as $i => $word) {
        if ($word != $parameters->offsetGet($i)->getName()) {
            return false;
        }
    }
    return true;
}
