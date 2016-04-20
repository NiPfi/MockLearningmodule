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
			->tree('Chapter 1')
				->leaf('Page 1')
				->leaf('Page 2')
				->tree('Subchapter 1.1')
					->leaf('Page 1')
					->leaf('Page 2')
					->end()
				->end()
			->tree('Chapter 2')
				->leaf('Page 1')
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
		return $yield[$a_parent_node_id]->getChildren();

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
		$i = 0;
		foreach ($yield as $node)
		{
			if ($node === $a_node)
			{
				return $i;
			}
			$i++;
		}
	}
	
	function getNodeIcon($a_node)
	{
		if ($a_node->isLeaf())
		{
			return './templates/default/images/icon_pg.svg';
		}
		elseif ($a_node->isChild())
		{
			return './templates/default/images/icon_st.svg';
		} else return './templates/default/images/icon_lm.svg';
	}
}