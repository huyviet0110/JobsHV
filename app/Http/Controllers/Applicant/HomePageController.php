<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Language;
use App\Models\Post;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $searchCities = $request->get('cities', []);

        $arrCity = getAndCachePostCities();

        $query = Post::with([
            'languages',
            'company' => function ($q) {
                return $q->select(
                    'id',
                    'name',
                    'logo',
                );
            },
        ])
            ->latest();

        if (!empty($searchCities)) {
            $query->where(function ($q) use ($searchCities) {
                foreach ($searchCities as $searchCity) {
                    $q->orWhere('city', 'like', '%' . $searchCity . '%');
                }
                $q->orWhereNull('city');
            });
        }

        $posts = $query->paginate();

        return view('applicant.index', [
            'posts'        => $posts,
            'arrCity'      => $arrCity,
            'searchCities' => $searchCities,
        ]);
    }
}
