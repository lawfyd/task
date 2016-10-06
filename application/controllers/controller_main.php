<?php



class Controller_Main extends Controller
{

	function action_index()
	{
		define(ROOT, dirname(__FILE__));
		//$cateroryList = ModelCategory::getAllMainCatsWithChildren();
		require_once(ROOT . '/application/views/index_view.php');
		//$this->view->generate('main_view.php', 'template_view.php');
	}
}