<?php 

class TagController extends \BaseController {


	public function index()
	{
        $tags = Tag::all();

        $tags = $tags->filter(function($tag){
            if ($tag->oils()->count() > 0) {
                return $tag;
            } else {
                $tag->delete();
            }
        });

        return View::make("tags.index")
            ->with('title', "View by Use")
            ->with('tags', $tags);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($urlName)
	{
        $tag = Tag::where('urlName', '=', $urlName)->first();

        if ($tag !== null) {
            return View::make('tags.show')
                ->with('title', "Browse all products in \"$tag->name\"")
                ->with('tag', $tag)
                ->with('pretty_url', $this->pretty_url());
        } else {
            return "Not found!";
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
    /**
     * returns a list of current avalible tags
     */
    public function ajax_list()
    {
        $tags = Tag::all();

        $tags_arr = array();
        $i = 0;

        foreach ($tags as $single){
            $tags_arr[$i] = array();
            $tags_arr[$i]["value"] = $single->name;
            $tags_arr[$i]["tokens"] = explode(" ", $single->name);
            $i += 1;
        }

        return json_encode($tags_arr);
    }
}
