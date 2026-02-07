<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CourseDetail;
use App\Models\Course;

class CourseDetailsController extends Controller
{
    private const ERROR_NOT_FOUND = 'Course details not found';

    /* ======================================================
       GET /api/course-details?course_id=ID
    ====================================================== */
    public function index(Request $request)
    {
        $courseId = $request->query('course_id');

        if ($courseId) {
            return response()->json([
                'success' => true,
                'data' => CourseDetail::where('course_id', $courseId)->get()
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => CourseDetail::all()
        ]);
    }

    /* ======================================================
       GET /api/course-details/{id|slug|course_id}
    ====================================================== */
    public function show($identifier)
    {
        $detail = $this->findCourseDetail($identifier);

        if (!$detail) {
            return response()->json(['message' => self::ERROR_NOT_FOUND], 404);
        }

        return response()->json(['data' => $detail], 200);
    }

    /* ======================================================
       POST /api/course-details  (CREATE OR UPDATE)
    ====================================================== */
    public function store(Request $request)
    {
        try {
            // Normalize slug
            $slug = trim($request->slug ?? '') ?: null;
            $request->merge(['slug' => $slug]);

            // ✅ VALIDATION (FIXED)
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'subtitle'  => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:course_details,slug,' .
                CourseDetail::where('course_id', $request->course_id)->value('id')

            ], [
                'subtitle.required' => 'Subtitle is required',
                'slug.unique' => 'This slug is already in use'
            ]);

            // Generate slug if empty
            if (!$slug) {
                $course = Course::find($request->course_id);
                $slug = $this->generateSlug($course->title, $request->course_id);
            }

            // ✅ SAFE META STRUCTURE
            $metaJson = [
                'sections' => [
                    'why_choose' => [
                        'title' => $request->why_choose_title,
                        'description' => $request->why_choose_description,
                    ],
                    'who_should_join' => [
                        'title' => $request->who_should_join_title,
                        'description' => $request->who_should_join_description,
                    ],
                    'key_outcomes' => [
                        'title' => $request->key_outcomes_title,
                        'description' => $request->key_outcomes_description,
                    ],
                ]
            ];

            // ✅ UPSERT (CREATE OR UPDATE)
            $details = CourseDetail::updateOrCreate(
                ['course_id' => $request->course_id],
                [
                    'slug'             => $slug,
                    'subtitle'         => $request->subtitle,
                    'skill'            => $request->skill,
                    'trainers'         => $request->trainers ?? [],
                    'agenda'           => $request->agenda ?? [],
                    'why_choose'       => $request->why_choose ?? [],
                    'who_should_join'  => $request->who_should_join ?? [],
                    'key_outcomes'     => $request->key_outcomes ?? [],
                    'meta_title'       => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'meta_keywords'    => $request->meta_keywords,
                    'meta_json'        => $metaJson,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Course details saved successfully',
                'data' => $details
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $ve->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* ======================================================
       DELETE /api/course-details/{id|course_id}
    ====================================================== */
    public function destroy($id)
    {
        $details = $this->findCourseDetail($id);

        if (!$details) {
            return response()->json(['message' => self::ERROR_NOT_FOUND], 404);
        }

        $details->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course details deleted'
        ]);
    }

    /* ======================================================
       HELPERS
    ====================================================== */

    private function findCourseDetail($identifier)
    {
        if (!is_numeric($identifier)) {
            return CourseDetail::where('slug', $identifier)->first();
        }

        return CourseDetail::find($identifier)
            ?? CourseDetail::where('course_id', $identifier)->first();
    }

    private function generateSlug($title, $courseId)
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            CourseDetail::where('slug', $slug)
                ->where('course_id', '!=', $courseId)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
