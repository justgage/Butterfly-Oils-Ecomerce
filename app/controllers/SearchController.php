<?php

class SearchController extends BaseController {

    public function show() {

        if (Input::has('s')) {
            $term = Input::get('s');

            $tags = Tag::where('name', 'like', "%$term%" )->get();

            $oils= Oil::where('name', 'like', "%$term%" )
            ->orWhere('info', 'like', "%$term%" )
            ->orWhere('type', 'like', "%$term%" )->get();

            $pages= InfoPage::where('name', 'like', "%$term%" )
            ->orWhere('content', 'like', "%$term%" )->get();


            $v = View::make('search.show');
            $v->title = "Searching For '$term'";
            $v->tags = $tags;
            $v->oils= $oils;
            $v->pages= $pages;
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

