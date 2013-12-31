<?php

class SearchController extends BaseController {

    public function show() {

        if (Input::has('s')) {
            $term = Input::get('s');

            $tags = Tag::where('name', 'like', "%$term%" )->get();

            $oils= Oil::where('name', 'like', "%$term%" )->orWhere('info', 'like', "%$term%" )->get();

            // include pages search later

            $v = View::make('search.show');
            $v->title = "Searching For '$term'";
            $v->tags = $tags;
            $v->oils= $oils;
            $v->term= $term;
            $v->pretty_url = $this->pretty_url();
            return $v;

        } else {
            $v = View::make('search.show');
            $v->title = "Search";
            $v->term = null;
            return $v;
        }
    }
}

