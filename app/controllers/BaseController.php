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
     * Adds a bunch of tags, non-duplicating 
     */
    public function tags_arr_add($arr)
    {

        $tags = Array();

        foreach ($arr as $single){
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
}
