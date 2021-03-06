<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Canvas\Trends;
use Canvas\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    use Trends;

    /**
     * Number of days to compile stats.
     *
     * @const int
     */
    private const DAYS_PRIOR = 30;

    /**
     * Get all the stats.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $published = Post::forCurrentUser()
                         ->published()
                         ->latest()
                         ->get();

        // Get views for the last [X] days
        $views = View::select('created_at')
                     ->whereIn('post_id', $published->pluck('id'))
                     ->whereBetween('created_at', [
                         today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
                         today()->endOfDay()->toDateTimeString(),
                     ])->get();

        return response()->json([
            'view_count'      => $views->count(),
            'view_trend'      => json_encode($this->getViewCounts($views, self::DAYS_PRIOR)),
            'published_count' => $published->count(),
            'draft_count'     => Post::forCurrentUser()->draft()->count(),
        ]);
    }

    /**
     * Get stats for a single post.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::forCurrentUser()->find($id);

        if ($post && $post->published) {
            return response()->json([
                'post'                  => $post,
                'popular_reading_times' => $post->popular_reading_times,
                'traffic'               => $post->top_referers,
                'trend'                 => $this->compareMonthToMonth($post->views),
                'views'                 => json_encode($this->getViewCounts($post->views, self::DAYS_PRIOR)),
            ]);
        } else {
            return response()->json(null, 301);
        }
    }
}
