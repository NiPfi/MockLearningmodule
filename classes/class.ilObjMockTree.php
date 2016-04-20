<?php
require __DIR__.'/../vendor/autoload.php';

include_once("./Services/UIComponent/Explorer2/classes/class.ilExplorerBaseGUI.php");

use Tree\Visitor\PreOrderVisitor;
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
		global $ilCtrl, $root;
		$this->ctrl = $ilCtrl;
		parent::__construct(0, $a_parent_obj, null);

		$builder = new Tree\Builder\NodeBuilder;

		$builder
			->value('MockLearningmodule')
			->leaf('Page 1')
			->tree('C')
				->tree('D')
					->leaf('G')
					->leaf('H')
					->end()
				->leaf('E')
				->leaf('F')
				->end()
		;
		$root = $builder->getNode()->root();
	}

	function getRootNode()
	{
		global $root;
		return $root;
	}

	function getChildsOfNode($a_parent_node_id)
	{
		global $root;

		$visitor = new PreOrderVisitor();
		$yield = $root->accept($visitor);
		if ($yield[$a_parent_node_id] != null)
		{
			return $yield[$a_parent_node_id]->getChildren();
		}
	}

	function getNodeContent($a_node)
	{
		return $a_node->getValue();
	}

	function getNodeId($a_node)
	{
		global $root;

		$visitor = new PreOrderVisitor();
		$yield = $root->accept($visitor);
		for ($i = 0; $i<$root->getSize(); $i++)
		{
			if ($yield[i]==$a_node)
			{
				return $yield[i];
			}
		}
		return null;
	}
}