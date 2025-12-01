<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2|max:255',
            'filters' => 'nullable|array',
        ]);

        $query = $request->input('query');
        $filters = $request->input('filters', []);

        $results = $this->searchService->searchAll($query, $filters);
        $filterCounts = $this->searchService->getFilterCounts($query);

        return view('search.index', compact('results', 'query', 'filters', 'filterCounts'));
    }
}
