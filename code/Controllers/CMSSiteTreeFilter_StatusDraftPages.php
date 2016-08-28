<?php

namespace SilverStripe\CMS\Controllers;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\SS_List;
use SilverStripe\ORM\Versioning\Versioned;

/**
 * Filters pages which have a status "Draft".
 *
 * @package cms
 * @subpackage content
 */
class CMSSiteTreeFilter_StatusDraftPages extends CMSSiteTreeFilter
{

	static public function title()
	{
		return _t('CMSSiteTreeFilter_StatusDraftPages.Title', 'Draft pages');
	}

	/**
	 * Filters out all pages who's status is set to "Draft".
	 *
	 * @see {@link SiteTree::getStatusFlags()}
	 * @return SS_List
	 */
	public function getFilteredPages()
	{
		$pages = Versioned::get_by_stage('SilverStripe\\CMS\\Model\\SiteTree', 'Stage');
		$pages = $this->applyDefaultFilters($pages);
		$pages = $pages->filterByCallback(function (SiteTree $page) {
			// If page exists on stage but not on live
			return (!$page->getIsDeletedFromStage() && $page->getIsAddedToStage());
		});
		return $pages;
	}
}