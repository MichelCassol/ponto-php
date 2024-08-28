<?php 

function loadView(string $viewName, array $params = [])
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                $$key = $value;
            }
        }
    }
    require_once(VIEW_PATH . "/$viewName.php");
}