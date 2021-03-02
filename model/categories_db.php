<?php

    function get_categories() {
        global $db;
        $query = 'SELECT * from categories ORDER BY categoryID';
        $statement = $db->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll();
        $statement->closeCursor();
        return $categories;
    }

    function get_category_name($categoryID){
        if (!$categoryID) {
            return "All Courses";
        }
        global $db;
        $query = 'SELECT * from categories WHERE categoryID = :category_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $categoryID);
        $statement->execute();
        $category = $statement->fetch();
        $statement->closeCursor();
        $category_name = $category['categoryName'];
        return $category_name;

    }

    function delete_category($categoryID) {
        global $db;
        $query = 'DELETE FROM categories WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $categoryID);
        $statement->execute();
        $statement->closeCursor();

    }

    function add_category($category_name) {
        global $db;
        $query = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryName', $category_name);
        $statement->execute();
        $statement->closeCursor();
    }