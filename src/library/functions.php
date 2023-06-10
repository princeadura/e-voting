<?php

/**
 * Function location
 *function to redirect using header
 *
 * @param string $location [explicite description]
 *
 * @return void
 */
function redirect($location)
{
    header("Location: $location");
    exit();
}
