<?php 

    function get_list_by_category($cat_id){

        global $db;

        if($cat_id){
            $query = 'SELECT * FROM todoitems';     //Placeholding Till I can figure out issue
            //$query = 'SELECT A.ItemNum, A.Title, A.Description, B.categoryName FROM todoitems A LEFT JOIN categories B ON A.categoryID = B.categoryID WHERE A.categoryID = :catID';
        } else {
            $query = 'SELECT * FROM todoitems';
            //$query = 'SELECT A.ItemNum, A.Title, A.Description, B.categoryName FROM todoitems A LEFT JOIN categories B ON A.categoryID = B.categoryID';
        }
        $statement = $db->prepare($query);
        //$statement->bindValue(':catID', $cat_id);      the bind value is throwing an error saying there are not the same number of values and tokens pretty much across the program
        $statement->execute();
        $todolist = $statement->fetchAll();
        $statement->closeCursor();
        return $todolist;
    }

    function delete_record($item_id){
        global $db;

        $query = 'DELETE FROM todoitems WHERE ItemNum = :item_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->execute();
        $statement->closeCursor();

    }

    function add_record($title, $description, $category_id){
        global $db;

        $query = 'INSERT INTO todoitems (Title, Description, categoryID) VALUES (:title, :descript, :catID)';
        $statement = $db->prepare($query);
        $statement->bindValue(':descript', $description);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':catID', $category_id);
        $statement->execute();
        $statement->closeCursor();

    }
    ?>