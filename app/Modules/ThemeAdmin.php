<?php namespace App\Modules;

// Load Laravel classes
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request, Session, Input, URL, View;

abstract class ThemeAdmin extends BaseController {

	use ValidatesRequests;

	public $namespace = 'App\Modules';

	/**
	* Master layout
	* @var string
	*/
		protected $layout = 'Admin::layouts.template';

 	/**
	* View to render
	* @var string
	*/
		protected $view;

 	/**
	* Array of data passed to view
	* @var array
	*/
		protected $data = array();

 	/**
	* Subview to render
	* @var string
	*/
		protected $subview;

 	/**
	* Array of data to be passed to subview
	* @var array
	*/
		protected $subdata = array();

 	/**
	* Page title
	* @var string
	*/
		protected $title;

 	/**
	* Page scripts
	* @var string
	*/
		protected $scripts = array();

	/**
	* Page styles
	* @var string
	*/
		protected $styles = array();

	/**
	* Inline script or styles
	* @var string
	*/
	   protected $inlines = array();

 	/**
	* Set default subview layout
	* @param string $sublayout
	*/
	 public function __construct($sublayout = null)
	 {
		$this->view = $sublayout;
	 }

 	/**
	* Set view to render
	* @param string $view
	* @return self
	*/
	 protected function view($view)
	 {
		$this->view = $view;
	 	return $this;
	 }

 	/**
	* Set data to pass to view
	* @param array $data
	* @return self
	*/
	 protected function data(array $data)
	 {
		$this->data = $data;
	 	return $this;
	 }

 	/**
	* Set subview to render
	* @param string $subview
	* @return self
	*/
	 protected function subview($subview)
	 {
		$this->subview = $subview;
	 	return $this;
	 }

 	/**
	* Set data to pass to subview
	* @param array $subdata
	* @return self
	*/
	 protected function subdata(array $subdata)
	 {
		$this->subdata = $subdata;
	 	return $this;
	 }

 	/**
	* Set page title
	* @param string $title
	* @return Response
	*/
	 protected function title($title)
	 {
		 $this->title = $title;

		 // title method must be called last so it can call the render method
		 // this allows us to skip calling the render method
		 return $this->render();
	 }

 	/**
	* Set page script
	* @param string $script
	* @return Response
	*/
	 protected function scripts(array $scripts)
	 {

		 // Define scripts variables
		 $this->scripts = $scripts;
		 // append subview data to view data
		 $this->data['scripts'] = $this->scripts;

		 return $this;
	 }

 	/**
	* Set page style
	* @param string $style
	* @return Response
	*/
	 protected function styles(array $styles)
	 {

		 // Define styles variables
		 $this->styles = $styles;
		 // append subview data to view data
		 $this->data['styles'] = $this->styles;

		 return $this;
	 }

 	/**
	* Set page inline style or script
	* @param string $inlines
	* @return Response
	*/
	 protected function inlines(array $inlines)
	 {

		 // Define inlines variables
		 $this->inlines = $inlines;
		 // append subview data to view data
		 $this->data['inlines'] = $this->inlines;

		 return $this;
	 }

 	/**
	* Render the subview
	* @return Response
	*/
	 private function rendersubview()
	 {
		 $this->subview = array('subview' => View::make($this->subview)->with($this->subdata));

		 // append subview data to view data
		 return $this->data = $this->data + $this->subview;
	 }

 	/**
	* Render the view
	* @return Response
	*/
	 private function render()
	 {
		// render subview if subview is passed
		(is_null($this->subview)) ? : $this->rendersubview();

		// render the view
		return View::make($this->layout)
		->nest('content', $this->view, $this->data)
		->with('scripts', $this->scripts)
		->with('styles', $this->styles)
		->with('inlines', $this->inlines)
		->with('title', $this->title)
		;
	 }

}
