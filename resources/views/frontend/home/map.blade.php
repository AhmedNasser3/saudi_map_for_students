
<div class="map_main">
    <div class="map_main_container">
        <div class="map_main_data">
            <div class="map_main_content">
                <div class="map_container">
                    <div class="map_img_1">
                    </div>
                    <div id="container" style="height: 500px;"></div>
                    <div class="map_img_2">
                    </div>
                </div>
                <div class="map_main_titles">
                    <h1>البورصة</h1>
                    <p>تميز على زملائك في الإنجاز اليومي" النجاح يبدأ بالاجتهاد والمثابرة، وكل خطوة بذكاء تقربك من هدفك.</p>
                    <div class="map_main_btn">
                        <div class="map_main_btn_1">
                            <button><a href="#info">شاهد التعليمات</a></button>
                        </div>
                        <div class="map_main_btn_2">
                            {{--  <button><a href="#bidds">شاهد المزادات</a></button>  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
use Carbon\Carbon;
use App\Models\admin\land\Land;
$tabok = Land::where('id', 1)->first();
$landArea = $tabok->landAreas()->first(); // الحصول على أول عنصر من العلاقة
$createdAt = $landArea ? $landArea->created_at : null; // التحقق من وجود created_at

$color_tabok = '#808080'; // Default gray color_tabok for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_tabok = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_tabok = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_tabok = '#808080'; // Gray if created_at is null
}


$riad = Land::where('id', 3)->first();
$landArea = $riad->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color = '#808080'; // Default gray color for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color = '#808080'; // Gray if created_at is null
}

$makah = Land::where('id', 9)->first();
$landArea = $makah->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_makah = '#808080'; // Default gray color_makah for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_makah = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_makah = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_makah = '#808080'; // Gray if created_at is null
}

$dmam = Land::where('id', 4)->first();
$landArea = $dmam->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_dmam = '#808080'; // Default gray color_dmam for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_dmam = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_dmam = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_makah = '#808080'; // Gray if created_at is null
}


$gof = Land::where('id', 5)->first();

$landArea = $gof->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_gof = '#808080'; // Default gray color_gof for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_gof = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_gof = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_gof = '#808080'; // Gray if created_at is null
}



$gezan = Land::where('id', 6)->first();
$landArea = $gezan->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_gezan = '#808080'; // Default gray color_gezan for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_gezan = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_gezan = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_gezan = '#808080'; // Gray if created_at is null
}




$ngran = Land::where('id', 7)->first();
$landArea = $ngran->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_ngran = '#808080'; // Default gray color_ngran for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_ngran = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_ngran = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_ngran = '#808080'; // Gray if created_at is null
}


$aser = Land::where('id', 8)->first();
$landArea = $aser->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_aser = '#808080'; // Default gray color_aser for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_aser = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_aser = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_aser = '#808080'; // Gray if created_at is null
}



$mdinah = Land::where('id', 11)->first();
$landArea = $mdinah->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_mdinah = '#808080'; // Default gray color_mdinah for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_mdinah = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_mdinah = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_mdinah = '#808080'; // Gray if created_at is null
}



$hael = Land::where('id', 12)->first();
$landArea = $hael->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_hael = '#808080'; // Default gray color_hael for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_hael = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_hael = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_hael = '#808080'; // Gray if created_at is null
}



$hdood = Land::where('id', 13)->first();
$landArea = $hdood->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_hdood = '#808080'; // Default gray color_hdood for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_hdood = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_hdood = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_hdood = '#808080'; // Gray if created_at is null
}



$kasem = Land::where('id', 14)->first();
$landArea = $kasem->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_kasem = '#808080'; // Default gray color_kasem for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_kasem = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_kasem = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_kasem = '#808080'; // Gray if created_at is null
}

$baha = Land::where('id', 15)->first();
$landArea = $baha->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_baha = '#808080'; // Default gray color_baha for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_baha = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_baha = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_baha = '#808080'; // Gray if created_at is null
}



$sharqia = Land::where('id', 16)->first();
$landArea = $sharqia->landAreas()->first(); // Assuming landArea is a relation, get it first
$createdAt = $landArea ? $landArea->created_at : null; // Check if landArea is not null

$color_sharqia = '#808080'; // Default gray color_sharqia for 'مغلقة'

// Check if the land is created in the last week
if ($createdAt) {
    $createdAt = Carbon::parse($createdAt);

    if ($createdAt->gte(Carbon::now()->startOfWeek()) && $createdAt->lt(Carbon::now()->endOfWeek())) {
        $color_sharqia = '#4CAF50'; // Green if created within the last week
    } elseif ($createdAt->lt(Carbon::now()->subWeek())) {
        $color_sharqia = '#FF5722'; // Red if created more than a week ago
    }
} else {
    $color_sharqia = '#808080'; // Gray if created_at is null
}



@endphp

<script>
    (async() => {
        // Fetch Saudi Arabia map data
        const topology = await fetch(
            'https://code.highcharts.com/mapdata/countries/sa/sa-all.topo.json'
        ).then(response => response.json());

        // Data for cities with vibrant colors and emojis
        const data = [{
            'hc-key': 'sa-ri',
            name: '{{ $riad->name }} ', // Dynamically inject the name with emoji
            link: 'https://example.com/riyadh',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect

                ]
            },
madinah: '{{ $riad->landAreas->count() }}',
            area: '{{ $riad->landAreas->isNotEmpty() ? floor($riad->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-mk',
            name: '{{ $makah->name }} ',
            link: 'https://example.com/mecca',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color_makah }}'],
                    [0.6, '{{ $color_makah }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
            madinah: '{{ $makah->landAreas->count() }}',
            area: '{{ $makah->landAreas->isNotEmpty() ? floor($makah->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-md',
            name: '{{ $mdinah->name }} ',
            madinah: '{{ $tabok->landAreas->count() }}',
            area: '{{ $mdinah->landAreas->isNotEmpty() ? floor($mdinah->landAreas->first()->area) : "مغلقة" }}',
            link: 'https://example.com/madina',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $mdinah->landAreas->count() }}',
area: '{{ $mdinah->landAreas->isNotEmpty() ? floor($mdinah->landAreas->first()->area) : "مغلقة" }}',
states: {

            },
        }, {
            'hc-key': 'sa-sh',
            name: '{{ $sharqia->name }}',
            link: 'https://example.com/eastern',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $sharqia->landAreas->count() }}',
            area: '{{ $sharqia->landAreas->isNotEmpty() ? floor($sharqia->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-as',
            name: '{{ $aser->name }} ',
            link: 'https://example.com/aseer',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $aser->landAreas->count() }}',
            area: '{{ $aser->landAreas->isNotEmpty() ? floor($aser->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-ba',
            name: '{{ $baha->name }} ',
            link: 'https://example.com/baha',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $baha->landAreas->count() }}',
            area: '{{ $baha->landAreas->isNotEmpty() ? floor($baha->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-jf',
            name: '{{ $gof->name }} ',
            link: 'https://example.com/jouf',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $gof->landAreas->count() }}',
            area: '{{ $gof->landAreas->isNotEmpty() ? floor($gof->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-ha',
            name: '{{ $hael->name }} ',
            link: 'https://example.com/hail',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color }}'],
                    [0.6, '{{ $color }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $hael->landAreas->count() }}',
            area: '{{ $hael->landAreas->isNotEmpty() ? floor($hael->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-tb',
            name: '{{ $tabok->name }}',
            link: 'https://example.com/tabuk',
            color: {
    radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
    stops: [
        [0, '{{ $color_tabok }}'],
        [0.6, '{{ $color_tabok }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
        ]
},

madinah: '{{ $tabok->landAreas->count() }}',
area: '{{ $tabok->landAreas->isNotEmpty() ? floor($tabok->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-jz',
            name: '{{ $gezan->name }} ',
            link: 'https://example.com/jazan',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color_gezan }}'],
                    [0.6, '{{ $color_gezan }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $gezan->landAreas->count() }}',
            area: '{{ $gezan->landAreas->isNotEmpty() ? floor($gezan->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-nj',
            name: '{{$ngran->name}} ',
            link: 'https://example.com/najran',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color_ngran }}'],
                    [0.6, '{{ $color_ngran }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $ngran->landAreas->count() }}',
            area: '{{ $ngran->landAreas->isNotEmpty() ? floor($ngran->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-qs',
            name: '{{ $kasem->name }} ',
            link: 'https://example.com/qassim',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color_kasem }}'],
                    [0.6, '{{ $color_kasem }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
madinah: '{{ $kasem->landAreas->count() }}',
            area: '{{ $kasem->landAreas->isNotEmpty() ? floor($kasem->landAreas->first()->area) : "مغلقة" }}',
            states: {

            },
        }, {
            'hc-key': 'sa-hs',
            name: '{{ $hdood->name }} ',
            link: 'https://example.com/northern',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '{{ $color_hdood }}'],
                    [0.6, '{{ $color_hdood }}'],
        [1, 'rgba(50, 50, 50, 0.4)'] // Darker gray with transparency for glossy effect
                ]
            },
            area: '{{ $hdood->landAreas->isNotEmpty() ? floor($hdood->landAreas->first()->area) : "مغلقة" }}',
madinah: '{{ $hdood->landAreas->count() }}',
            states: {

            },
        }];

        // Render the map
        Highcharts.mapChart('container', {
            chart: {
                map: topology
            },
            title: {
                text: null // Remove the title
            },
            mapNavigation: {
                enabled: false // Disable zoom and pan buttons
            },
            credits: {
                enabled: false // Disable Highcharts.com credit text
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<b>{point.name}</b><br>المدينة: {point.area}<br> عدد المزادات :{point.madinah}'
            },
            series: [{
                name: 'خريطة السعودية 🌟',
                data: data,
                borderColor: '#2f4f4f', // لون الحدود (زيتوني داكن)
                borderWidth: 2, // زيادة عرض الحدود
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        const point = this.point;
                        return `<a href="${point.link}" style="color: white; text-decoration: none;">
                                        ${point.name} <br>
                                    </a>`;
                    },
                    useHTML: true
                }
            }]
        });
    })();

    </script>
