<?php
    require('model/database.php');
    require('model/categories_db.php');
    require('model/todolist_db.php');

    $itemNum = filter_input(INPUT_POST, 'ItemNum', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $Title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);

    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if(!$category_id)
    {
        $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    }

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    if(!$action){
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        if(!$action) {
            $action = 'list_tasks';
        }
    }

    switch($action) {
        case "list_categories":
            $categories = get_categories();
            include('view/category_list.php');
            break;
        
        case "add_category":
            add_category($category_name);
            header("Location: .?action=list_categories");
            break;

        case "add_task":
            if ($category_id && $description){
                add_record($Title, $description, $category_id);
                header("Location: .?category_id=$category_id");
            } else {
                $error = "Invalid task data. Check all fields and try again.";
                include('view/error.php');
                exit();
                
            }
            break;

        case "delete_category":
            if($category_id) {
                try{
                    delete_category($category_id);
                } catch (PDOException $e) {
                    $error = "You cannot delete a Category if their are tasks still remaining in that Category";
                    include('view/error.php');
                    exit();
                }
                header("Location: .?action=list_categories");
            }
            break;

        case "delete_task":
            if($itemNum){
                delete_record($itemNum);
                header("Location: .?category_id=$category_id");
            } else {
                $error = "Missing or incorrect task ID.";
                include('view/error.php');
            }
            break;
        default:
            $category_name = get_category_name($category_id);
            $categories = get_categories();
            $tasks = get_list_by_category($category_id);
            include('view/todo_list.php');
    }