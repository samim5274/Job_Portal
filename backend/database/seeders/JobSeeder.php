<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->all(); // categories না থাকলে []

        $jobs = [
            ['title'=>'Laravel Developer','company'=>'TechNova Ltd','location'=>'Dhaka','description'=>'Build and maintain web applications using Laravel, REST APIs, and MySQL.'],
            ['title'=>'Vue.js Frontend Developer','company'=>'PixelWave Studio','location'=>'Dhaka','description'=>'Develop modern UI with Vue 3, TailwindCSS, and component-based architecture.'],
            ['title'=>'UI/UX Designer','company'=>'Creative Hub','location'=>'Chattogram','description'=>'Design user-friendly interfaces, wireframes, and prototypes for web/mobile apps.'],
            ['title'=>'Digital Marketing Executive','company'=>'BrandLift','location'=>'Sylhet','description'=>'Manage social media campaigns, SEO basics, and performance reporting.'],
            ['title'=>'Accounts Officer','company'=>'FinSure Partners','location'=>'Dhaka','description'=>'Handle daily accounts, invoicing, and basic financial reporting.'],
            ['title'=>'HR Executive','company'=>'PeopleFirst','location'=>'Rajshahi','description'=>'Recruitment support, employee records, and HR documentation.'],
            ['title'=>'Customer Support Representative','company'=>'HelpDesk Pro','location'=>'Khulna','description'=>'Assist customers via phone/chat, resolve tickets, and escalate issues when needed.'],
            ['title'=>'Civil Engineer','company'=>'BuildRight Engineering','location'=>'Gazipur','description'=>'Site supervision, quality checks, and preparing basic reports.'],
            ['title'=>'Math Teacher','company'=>'Bright Future Academy','location'=>'Dhaka','description'=>'Teach math to school students, prepare lesson plans and assessments.'],
            ['title'=>'Nurse','company'=>'CarePoint Hospital','location'=>'Chattogram','description'=>'Provide patient care, assist doctors, and maintain nursing records.'],
            ['title'=>'Warehouse Supervisor','company'=>'LogiTrack','location'=>'Narayanganj','description'=>'Manage inventory flow, supervise loading/unloading, and ensure safety.'],
            ['title'=>'Sales Executive','company'=>'SkyMart','location'=>'Dhaka','description'=>'Client visits, lead generation, and achieving monthly sales targets.'],
            ['title'=>'Graphic Designer','company'=>'DesignCraft','location'=>'Barishal','description'=>'Create social media posts, banners, and brand assets using design tools.'],
            ['title'=>'Backend Engineer (PHP)','company'=>'CodeBridge','location'=>'Dhaka','description'=>'Develop backend services, optimize queries, and integrate third-party APIs.'],
            ['title'=>'Content Writer','company'=>'WriteWell Media','location'=>'Rangpur','description'=>'Write SEO-friendly articles, product descriptions, and website content.'],
        ];

        foreach ($jobs as $index => $job) {
            // user_id: 1-10 (cycle)
            $userId = ($index % 10) + 1;

            Job::create([
                'user_id' => $userId,
                'category_id' => !empty($categoryIds) ? $categoryIds[array_rand($categoryIds)] : null,
                'title' => $job['title'],
                'company' => $job['company'],
                'location' => $job['location'],
                'description' => $job['description'],
                'is_active' => true,
            ]);
        }
    }
}
