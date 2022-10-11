<?php


function setFilters(string $key, array $filters){
    setSession($key, $filters, true);
}

function getFilter(string $filter, string $input){
    if($session = getSession($filter)){
        if(isset($session[$input])){
            return $session[$input];
        }
        return null;
    }
}


function quantityFilter(string $key)
{
    if(!getSession($key)){
        return 0;
    }

    return count(getSession($key));
}