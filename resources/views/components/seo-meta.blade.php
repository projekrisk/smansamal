@props([
    'title' => 'SMAN 1 Malingping - Cageur, Bageur, Bener, Pinter.',
    'description' => 'Portal resmi SMAN 1 Malingping, Lebak Banten. Membentuk generasi cerdas, berkarakter dengan 4 pilar Cageur, Bageur, Bener, Pinter dan berwawasan lingkungan.',
    'image' => asset('images/og-default.jpg'),
    'type' => 'website',
    'author' => 'SMAN 1 Malingping',
    'publishedTime' => null,
    'twitterCard' => 'summary_large_image',
    'keywords' => 'SMAN 1 Malingping, SMA Negeri 1 Malingping, Pagelaran Malingping, Sekolah Menengah Atas Lebak Banten, Berita SMAN 1 Malingping, Suara Warga SMAN 1 Malingping, Pendidikan Lebak, Alumni SMAN 1 Malingping, NPSN 20601836, Cageur Bageur Bener Pinter',
])

@php
    $absoluteImage = (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'))
        ? $image
        : url($image);

    $cleanDescription = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($description))), 160);
    $cleanTitle = trim($title);
    $currentUrl = url()->current();

    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => 'SMA Negeri 1 Malingping',
        'alternateName' => 'SMAN 1 Malingping',
        'url' => url('/'),
        'logo' => asset('icon.png'),
        'image' => asset('images/og-default.jpg'),
        'description' => 'Portal resmi dan literasi digital SMA Negeri 1 Malingping, Kabupaten Lebak, Banten.',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Raya Malingping - Binuangeun KM. 2, Desa Pagelaran',
            'addressLocality' => 'Malingping',
            'addressRegion' => 'Banten',
            'postalCode' => '42392',
            'addressCountry' => 'ID',
        ],
        'telephone' => '(0252) 508123',
        'email' => 'info@sman1malingping.sch.id',
        'identifier' => '20601836',
        'slogan' => 'Cageur, Bageur, Bener, Pinter.',
    ];

    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'SMA Negeri 1 Malingping',
        'alternateName' => 'SMAN 1 Malingping',
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => route('berita.index').'?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    $navigationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => [
            [
                '@type' => 'SiteNavigationElement',
                'position' => 1,
                'name' => 'Profil Sekolah',
                'description' => 'Profil, Visi Misi, dan Sejarah SMA Negeri 1 Malingping',
                'url' => route('profil-sekolah'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 2,
                'name' => 'Berita & Warta Sekolah',
                'description' => 'Informasi resmi, agenda kegiatan, dan prestasi SMAN 1 Malingping',
                'url' => route('berita.index'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 3,
                'name' => 'Suara Warga',
                'description' => 'Kanal literasi, opini, dan karya siswa, guru serta alumni',
                'url' => route('suara-warga.index'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 4,
                'name' => 'Kontak Resmi',
                'description' => 'Saluran komunikasi dan alamat resmi SMA Negeri 1 Malingping',
                'url' => route('contact'),
            ],
        ],
    ];

    $articleSchema = null;
    if ($type === 'article') {
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $currentUrl,
            ],
            'headline' => $cleanTitle,
            'image' => [$absoluteImage],
            'datePublished' => $publishedTime ?: now()->toIso8601String(),
            'dateModified' => $publishedTime ?: now()->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $author,
            ],
            'publisher' => [
                '@type' => 'EducationalOrganization',
                'name' => 'SMA Negeri 1 Malingping',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('icon.png'),
                ],
            ],
            'description' => $cleanDescription,
        ];
    }
@endphp

<title>{{ $cleanTitle }}</title>
<meta name="description" content="{{ $cleanDescription }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="{{ $currentUrl }}">

<meta name="geo.region" content="ID-BT">
<meta name="geo.placename" content="Malingping, Kabupaten Lebak, Banten">
<meta name="geo.position" content="-6.81524;105.99982">
<meta name="ICBM" content="-6.81524, 105.99982">

<link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
<link rel="shortcut icon" href="{{ asset('icon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

<meta property="og:site_name" content="SMA Negeri 1 Malingping">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:title" content="{{ $cleanTitle }}">
<meta property="og:description" content="{{ $cleanDescription }}">
<meta property="og:locale" content="id_ID">
<meta property="og:image" content="{{ $absoluteImage }}">
<meta property="og:image:secure_url" content="{{ $absoluteImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $cleanTitle }}">
@if($type === 'article')
@if($publishedTime)
<meta property="article:published_time" content="{{ $publishedTime }}">
<meta property="article:modified_time" content="{{ $publishedTime }}">
@endif
<meta property="article:author" content="{{ $author }}">
<meta property="article:section" content="Pendidikan & Literasi">
<meta property="article:publisher" content="{{ route('home') }}">
@endif

<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:url" content="{{ $currentUrl }}">
<meta name="twitter:title" content="{{ $cleanTitle }}">
<meta name="twitter:description" content="{{ $cleanDescription }}">
<meta name="twitter:image" content="{{ $absoluteImage }}">
<meta name="twitter:site" content="{{ '@sman1malingping' }}">
<meta name="twitter:creator" content="{{ '@sman1malingping' }}">

<script type="application/ld+json">
{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode($navigationSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

@if($articleSchema)
<script type="application/ld+json">
{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
