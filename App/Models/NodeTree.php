<?php

class NodeTree
{
    function __construct($dbConnection)
    {
        try
        {
            $this->db = $dbConnection;
        } catch (PDOException $e)
        {
            exit('Database connection could not be established.');
        }
    }

    public function getChilds($node_id, $language, $search_keyword, $page_num, $page_size)
    {
        $sql = "SELECT Child.idNode as node_id, TreeNames.nodeName as name
                FROM node_tree as Parent, node_tree as Child
                JOIN node_tree_names as TreeNames 
                    ON Child.idNode = TreeNames.idNode
                WHERE
                      TreeNames.language LIKE '" . $language . "'
                      AND Parent.idNode = " . $node_id . "
                      AND Child.level = (Parent.level + 1)
                      AND Child.iLeft > Parent.iLeft
                      AND Child.iRight < Parent.iRight
                      AND TreeNames.nodeName LIKE '%" . $search_keyword . "%'
                LIMIT " . $page_num . "," . $page_size . ";";

        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // Core/Controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change Core/Controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getNode($node_id)
    {
        $sql = "SELECT * FROM node_tree WHERE idNode=" . $node_id . ";";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }


}
