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
			case "showOwnerSubtab":
			case "showPermissionsOfUserSubtab":
			case "showObjectPermissionSettingsSubtab":
			case "showChapterSubtab":
			case "showAllPagesSubtab":
			case "showWeblinkCheckSubtab":
			case "showMediaSubtitlesSubtab":
			case "showInternalLinksSubtab":
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
				if ($this->getNodeId($a_node)== 1)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showChapter2":
				if ($this->getNodeId($a_node)== 7)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 2",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter2"));
					$tpl->setLocator();
					return true;
				}

				break;

			case "showChapterSubchaptersSubtab":
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



			// Mark page highlighted
			case "showPage1":
				if ($this->getNodeId($a_node)== 2)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Page 1",$ilCtrl->getLinkTarget($this->parent_obj, "showPage1"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showPage2":
				if ($this->getNodeId($a_node)== 3)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Page 2",$ilCtrl->getLinkTarget($this->parent_obj, "showPage2"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showPage3":
				if ($this->getNodeId($a_node)== 5)
				{
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Subchapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1"));
					$ilLocator->addItem("Page 3",$ilCtrl->getLinkTarget($this->parent_obj, "showPage3"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showPage4":
				if ($this->getNodeId($a_node)== 6)
				{
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
					$ilLocator->addItem("Subchapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1"));
					$ilLocator->addItem("Page 4",$ilCtrl->getLinkTarget($this->parent_obj, "showPage4"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showPage5":
				if ($this->getNodeId($a_node)== 8)
				{
					global $ilLocator, $tpl, $ilCtrl;

					$ilLocator->addItem("Chapter 2",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter2"));
					$ilLocator->addItem("Page 5",$ilCtrl->getLinkTarget($this->parent_obj, "showPage5"));
					$tpl->setLocator();
					return true;
				}
				break;

			case "showSubchapterSubtab":
			case "showPageMetadataSubtab":
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

			if ($this->getNodeId($a_node)== 3 && $_SESSION["page"] == "Page 2")
			{
				global $ilLocator, $tpl, $ilCtrl;

				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
				$ilLocator->addItem("Page 2",$ilCtrl->getLinkTarget($this->parent_obj, "showPage2"));
				$tpl->setLocator();
				return true;
			}

			if ($this->getNodeId($a_node)== 5 && $_SESSION["page"] == "Page 3")
			{
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
				$ilLocator->addItem("Subchapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1"));
				$ilLocator->addItem("Page 3",$ilCtrl->getLinkTarget($this->parent_obj, "showPage3"));
				$tpl->setLocator();
				return true;
			}

			if ($this->getNodeId($a_node)== 6 && $_SESSION["page"] == "Page 4")
			{
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter1"));
				$ilLocator->addItem("Subchapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showSubchapter1"));
				$ilLocator->addItem("Page 4",$ilCtrl->getLinkTarget($this->parent_obj, "showPage4"));
				$tpl->setLocator();
				return true;
			}

			if ($this->getNodeId($a_node)== 8 && $_SESSION["page"] == "Page 5")
			{
				global $ilLocator, $tpl, $ilCtrl;

				$ilLocator->addItem("Chapter 2",$ilCtrl->getLinkTarget($this->parent_obj, "showChapter2"));
				$ilLocator->addItem("Page 5",$ilCtrl->getLinkTarget($this->parent_obj, "showPage5"));
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
			if ($this->getNodeId($a_node)== 2 && $_SESSION["userview"] == "Page1")
			{
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(),$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Page 1",$ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage1"));
				$tpl->setLocator();
				return true;
			}
			if ($this->getNodeId($a_node)== 3 && $_SESSION["userview"] == "Page2")
			{
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(),$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Chapter 1",$ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Page 2",$ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage2"));
				$tpl->setLocator();
				return true;
			}
			if ($this->getNodeId($a_node)== 5 && $_SESSION["userview"] == "Page3") {
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
				$ilLocator->addItem("Page 3", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
				$tpl->setLocator();
				return true;
			}
			if ($this->getNodeId($a_node)== 6 && $_SESSION["userview"] == "Page4") {
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
				$ilLocator->addItem("Page 4", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage4"));
				$tpl->setLocator();
				return true;
			}
			if ($this->getNodeId($a_node)== 8 && $_SESSION["userview"] == "Page5") {
				global $ilLocator, $tpl, $ilCtrl;
				$ilLocator->clearItems();
				$ilLocator->addRepositoryItems();
				$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
				$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5"));
				$ilLocator->addItem("Page 4", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5"));
				$tpl->setLocator();
				return true;
			}
			break;

			case "showUserViewPage1":
				if ($this->getNodeId($a_node)== 2) {
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->clearItems();
					$ilLocator->addRepositoryItems();
					$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Chapter 1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Page 1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage1"));
					$tpl->setLocator();
					return true;
				}
			break;
			case "showUserViewPage2":
				if ($this->getNodeId($a_node)== 3) {
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->clearItems();
					$ilLocator->addRepositoryItems();
					$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Chapter 1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Page 2", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage2"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showUserViewPage3":
				if ($this->getNodeId($a_node)== 5) {
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->clearItems();
					$ilLocator->addRepositoryItems();
					$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
					$ilLocator->addItem("Page 3", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showUserViewPage4":
				if ($this->getNodeId($a_node)== 6) {
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->clearItems();
					$ilLocator->addRepositoryItems();
					$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3"));
					$ilLocator->addItem("Page 4", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage4"));
					$tpl->setLocator();
					return true;
				}
				break;
			case "showUserViewPage5":
				if ($this->getNodeId($a_node)== 8) {
					global $ilLocator, $tpl, $ilCtrl;
					$ilLocator->clearItems();
					$ilLocator->addRepositoryItems();
					$ilLocator->addItem($this->parent_obj->object->getTitle(), $ilCtrl->getLinkTarget($this->parent_obj, "showUserView"));
					$ilLocator->addItem("Subchapter 1.1", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5"));
					$ilLocator->addItem("Page 4", $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5"));
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
			case "showUserViewPage1":
			case "showUserViewPage2":
			case "showUserViewPage3":
			case "showUserViewPage4":
			case "showUserViewPage5":
			if ($a_node->isLeaf())
				if ($this->getNodeId($a_node)==2)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage1");
			if ($this->getNodeId($a_node)==3)
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage2");
			if ($this->getNodeId($a_node)==5)
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3");
			if ($this->getNodeId($a_node)==6)
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage4");
			if ($this->getNodeId($a_node)==8)
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5");

			elseif ($a_node->isChild())
			{
				if ($this->getNodeId($a_node)==4)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage3");
				if ($this->getNodeId($a_node)==1)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage1");
				return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage5");
			}
			else return $ilCtrl->getLinkTarget($this->parent_obj, "showUserViewPage1");
			break;
			default:
				if ($a_node->isLeaf())
					if ($this->getNodeId($a_node)==2)
						return $ilCtrl->getLinkTarget($this->parent_obj, "showPage1");
				if ($this->getNodeId($a_node)==3)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showPage2");
				if ($this->getNodeId($a_node)==5)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showPage3");
				if ($this->getNodeId($a_node)==6)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showPage4");
				if ($this->getNodeId($a_node)==8)
					return $ilCtrl->getLinkTarget($this->parent_obj, "showPage5");

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