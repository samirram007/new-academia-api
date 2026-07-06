<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\SettingService;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Http\Resources\Setting\SettingCollection;
use App\Http\Requests\Setting\StoreSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the current user's settings.
     */
    public function index(Request $request)
    {
        $data = app(SettingService::class)->getAll();
        return new SettingCollection($data);
    }

    /**
     * Store a newly created setting for the current user.
     */
    public function store(StoreSettingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $setting = Setting::updateOrCreate(
            ['user_id' => $data['user_id'], 'key' => $data['key']],
            ['value' => $data['value'] ?? '']
        );

        return new SettingResource($setting);
    }

    /**
     * Display the specified setting.
     */
    public function show(Request $request, Setting $setting)
    {
        if ($setting->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return new SettingResource($setting);
    }

    /**
     * Update the specified setting.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        if ($setting->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $setting->update($request->validated());
        return new SettingResource($setting);
    }

    /**
     * Remove the specified setting.
     */
    public function destroy(Request $request, Setting $setting)
    {
        if ($setting->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $setting->delete();
        return response(null, 204);
    }

    /**
     * Bulk upsert settings for the current user.
     * Accepts an array of { key, value } objects.
     */
    public function bulkUpsert(Request $request)
    {
        $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string', 'max:255'],
            'settings.*.value' => ['nullable', 'string'],
        ]);

        $userId = $request->user()->id;
        $results = [];

        foreach ($request->settings as $item) {
            $setting = Setting::updateOrCreate(
                ['user_id' => $userId, 'key' => $item['key']],
                ['value' => $item['value'] ?? '']
            );
            $results[] = new SettingResource($setting);
        }

        return response()->json([
            'data' => $results,
            'message' => 'Settings saved successfully',
        ]);
    }

    /**
     * Get a single setting by key for the current user.
     */
    public function getByKey(Request $request, string $key)
    {
        $setting = Setting::where('user_id', $request->user()->id)
            ->where('key', $key)
            ->first();

        if (!$setting) {
            return response()->json(['data' => null], 200);
        }

        return new SettingResource($setting);
    }
}
