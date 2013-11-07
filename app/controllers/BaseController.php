<?php

class BaseController extends Controller {

    protected $pretty_url;

    public function pretty_url() {

        return function ($id) {
            $oil = Oil::find($id);
            return URL::route('oils.show', [$oil->cat->urlName, $oil->urlName]);
        };
    }
    
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
