<?php

/**
 * Batch-update all remaining backend controllers to use applyAdvancedFilter()
 */

$replacements = [];

// ─── FeeItemController ──────────────────────────────────────────
$replacements['app/Http/Controllers/Api/FeeItemController.php'] = [
    'pattern' => "/public function index\(\)\s*\n\s*\{[\s\n]*\$data=FeeItem::with\('fee_item_months'\)->all\(\);\s*\n\s*return \$data;[\s\n]*\n\s*\}/s",
    'replacement' => 'public function index(Request $request)
    {
        $query = FeeItem::with(\'fee_item_months\');
        return $this->applyAdvancedFilter($query, $request);
    }',
];

// ─── FeeItemMonthController ────────────────────────────────────
$replacements['app/Http/Controllers/Api/FeeItemMonthController.php'] = [
    'pattern' => "/public function index\(\)\s*\n\s*\{[\s\n]*\$data=FeeItemMonth::all\(\);\s*\n\s*return \$data;[\s\n]*\n\s*\}/s',
    'replacement' => 'public function index(Request $request)
    {
        $query = FeeItemMonth::query();
        return $this->applyAdvancedFilter($query, $request);
    }',
];

// ─── FeeReceiptController ──────────────────────────────────────
$replacements['app/Http/Controllers/Api/FeeReceiptController.php'] = [
    'pattern' => "/public function index\(\)\s*\n\s*\{[\s\n]*\$receipts = FeeReceipt::with\('paidBy', 'fees'\)\s*\n\s*->orderBy\('id', 'desc'\)\s*\n\s*->paginate\(20\);[\s\n]*\n\s*return new FeeReceiptCollection\(\$receipts\);[\s\n]*\n\s*\}/s',
    'replacement' => 'public function index(Request $request)
    {
        $query = FeeReceipt::with(\'paidBy\', \'fees\');
        return new FeeReceiptCollection($this->applyAdvancedFilter($query, $request));
    }',
];

// ─── BuildingController ─────────────────────────────────────
$replacements['app/Http/Controllers/Api/BuildingController.php'] = [
    'pattern' => "/return new BuildingCollection\(Building::with\(\$this->resource\)\s*\n\s*->where\('campus_id',\$request->input\('campus_id'\)\)\s*\n\s*->get\(\)\);/s',
    'replacement' => 'return new BuildingCollection($this->applyAdvancedFilter(
            Building::with($this->resource ?? [])->where(\'campus_id\', $request->input(\'campus_id\')),
            $request
        ));',
];

// ─── FloorController ───────────────────────────────────────────
$replacements['app/Http/Controllers/Api/FloorController.php'] = [
    'pattern' => "/return new FloorCollection\(Floor::with\(\$this->resource\)\s*\n\s*->where\('building_id',\$request->input\('building_id'\)\)\s*\n\s*->get\(\)\);/s",
    'replacement' => 'return new FloorCollection($this->applyAdvancedFilter(
            Floor::with($this->resource ?? [])->where(\'building_id\', $request->input(\'building_id\')),
            $request
        ));',
];

// ─── RoomController ─────────────────────────────────────────
$replacements['app/Http/Controllers/Api/RoomController.php'] = [
    'pattern' => "/return new RoomCollection\(Room::with\(\$this->resource\)\s*\n\s*->where\('floor_id',\$request->input\('floor_id'\)\)\s*\n\s*->get\(\)\);/s",
    'replacement' => 'return new RoomCollection($this->applyAdvancedFilter(
            Room::with($this->resource ?? [])->where(\'floor_id\', $request->input(\'floor_id\')),
            $request
        ));',
];

// ─── SubjectController ───────────────────────────────────────
$replacements['app/Http/Controllers/Api/SubjectController.php'] = [
    'pattern' => "/return new SubjectCollection\(Subject::with\(\$this->resource\)\s*\n\s*->where\('academic_standard_id',\$request->input\('academic_standard_id'\)\)\s*\n\s*->where\('subject_group_id',\$request->input\('subject_group_id'\)\)\s*\n\s*->get\(\)\);/s',
    'replacement' => 'return new SubjectCollection($this->applyAdvancedFilter(
            Subject::with($this->resource ?? [])
                ->where(\'academic_standard_id\', $request->input(\'academic_standard_id\'))
                ->where(\'subject_group_id\', $request->input(\'subject_group_id\')),
            $request
        ));',
];

// ─── FeeTemplateController ──────────────────────────────────
$replacements['app/Http/Controllers/Api/FeeTemplateController.php'] = [
    'pattern' => "/\$thisData= new FeeTemplateCollection\(\s*\n\s*FeeTemplate::with\(\$this->resource\)\s*\n\s*->withCount\('fees'\)\s*\n\s*->where\('academic_class_id',\$request->input\('academic_class_id'\)\)\s*\n\s*->orderBy\('is_active','desc'\)\s*\n\s*->orderBy\('name','asc'\)\s*\n\s*->get\(\)\);\s*\n\s*\n\s*\n\s*return\s+\$thisData;/s',
    'replacement' => 'return new FeeTemplateCollection($this->applyAdvancedFilter(
            FeeTemplate::with($this->resource ?? [])
                ->withCount(\'fees\')
                ->where(\'academic_class_id\', $request->input(\'academic_class_id\')),
            $request
        ));',
];

// ─── FeeTemplateItemController ─────────────────────────────
$replacements['app/Http/Controllers/Api/FeeTemplateItemController.php'] = [
    'pattern' => "/return new FeeTemplateItemCollection\(\s*\n\s*FeeTemplateItem::with\(\$this->resource\)\s*\n\s*->where\('fee_template_id',\$request->input\('fee_template_id'\)\)\s*\n\s*->orderBy\('sort_index','ASC'\)\s*\n\s*->get\(\)\);/s',
    'replacement' => 'return new FeeTemplateItemCollection($this->applyAdvancedFilter(
            FeeTemplateItem::with($this->resource ?? [])
                ->where(\'fee_template_id\', $request->input(\'fee_template_id\')),
            $request
        ));',
];

// ─── FeeController ──────────────────────────────────────────
$replacements['app/Http/Controllers/Api/FeeController.php'] = [
    'pattern' => "/\$fees = Fee::with\(\s*\n\s+'fee_template',\s*\n\s+'academic_session',\s*\n\s+'student',\s*\n\s+'academic_class',\s*\n\s+'campus',\s*\n\s+'student_session',\s*\n\s+'student_session\.campus',\s*\n\s+'student_session\.academic_class',\s*\n\s+'student_session\.academic_session',\s*\n\s+'student_session\.section',\s*\n\s+'student_session\.fee_item_months',\s*\n\s*\n\s+'fee_items',\s*\n\s+'fee_items\.fee_head',\s*\n\s+'fee_items\.fee_item_months',\s*\n\s+'fee_items\.fee_item_months\.month',\s*\n\s+'campus',\s*\n\s+'campus\.school',\s*\n\s+'campus\.school\.address',\s*\n\s+'campus\.school\.logo_image'\s*\n\s*\)\s*\n\s*->where\('academic_session_id', \$request->academic_session_id\)\s*\n\s*->where\('is_deleted', '!=', 1\)\s*\n\s*->whereBetween\('fee_date', \[\$request->input\('from'\), \$request->input\('to'\)\]\)\s*\n\s*->orderBy\('id', 'desc'\)\s*\n\s*->get\(\);\s*\n\s*\n\s*return new FeeCollection\(\$fees\);/s',
    'replacement' => '$query = Fee::with([
            \'fee_template\',
            \'academic_session\',
            \'student\',
            \'academic_class\',
            \'campus\',
            \'student_session\',
            \'student_session.campus\',
            \'student_session.academic_class\',
            \'student_session.academic_session\',
            \'student_session.section\',
            \'student_session.fee_item_months\',
            \'fee_items\',
            \'fee_items.fee_head\',
            \'fee_items.fee_item_months\',
            \'fee_items.fee_item_months.month\',
            \'campus\',
            \'campus.school\',
            \'campus.school.address\',
            \'campus.school.logo_image\',
        ])
            ->where(\'academic_session_id\', $request->academic_session_id)
            ->where(\'is_deleted\', \'!=\', 1);
        return new FeeCollection($this->applyAdvancedFilter($query, $request, [\'dateField\' => \'fee_date\']));',
];

// ─── ExpenseController ─────────────────────────────────────────
$replacements['app/Http/Controllers/Api/ExpenseController.php'] = [
    'pattern' => "/\$expenses = Expense::with\(\$this->resource\)\s*\n\s*->where\('academic_session_id', \$request->input\('academic_session_id'\)\)\s*\n\s*->whereBetween\('expense_date',\[\$request->input\('from'\),\$request->input\('to'\)\]\)\s*\n\s*->orderBy\('expense_date', 'desc'\)\s*\n\s*->orderBy\('id', 'desc'\)\s*\n\s*->get\(\);/s',
    'replacement' => '$query = Expense::with($this->resource ?? [])
            ->where(\'academic_session_id\', $request->input(\'academic_session_id\'));
        return new ExpenseCollection($this->applyAdvancedFilter($query, $request, [\'dateField\' => \'expense_date\']));',
];

// ─── SettingsController ─────────────────────────────────────
$replacements['app/Http/Controllers/Api/SettingsController.php'] = [
    'pattern' => "/\$settings = Setting::where\('user_id', \$request->user\(\)->id\)\s*\n\s*->paginate\(\$request->per_page \?\? 50\);\s*\n\s*\n\s*return new SettingCollection\(\$settings\);/s',
    'replacement' => '$query = Setting::where(\'user_id\', $request->user()->id);
        return new SettingCollection($this->applyAdvancedFilter($query, $request));',
];

// ─── UserController ─────────────────────────────────────────
$replacements['app/Http/Controllers/Api/UserController.php'] = [
    'pattern' => "/return new UserCollection\(\s*\n\s*\$request->per_page\s*\n\s*\? User::with\(\$this->resource\)\s*\n\s*->where\('user_type',\$request->has\('user_type'\) \? \$request->user_type:true\)->paginate\(\$request->per_page\)\s*\n\s*: User::with\(\$this->resource\)\s*\n\s*->where\('user_type',\$request->has\('user_type'\) \? \$request->user_type:true\)\s*\n\s*->get\(\)\s*\n\s*\);/s',
    'replacement' => '$query = User::with($this->resource ?? []);
        if ($request->has(\'user_type\')) {
            $query->where(\'user_type\', $request->user_type);
        }
        return new UserCollection($this->applyAdvancedFilter($query, $request));',
];

// ─── GuardianController ─────────────────────────────────────
$replacements['app/Http/Controllers/Api/GuardianController.php'] = [
    'pattern' => "/return new UserCollection\(\s*\n\s*\$request->per_page\s*\n\s*\? User::with\(\$this->resource\)\s*\n\s*->where\('user_type',\$request->has\('user_type'\) \? \$request->user_type:true\)->paginate\(\$request->per_page\)\s*\n\s*: User::with\(\$this->resource\)\s*\n\s*->where\('user_type',\$request->has\('user_type'\) \? \$request->user_type:true\)\s*\n\s*->get\(\)\s*\n\s*\);/s',
    'replacement' => '$query = User::with($this->resource ?? []);
        if ($request->has(\'user_type\')) {
            $query->where(\'user_type\', $request->user_type);
        }
        return new UserCollection($this->applyAdvancedFilter($query, $request));',
];

// ─── StudentSessionController ──────────────────────────────
$replacements['app/Http/Controllers/Api/StudentSessionController.php'] = [
    'pattern' => "/if \(\$request->has\('academic_class_id'\)\) \{\s*\n\s+\$studentSessions = StudentSession::with\(\$this->foreignLoader\)\s*\n\s+->where\('academic_session_id', \$request->input\('academic_session_id'\)\)\s*\n\s+->where\('academic_class_id', \$request->input\('academic_class_id'\)\)\s*\n\s+->get\(\);\s*\n\s+return new StudentSessionCollection\(\$studentSessions\);\s*\n\s+\}\s*\n\s+\$studentSessions = StudentSession::with\(\$this->foreignLoader\)\s*\n\s+->where\('academic_session_id', \$request->input\('academic_session_id'\)\)\s*\n\s+->get\(\);\s*\n\s+\/\/ dd\(\$studentSessions\);\s*\n\s+return new StudentSessionCollection\(\$studentSessions\);/s',
    'replacement' => '$query = StudentSession::with($this->foreignLoader ?? [])
            ->where(\'academic_session_id\', $request->input(\'academic_session_id\'));
        if ($request->has(\'academic_class_id\')) {
            $query->where(\'academic_class_id\', $request->input(\'academic_class_id\'));
        }
        return new StudentSessionCollection($this->applyAdvancedFilter($query, $request));',
];

// ─── StudentIdCardController ────────────────────────────────
$replacements['app/Http/Controllers/Api/StudentIdCardController.php'] = [
    'pattern' => "/\$users = User::with\(\$this->resource\)\s*\n\s*->where\('user_type', 'student'\)\s*\n\s*->whereIn\('id', function \(\$query\) use \(\$request\) \{\s*\n\s+\$query->select\('student_id'\)\s*\n\s+->from\('student_sessions'\)\s*\n\s+->whereIn\('academic_session_id', \[\$request->input\('academic_session_id'\)\]\)\s*\n\s+->whereIn\('academic_class_id', \[\$request->input\('academic_class_id'\)\]\);\s*\n\s+}\)->get\(\);\s*\n\s+return new StudentCollection\(\$users\);/s',
    'replacement' => '$users = User::with($this->resource ?? [])
            ->where(\'user_type\', \'student\')
            ->whereIn(\'id\', function ($query) use ($request) {
                $query->select(\'student_id\')
                    ->from(\'student_sessions\')
                    ->where(\'academic_session_id\', $request->input(\'academic_session_id\'))
                    ->where(\'academic_class_id\', $request->input(\'academic_class_id\'));
            });
        return new StudentCollection($this->applyAdvancedFilter($users, $request));',
];

// ─── PromotionController ─────────────────────────────────────
$replacements['app/Http/Controllers/Api/PromotionController.php'] = [
    'pattern' => "/if \(\$request->has\('section_id'\) && \$request->input\('section_id'\)\) \{\s*\n\s+\$thisLoader = \[.+\];\s*\n\s+\$users = User::with\(\$thisLoader\)\s*\n\s+->where\('user_type', 'student'\)\s*\n\s+->whereIn\('id', function \(\$query\) use \(\$request\) \{\s*\n\s+\$query->select\('student_id'\)\s*\n\s+->from\('student_sessions'\)\s*\n\s+->where\('academic_session_id', \$request->input\('academic_session_id'\)\)\s*\n\s+->whereIn\('academic_class_id', \[\$request->input\('academic_class_id'\)\]\)\s*\n\s+->whereIn\('section_id', \[\$request->input\('section_id'\)\]\);\s*\n\s+}\)->get\(\);\s*\n\s+return new StudentCollection\(\$users\);\s*\n\s+\}\s*\n\s+\$thisLoader = \[.+\];\s*\n\s+\$users = User::with\(\$thisLoader\)\s*\n\s+->where\('user_type', 'student'\)\s*\n\s+->whereIn\('id', function \(\$query\) use \(\$request\) \{\s*\n\s+\$query->select\('student_id'\)\s*\n\s+->from\('student_sessions'\)\s*\n\s+->whereIn\('academic_session_id', \[\$request->input\('academic_session_id'\)\]\)\s*\n\s+->whereIn\('academic_class_id', \[\$request->input\('academic_class_id'\)\]\);\s*\n\s+}\)->get\(\);\s*\n\s+return new StudentCollection\(\$users\);/s',
    'replacement' => '$loader = $this->getPromotionLoader($request);
        $query = User::with($loader)
            ->where(\'user_type\', \'student\')
            ->whereIn(\'id\', function ($query) use ($request) {
                $query->select(\'student_id\')
                    ->from(\'student_sessions\')
                    ->where(\'academic_session_id\', $request->input(\'academic_session_id\'))
                    ->where(\'academic_class_id\', $request->input(\'academic_class_id\'));
                if ($request->has(\'section_id\') && $request->input(\'section_id\')) {
                    $query->where(\'section_id\', $request->input(\'section_id\'));
                }
            });
        return new StudentCollection($this->applyAdvancedFilter($query, $request));',
];

// ─── StudentController ────────────────────────────────────────
// This one is complex enough that I need to preserve the custom logic
$replacements['app/Http/Controllers/Api/StudentController.php'] = [
    'pattern' => "/if \(\$request->input\('filter_option'\) == 'active'\) \{\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?->get\(\);.*?\n\s+.*?\n\s+.*?\n\s+\} elseif \(\$request->input\('filter_option'\) == 'admission'\) \{\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?\s*\n\s+.*?->get\(\);.*?\n\s+.*?\n\s+.*?\n\s+.*?\n\s+.*?\n\s+.*?\n\s+.*?\n\s+.*?->get\(\);.*?\n\s+.*?\n\s+\} else \{\s*\n\s+.*?\n\s+\}/s',
    'replacement' => 'return $this->handleFilteredStudents($request);',
];

$updated = 0;
$failed = 0;

foreach ($replacements as $file => $config) {
    if (!file_exists($file)) {
        echo "NOT FOUND: $file\n";
        $failed++;
        continue;
    }
    $content = file_get_contents($file);
    $original = $content;
    
    $count = 0;
    $content = preg_replace($config['pattern'], $config['replacement'], $content, -1, $count);
    
    if ($content !== $original && $count > 0) {
        file_put_contents($file, $content);
        echo "UPDATED: $file\n";
        $updated++;
    } else {
        // Try with escaped dollar signs
        $content = $original;
        $content = preg_replace($config['pattern'], $config['replacement'], $content, -1, $count);
        if ($content !== $original && $count > 0) {
            file_put_contents($file, $content);
            echo "UPDATED (retry): $file\n";
            $updated++;
        } else {
            echo "NO MATCH: $file\n";
            $failed++;
        }
    }
}

echo "\nUpdated: $updated, Failed: $failed\n";
