<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutPageContent;

class AboutPageController extends Controller
{
    /**
     * GET /api/about-page
     * Always return the single About page record
     */
    public function show()
    {
        // Try singleton row
        $data = AboutPageContent::find(1);

        if (!$data) {
            // Fallback: get latest existing record (production-safe)
            $latest = AboutPageContent::orderBy('id', 'desc')->first();

            if ($latest) {
                // Clone latest record into singleton id=1
                $data = AboutPageContent::updateOrCreate(
                    ['id' => 1],
                    $latest->toArray()
                );
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data ?? (object)[]
        ]);
    }


    /**
     * (Optional) index alias
     * Keep if frontend/admin already calls index
     */
    public function index()
    {
        return $this->show();
    }

    /**
     * POST /api/about-page
     * Create OR update the single About page record
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'aboutus_image'        => 'nullable|string',
            'aboutus_title'        => 'nullable|array',
            'aboutus_description'  => 'nullable|string',

            'demo_title'           => 'nullable|array',
            'demo_content'         => 'nullable|array',
        ]);

        // 🔒 SINGLETON PAGE (always id = 1)
        $record = AboutPageContent::updateOrCreate(
            ['id' => 1],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'About page content saved successfully',
            'data' => $record
        ], 201);
    }

    /**
     * PUT /api/about-page/{id}
     * Optional explicit update (not required by your admin)
     */
    public function update(Request $request, $id = 1)
    {
        $data = $request->validate([
            'aboutus_image'        => 'nullable|string',
            'aboutus_title'        => 'nullable|array',
            'aboutus_description'  => 'nullable|string',

            'demo_title'           => 'nullable|array',
            'demo_content'         => 'nullable|array',
        ]);

        $record = AboutPageContent::find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'About page content not found'
            ], 404);
        }

        $record->update($data);

        return response()->json([
            'success' => true,
            'message' => 'About page content updated successfully',
            'data' => $record
        ]);
    }

    /**
     * DELETE /api/about-page
     * Optional cleanup (usually not needed)
     */
    public function destroy()
    {
        $record = AboutPageContent::find(1);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Nothing to delete'
            ], 404);
        }

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'About page content deleted'
        ]);
    }
}
