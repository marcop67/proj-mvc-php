<?php

require_once './App/Core/Controller.php';

/**
 * Class NodeTreeController
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class NodeController extends Controller{

    private $node_id = null;
    private $language = null;
    private $search_keyword = null;
    private $page_num = null;
    private $page_size = null;
    private $page_offset = null;

    public function read()
    {

        $this->checkGetParameters();
        $this->pagination();

        $nodes_model = $this->loadModel('NodeTree');
        $this->checkNode($nodes_model);

        $bodyResponse= $this->getChildsAndCount($nodes_model);
        $this->generateResponse($bodyResponse);

    }

    private function checkGetParameters(){

        $this->checkMandatoryParameters($_GET["node_id"]);
        $this->checkMandatoryParameters($_GET["language"]);
        $this->checkIsInteger($_GET["page_num"]);
        $this->checkIsOutOfRange($_GET["page_size"]);

        $this->node_id = $_GET["node_id"];
        $this->language = $_GET["language"];
        $this->search_keyword = ($_GET["search_keyword"] ?? "");
        $this->page_num = ($_GET["page_num"] ?? 0);
        $this->page_size = ($_GET["page_size"] ?? 100);

    }

    private function checkMandatoryParameters($parameter){
        if ($parameter == null){
            $response = ["nodes" => [], "error" => "Missing mandatory params"];
            $this->generateError($response);
        }
    }

    private function checkIsInteger($parameter){
        if ($parameter != null){
            if(!is_int((int)$parameter)){
                $response = ["nodes" => [], "error" => "Invalid page number requested"];
                $this->generateError($response);
            }
        }
    }

    private function checkIsOutOfRange($parameter){
        if ($parameter != null){
            $parameterCasted = (int)$parameter;
            if(!($parameterCasted >= 0 && $parameterCasted <= 1000)){
                $response = ["nodes" => [], "error" => "Invalid page size requested"];
                $this->generateError($response);
            }
        }
    }

    private function pagination(){
        $this->page_offset = $this->page_size * $this->page_num;
    }

    private function checkNode($model){
        //check se nodo padre c'è
        if(!$model->getNode($this->node_id)){
            $response = ["nodes" => [], "error" => "Invalid node id"];
            $this->generateError($response);
        }
    }

    private function getChildsAndCount($model){
        $childs = $model->getChilds($this->node_id, $this->language, $this->search_keyword, $this->page_offset, $this->page_size);

        for ($index=0; $index<count($childs); $index++){

            $child = $childs[$index];
            //var_dump($child);
            $child_id=$child['node_id'];

            $num_childs = count($model->getChilds($child_id, $this->language, "", 0, 100));
            $child['children_count'] = $num_childs;

            $childs[$index] = $child;
        }

        return $childs;
    }

}
