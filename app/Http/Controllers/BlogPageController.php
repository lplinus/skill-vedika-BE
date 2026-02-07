<?php

namespace App\Http\Controllers;

use App\Models\BlogPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogPageController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => BlogPageContent::latest()->first() ?? new \stdClass()
        ]);
    }
    

    public function update(Request $request)
    {
        try {
            $content = new BlogPageContent();

            // HERO TITLE
            $content->hero_title = $this->normalizeTitle(
                $request->input('hero_title', [])
            );

            // DEMO TITLE
            $content->demo_title = $this->normalizeTitle(
                $request->input('demo_title', [])
            );

            // DEMO POINTS — FORCE {title}
            $demoPoints = [];
            foreach ($request->input('demo_points', []) as $p) {
                $demoPoints[] = [
                    'title' => is_array($p) ? ($p['title'] ?? '') : ''
                ];
            }
            $content->demo_points = $demoPoints;

            // SIMPLE FIELDS
            $content->hero_description = $request->hero_description;
            $content->sidebar_name     = $request->sidebar_name;
            $content->hero_image       = $request->hero_image;
            $content->demo_subtitle    = $request->demo_subtitle;

            $content->save();

            return response()->json([
                'message' => 'Blog page saved successfully',
                'data' => $content
            ]);

        } catch (\Throwable $e) {
            Log::error('BLOG PAGE SAVE FAILED', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function normalizeTitle(array $title): array
    {
        $text = trim($title['text'] ?? '');

        if ($text === '') {
            return [
                'text' => '',
                'part1' => null,
                'part2' => null
            ];
        }

        $words = preg_split('/\s+/', $text);

        if (count($words) >= 4) {
            return [
                'text' => $text,
                'part1' => implode(' ', array_slice($words, 0, -2)),
                'part2' => implode(' ', array_slice($words, -2)),
            ];
        }

        return [
            'text' => $text,
            'part1' => null,
            'part2' => null
        ];
    }
}
