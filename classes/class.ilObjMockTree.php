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
	public function __construct($a_parent_obj, $cmd)
	{
		global $ilCtrl, $root;
		$this->ctrl = $ilCtrl;

		parent::__construct(0, $a_parent_obj, $cmd);
		
		$builder = new Tree\Builder\NodeBuilder;

		$builder
			->value($a_parent_obj->object->getTitle())
			->tree('Chapter 1')
				->leaf('Page 1')
				->leaf('Page 2')
				->tree('Subchapter 1.1')
					->leaf('Page 3')
					->leaf('Page 4')
					->end()
				->end()
			->tree('Chapter 2')
				->leaf('Page 5')
				->end()
		;
		$root = $builder->getNode()->root();
		$visitor = new PreOrderVisitor();
		$yield = $root->accept($visitor);
		$i = 0;
		foreach ($yield as $node)
		{
			if (!$node->isLeaf())
			{
				parent::setNodeOpen($this->getNodeId($node));
			}
			$i++;
		}
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

	function isNodeHighlighted($a_node)
	{
		global $root;

		switch ($this->parent_cmd)
		{
			// Mark root highlighted
			case "showChapterSubtab":
			case "showAllPagesSubtab":
			case "showWeblinkCheckSubtab":
			case "showMediaSubtitlesSubtab":
			case "showInternalLinksSubtab":
			case "showChapterSubchaptersSubtab":
			case "showImportSubtab":
			case "showExportSubtab":
			case "showQuestions":
			case "showStatisticSubtab":
			case "showBlockedUsersSubtab":
			case "showInfo":
			case "showInfoSubtab":
			case "showInfoHistorySubtab":
			case "showSettingsSubtab":
			case "showStyleSubtab":
			case "showMenuSubtab":
			case "showGlossariesSubtab":
			case "showMultilinguismSubtab":
			case "showMetadataSubtab":
				if ($a_node === $root)
				{
					return true;
				}
				break;

			// Mark chapter 1 or 2 highlighted
			case "showChapter1":
			case "showChapter2":
			case "showChapterEditSubtab":
			case "showChapterMetadataSubtab":
			case "showChapterPreconditionsSubtab":
				if ($this->getNodeId($a_node)== 1 && $_SESSION["chapter"] == "Chapter 1")
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$tpl->setLocator();
					return true;
				}

				if ($this->getNodeId($a_node)== 7 && $_SESSION["chapter"] == "Chapter 2")
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 2",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter2"));
					$tpl->setLocator();
					return true;
				}

				break;



			// Mark page 1 highlighted
			case "showSubchapterSubtab":
			case "showPageMetadataSubtab":
			case "showPage1":
			case "showEditSubtab":
			case "showPreviewSubtab":
			case "showHistorySubtab":
			case "showClipboardSubtab":
			case "showActivationSubtab":
			if ($this->getNodeId($a_node)== 2 && $_SESSION["page"] == "Page 1")
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Page 1",$ilCtrl->getLinkTarget($this->parent_obj, "showPage1"));
					$tpl->setLocator();
					return true;
				}
				break;
			// User view tree
			case "showUserView":
			case "showUserInfoTab":
			case "showContentTab":
			case "showTableOfContentsTab":
			case "showPrintViewTab":
			if ($this->getNodeId($a_node)== 2)
			{
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(),$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Page 1",$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$tpl->setLocator();
				return true;
			}
			break;
			// Show Subchapter 1.1 highlighted

			case "showSubchapter1":
			case "showSubchapterMetadataSubtab":
			case "showSubchapterPreconditionsSubtab":
			case "showSubchapterSubchaptersSubtab":
				if ($this->getNodeId($a_node)== 4)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Subchapter 1.1",$ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1"));
					$tpl->setLocator();
					return true;
				}
			default:
				return parent::isNodeHighlighted($a_node); // TODO: Change the autogenerated stub
		}
	}

	function getNodeHref($a_node)
	{
		global $ilCtrl;

		switch ($this->parent_cmd)
		{
			case "showUserView":
			case "showUserInfoTab":
			case "showContentTab":
			case "showTableOfContentsTab":
			case "showPrintViewTab":
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserView");
			break;
			default:
				if ($a_node->isLeaf())
					return $ilCtrl->getLinkTarget($this->parent_obj, "showPage1");
				elseif ($a_node->isChild())
				{
					if ($this->getNodeId($a_node)==4)
						return $ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1");
					if ($this->getNodeId($a_node)==1)
						return $ilCtrl->getLinkTarget($this->parent_obj, "showChapter1");
					return $ilCtrl->getLinkTarget($this->parent_obj, "showChapter2");
				}
				else return $ilCtrl->getLinkTarget($this->parent_obj, "showChapterSubtab");
		}
	}
}