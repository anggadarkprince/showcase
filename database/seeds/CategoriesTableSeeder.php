<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category' => 'Architecture, Planning & Environmental Design',
            'detail' => 'Architecture, Interior Design, Landscape Architecture, Sustainable Environmental Design, Urban & Regional Planning',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Education',
            'detail' => 'Teaching, Counseling, School Social Work, Speech Pathology, Library/Info Services',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'International',
            'detail' => 'Internships & Short-Term Work, Volunteering, Teaching, Translation & Interpretation, Tourism, Business, Research Abroad',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Art & Entertainment',
            'detail' => 'Arts Education/Therapy, Broadcasting, Fashion, Films, Museums, Performing Arts',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Engineering & Computer Science',
            'detail' => 'Aerospace, Civil/Environ, EECS, IEOR, Mech, MatSci, Nuclear, Statistics',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Law & Public Policy',
            'detail' => 'Law, Law Enforcement, Lobbying, Public Advocacy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Environment',
            'detail' => 'Forestry, Environmental Engineering, Environmental Consulting',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Non Profit',
            'detail' => 'Consumer Rights, Civil & Human Rights, Lobbying, Research, Social Work, Public Health',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Business',
            'detail' => 'Accounting, Consulting, HR, Insurance, Real Estate',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Communications',
            'detail' => 'Advertising, Journalism, Planning & Hospitality, Public Relations, Publishing, Technical Writing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Government',
            'detail' => 'Politics, Federal, State, Local, Military',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Sciences-Biological & Physical',
            'detail' => 'Agriculture, Bioinformatics, Biostatistics, Biotechnology, Botany, Forensic Science, Genetics, Marine Science, Science Education, Zoology',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categories')->insert([
            'category' => 'Health & Medicine',
            'detail' => 'Dentistry, Human Medicine, Optometry, Pharmacy, Public Health, Veterinary Medicine, Health Management',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
