<?php

namespace App\Traits;

use App\Http\Facades\AcademicSessionFacade;
use App\Models\Setting;
use Illuminate\Http\Request;

trait HasAcademicSession
{
    /**
     * Get the academic_session_id from the request, falling back to
     * the Setting (current-academic-session), then to the current
     * academic session via the facade, and finally to the user's
     * stored academic session.
     */
    protected function getAcademicSessionId(Request $request): ?int
    {
        if ($request->has('academic_session_id') && $request->filled('academic_session_id')) {
            return (int) $request->academic_session_id;
        }

        $academicSessionSetting = Setting::where('key', 'current-academic-session')->first();

        if ($academicSessionSetting && $academicSessionSetting->value) {
            $decoded = json_decode($academicSessionSetting->value);
            if ($decoded && isset($decoded->sessionId)) {
                return (int) $decoded->sessionId;
            }
        }

        $academicSession = AcademicSessionFacade::getCurrentAcademicSession();
        if ($academicSession) {
            return $academicSession->id;
        }

        $user = auth()->user();

        return $user?->academic_session_id;
    }

    /**
     * Same as getAcademicSessionId but aborts with a 400 response
     * if no session can be resolved. Returns a non-null int.
     */
    protected function resolveAcademicSessionId(Request $request): int
    {
        $id = $this->getAcademicSessionId($request);

        if (!$id) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please configure your academic session first.'],
            ]));
        }

        return $id;
    }
}
