<?php

class BaseController extends Controller {

    protected $pretty_url;

    public function pretty_url() {

        return function ($id) {
            $oil = Oil::find($id);
            if ($oil !== null) {
                return URL::route('oils.show', [$oil->cat->urlName, $oil->urlName]);
            } else {
                return URL::route('oils.404');
            }
        };
    }

    /***
    * Will take the input of one field
    * and put change it to a lowercase
    * and get rid of the spaces
    * then put into another feild (to)
    */
    public function safeUrl ($text) {

        $text = strtolower($text);
        $text = preg_replace("/ *$/", "", $text); // get rid of white space at the end
        $text = preg_replace("/\s/", "-", $text); // spaces to dash

        return $text;
    }

    /**
     * Adds a bunch of tags, non-duplicating 
     */
    public function tags_arr_add($arr)
    {

        $tags = Array();

        foreach ($arr as $single){

            $single = trim($single);

            if ($single !== "") {
                $tag = Tag::where('name', '=', $single)->first();

                if ($tag === NULL) {
                    $urlName = preg_replace('/[^\da-z]+/i', '-', $single);
                    $urlName = strtolower($urlName);

                    $tag = new Tag;
                    $tag->name = $single;
                    $tag->urlName = $urlName;

                    $tag->save();
                }

                $tags[] = $tag;
            }
        }
        
        return $tags;
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
    
    public function missingMethod($array = array()) {
        return View::make('front.404')->with('title', "404 - Page not found!");
    }
}
