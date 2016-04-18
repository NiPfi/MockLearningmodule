<?php
include_once("./Services/UIComponent/Explorer2/classes/class.ilExplorerBaseGUI.php");

/**
 * Created by PhpStorm.
 * User: Nicola
 * Date: 18.04.2016
 * Time: 14:00
 */
class ilObjMockTree extends ilExplorerBaseGUI
{
	public function __construct($a_parent_obj)
	{
		global $ilCtrl;
		$this->ctrl = $ilCtrl;
		$a_expl_id = 0;
		$a_parent_cmd = "";
		parent::__construct($a_expl_id, $a_parent_obj, $a_parent_cmd);
	}

	function getRootNode()
	{
		
	}

	function getChildsOfNode($a_parent_node_id)
	{

	}

	function getNodeContent($a_node)
	{

	}

	function getNodeId($a_node)
	{

	}
}