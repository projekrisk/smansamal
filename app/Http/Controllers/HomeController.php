<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Page;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        $jurnalArticles = Article::with(['category', 'user'])
            ->withCount('comments')
            ->published()
            ->jurnal()
            ->latest('published_at')
            ->take(6)
            ->get();

        $suaraWargaArticles = Article::with(['category', 'user'])
            ->withCount('comments')
            ->published()
            ->suaraWarga()
            ->latest('published_at')
            ->take(3)
            ->get();

        $agendas = Agenda::active()
            ->orderBy('event_date', 'asc')
            ->take(10)
            ->get();

        $testimonials = Testimonial::with('user')
            ->approved()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact(
            'jurnalArticles',
            'suaraWargaArticles',
            'agendas',
            'testimonials'
        ));
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function profileSchool()
    {
        return view('pages.profil-sekolah');
    }

    public function contact(): View
    {
        $page = Page::where('slug', 'kontak')->first();

        if ($page && $page->is_active) {
            $page->increment('views_count');
        }

        return view('pages.kontak', compact('page'));
    }

    public function pedomanKomunitas()
    {
        return view('pages.pedoman-komunitas');
    }

    public function panduanSuaraWarga()
    {
        return view('pages.panduan-suara-warga');
    }

    public function sop(): View
    {
        return view('pages.sop');
    }

    public function activeAnnouncement(): JsonResponse
    {
        $announcement = Announcement::active()
            ->latest('id')
            ->first();

        if (! $announcement) {
            return response()->json(['active' => false]);
        }

        return response()->json([
            'active' => true,
            'id' => $announcement->id,
            'title' => $announcement->title,
            'content' => $announcement->content,
            'image_url' => $announcement->image_url,
            'button_text' => $announcement->button_text,
            'button_url' => $announcement->button_url,
        ]);
    }

    public function sitemap(): Response
    {
        $content = Cache::remember('sitemap_xml_content', 3600, function () {
            $articles = Article::published()->latest('published_at')->get();
            $pages = Page::active()->get();

            return view('sitemap', compact('articles', 'pages'))->render();
        });

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
