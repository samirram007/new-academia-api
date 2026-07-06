<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookModule;
use App\Models\Subject;
use App\Models\AcademicStandard;
use Illuminate\Database\Seeder;

class BookDemoSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();
        $standards = AcademicStandard::all();

        if ($subjects->isEmpty()) {
            $this->command->warn('No subjects found. Skipping book demo seed.');
            return;
        }

        // ─── Book definitions ──────────────────────────────────────
        // Each book is tied to a subject and optionally an academic standard.
        $bookDefs = [
            // Mathematics
            ['name' => 'Mathematics Textbook', 'code' => 'MATH-01', 'subject' => 'Mathematics', 'author' => 'R.D. Sharma', 'publisher' => 'Dhanpat Rai Publications', 'publication_year' => 2024, 'page_count' => 450, 'price' => 650.00],
            ['name' => 'Mathematics Workbook', 'code' => 'MATH-02', 'subject' => 'Mathematics', 'author' => 'R.S. Aggarwal', 'publisher' => 'S. Chand Publishing', 'publication_year' => 2024, 'page_count' => 320, 'price' => 480.00],

            // Science
            ['name' => 'General Science', 'code' => 'SCI-01', 'subject' => 'Science', 'author' => 'Lakhmir Singh', 'publisher' => 'S. Chand Publishing', 'publication_year' => 2024, 'page_count' => 380, 'price' => 550.00],
            ['name' => 'Environmental Studies', 'code' => 'SCI-02', 'subject' => 'Science', 'author' => 'Erach Bharucha', 'publisher' => 'NCERT', 'publication_year' => 2023, 'page_count' => 220, 'price' => 350.00],

            // English
            ['name' => 'English Literature', 'code' => 'ENG-01', 'subject' => 'English', 'author' => 'Multiple Authors', 'publisher' => 'Oxford University Press', 'publication_year' => 2024, 'page_count' => 280, 'price' => 520.00],
            ['name' => 'English Grammar & Composition', 'code' => 'ENG-02', 'subject' => 'English', 'author' => 'Wren & Martin', 'publisher' => 'S. Chand Publishing', 'publication_year' => 2023, 'page_count' => 350, 'price' => 490.00],

            // Hindi
            ['name' => 'Hindi Vyakaran', 'code' => 'HIN-01', 'subject' => 'Hindi', 'author' => 'Dr. Vashishta', 'publisher' => 'NCERT', 'publication_year' => 2024, 'page_count' => 200, 'price' => 320.00],
            ['name' => 'Hindi Sahitya', 'code' => 'HIN-02', 'subject' => 'Hindi', 'author' => 'Acharya Ramchandra Shukla', 'publisher' => 'Vani Prakashan', 'publication_year' => 2023, 'page_count' => 310, 'price' => 430.00],

            // Social Studies
            ['name' => 'Social Studies', 'code' => 'SST-01', 'subject' => 'Social Studies', 'author' => 'NCERT Panel', 'publisher' => 'NCERT', 'publication_year' => 2024, 'page_count' => 290, 'price' => 400.00],
            ['name' => 'History & Civics', 'code' => 'SST-02', 'subject' => 'Social Studies', 'author' => 'Arjun Dev', 'publisher' => 'NCERT', 'publication_year' => 2024, 'page_count' => 260, 'price' => 380.00],

            // Computer Science
            ['name' => 'Computer Science Fundamentals', 'code' => 'CS-01', 'subject' => 'Computer Science', 'author' => 'Sumita Arora', 'publisher' => 'Dhanpat Rai Publications', 'publication_year' => 2024, 'page_count' => 420, 'price' => 600.00],
            ['name' => 'Python Programming', 'code' => 'CS-02', 'subject' => 'Computer Science', 'author' => 'Vimal K. Sharma', 'publisher' => 'BPB Publications', 'publication_year' => 2024, 'page_count' => 360, 'price' => 540.00],
        ];

        $createdBooks = [];

        foreach ($bookDefs as $def) {
            $subject = $subjects->firstWhere('name', $def['subject']);
            if (!$subject) {
                // Try case-insensitive match
                $subject = $subjects->first(fn($s) => strcasecmp($s->name, $def['subject']) === 0);
            }

            // Assign to a standard if this subject has standard associations
            $standardId = null;
            if ($standards->isNotEmpty()) {
                $standard = $standards->random();
                $standardId = $standard->id;
            }

            $book = Book::firstOrCreate(
                ['code' => $def['code']],
                [
                    'name' => $def['name'],
                    'description' => "{$def['name']} - Standard textbook for {$def['subject']}",
                    'subject_id' => $subject ? $subject->id : $subjects->first()->id,
                    'publication_year' => $def['publication_year'],
                    'page_count' => $def['page_count'],
                    'price' => $def['price'],
                    'author' => $def['author'],
                    'publisher' => $def['publisher'],
                ]
            );

            $createdBooks[] = $book;
        }

        // ─── Book Modules ──────────────────────────────────────────
        $moduleDefs = [
            'Mathematics Textbook' => [
                ['name' => 'Number Systems', 'description' => 'Introduction to number systems including natural numbers, integers, rational and irrational numbers'],
                ['name' => 'Algebra', 'description' => 'Basic algebraic expressions, equations, and operations'],
                ['name' => 'Geometry', 'description' => 'Fundamentals of Euclidean geometry, shapes, and theorems'],
                ['name' => 'Mensuration', 'description' => 'Area, volume, and surface area calculations'],
                ['name' => 'Statistics & Probability', 'description' => 'Data handling, measures of central tendency, and probability basics'],
            ],
            'General Science' => [
                ['name' => 'Physics Basics', 'description' => 'Motion, force, energy, and simple machines'],
                ['name' => 'Chemistry Fundamentals', 'description' => 'Matter, atoms, molecules, and chemical reactions'],
                ['name' => 'Biology Essentials', 'description' => 'Living organisms, cells, plants, and human body systems'],
                ['name' => 'Earth & Space', 'description' => 'Earth structure, weather, solar system, and universe'],
            ],
            'English Literature' => [
                ['name' => 'Prose', 'description' => 'Short stories, essays, and narrative prose pieces'],
                ['name' => 'Poetry', 'description' => 'Poetic forms, meter, rhyme schemes, and analysis'],
                ['name' => 'Drama', 'description' => 'One-act plays, dialogues, and dramatic techniques'],
            ],
            'Social Studies' => [
                ['name' => 'Ancient History', 'description' => 'Early civilizations, ancient empires, and cultural developments'],
                ['name' => 'Modern History', 'description' => 'Colonial period, independence movements, and contemporary world'],
                ['name' => 'Geography', 'description' => 'Physical geography, maps, climate, and natural resources'],
                ['name' => 'Civics', 'description' => 'Government structure, constitution, rights, and duties'],
            ],
            'Computer Science Fundamentals' => [
                ['name' => 'Computer Basics', 'description' => 'Hardware, software, operating systems, and computer organization'],
                ['name' => 'Programming Concepts', 'description' => 'Algorithms, flowcharts, and introduction to programming logic'],
                ['name' => 'Data Structures', 'description' => 'Arrays, linked lists, stacks, queues, and trees'],
                ['name' => 'Database Management', 'description' => 'Introduction to databases, SQL, and data storage'],
            ],
        ];

        foreach ($createdBooks as $book) {
            $defs = $moduleDefs[$book->name] ?? [
                ['name' => 'Introduction', 'description' => "Introduction to {$book->name}"],
                ['name' => 'Core Concepts', 'description' => "Core concepts and principles of {$book->name}"],
                ['name' => 'Advanced Topics', 'description' => "Advanced topics in {$book->name}"],
            ];

            foreach ($defs as $moduleDef) {
                BookModule::firstOrCreate(
                    ['book_id' => $book->id, 'name' => $moduleDef['name']],
                    ['description' => $moduleDef['description']]
                );
            }
        }

        // ─── Book Chapters ─────────────────────────────────────────
        $chapterDefs = [
            'Mathematics Textbook - Number Systems' => [
                'Natural Numbers', 'Integers', 'Rational Numbers', 'Irrational Numbers', 'Real Numbers',
            ],
            'Mathematics Textbook - Algebra' => [
                'Algebraic Expressions', 'Linear Equations', 'Quadratic Equations', 'Polynomials', 'Factorization',
            ],
            'Mathematics Textbook - Geometry' => [
                'Points and Lines', 'Angles', 'Triangles', 'Circles', 'Quadrilaterals',
            ],
            'Mathematics Textbook - Mensuration' => [
                'Perimeter and Area', 'Surface Area', 'Volume', 'Composite Shapes',
            ],
            'General Science - Physics Basics' => [
                'Motion and Speed', 'Forces and Newton\'s Laws', 'Energy Forms', 'Simple Machines', 'Sound and Light',
            ],
            'General Science - Chemistry Fundamentals' => [
                'States of Matter', 'Atoms and Elements', 'Chemical Bonding', 'Acids and Bases', 'Chemical Reactions',
            ],
            'General Science - Biology Essentials' => [
                'Cell Structure', 'Plant Kingdom', 'Human Body Systems', 'Reproduction', 'Ecosystems',
            ],
            'English Literature - Prose' => [
                'The Lost Child', 'The Adventures of Toto', 'The Last Leaf', 'A House is Not a Home',
            ],
            'English Literature - Poetry' => [
                'The Road Not Taken', 'Stopping by Woods', 'Daffodils', 'Ode to Autumn',
            ],
            'Social Studies - Ancient History' => [
                'Indus Valley Civilization', 'Vedic Period', 'Mauryan Empire', 'Gupta Empire',
            ],
            'Social Studies - Modern History' => [
                'Colonial Rule in India', 'The Revolt of 1857', 'Indian Independence Movement', 'Post-Independence India',
            ],
            'Social Studies - Geography' => [
                'Earth and its Movements', 'Climate and Seasons', 'Natural Resources', 'Agriculture and Industry',
            ],
            'Social Studies - Civics' => [
                'The Constitution', 'The Legislature', 'The Executive', 'The Judiciary', 'Fundamental Rights and Duties',
            ],
        ];

        $modules = BookModule::all();
        foreach ($modules as $module) {
            $key = "{$module->book->name} - {$module->name}";
            $chapters = $chapterDefs[$key] ?? [
                "Chapter 1: Introduction to {$module->name}",
                "Chapter 2: Core {$module->name} Concepts",
                "Chapter 3: Advanced {$module->name}",
            ];

            foreach ($chapters as $index => $chapterName) {
                BookChapter::firstOrCreate(
                    ['book_id' => $module->book_id, 'name' => $chapterName],
                    [
                        'description' => "{$chapterName} - Detailed study of {$module->name}",
                    ]
                );
            }
        }

        $this->command->info(sprintf(
            'Seeded: %d books, %d modules, %d chapters',
            count($createdBooks),
            BookModule::count(),
            BookChapter::count()
        ));
    }
}
