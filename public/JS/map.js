(async() => {
    // Fetch Saudi Arabia map data
    const topology = await fetch(
        'https://code.highcharts.com/mapdata/countries/sa/sa-all.topo.json'
    ).then(response => response.json());

    // Data for cities with vibrant colors and emojis
    const data = [{
        'hc-key': 'sa-ri',
        name: 'الرياض 🌆',
        link: 'https://example.com/riyadh',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#FFD700'],
                [1, '#FF9800']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#FFEB3B'
            }
        },
    }, {
        'hc-key': 'sa-mk',
        name: 'مكة المكرمة 🕋',
        link: 'https://example.com/mecca',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#ffb99e'],
                [1, '#FF5722']
            ]
        },
        area: '1200 كم²',
        states: {
            hover: {
                color: '#FF7043'
            }
        },
    }, {
        'hc-key': 'sa-md',
        name: 'المدينة المنورة 🕌',
        link: 'https://example.com/madina',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#81C784'],
                [1, '#4CAF50']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#81C784'
            }
        },
    }, {
        'hc-key': 'sa-sh',
        name: 'المنطقة الشرقية 🌊',
        link: 'https://example.com/eastern',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#64B5F6'],
                [1, '#2196F3']
            ]
        },
        area: '2500 كم²',
        states: {
            hover: {
                color: '#64B5F6'
            }
        },
    }, {
        'hc-key': 'sa-as',
        name: 'عسير 🏞️',
        link: 'https://example.com/aseer',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#CE93D8'],
                [1, '#9C27B0']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#CE93D8'
            }
        },
    }, {
        'hc-key': 'sa-ba',
        name: 'الباحة 🌳',
        link: 'https://example.com/baha',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#AED581'],
                [1, '#8BC34A']
            ]
        },
        area: '900 كم²',
        states: {
            hover: {
                color: '#AED581'
            }
        },
    }, {
        'hc-key': 'sa-jf',
        name: 'الجوف 🌵',
        link: 'https://example.com/jouf',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#FFB74D'],
                [1, '#FF9800']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#FFB74D'
            }
        },
    }, {
        'hc-key': 'sa-ha',
        name: 'حائل 🏜️',
        link: 'https://example.com/hail',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#E57373'],
                [1, '#F44336']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#E57373'
            }
        },
    }, {
        'hc-key': 'sa-tb',
        name: 'تبوك ❄️',
        link: 'https://example.com/tabuk',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#4FC3F7'],
                [1, '#03A9F4']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#4FC3F7'
            }
        },
    }, {
        'hc-key': 'sa-jz',
        name: 'جازان 🦀',
        link: 'https://example.com/jazan',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#9575CD'],
                [1, '#673AB7']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#9575CD'
            }
        },
    }, {
        'hc-key': 'sa-nj',
        name: 'نجران 🌞',
        link: 'https://example.com/najran',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#FFF176'],
                [1, '#FFEB3B']
            ]
        },
        area: '1400 كم²',
        states: {
            hover: {
                color: '#FFF176'
            }
        },
    }, {
        'hc-key': 'sa-qs',
        name: 'القصيم 🌾',
        link: 'https://example.com/qassim',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#DCE775'],
                [1, '#CDDC39']
            ]
        },
        area: 'مغلقة',
        states: {
            hover: {
                color: '#DCE775'
            }
        },
    }, {
        'hc-key': 'sa-hs',
        name: 'الحدود الشمالية ❄️',
        link: 'https://example.com/northern',
        color: {
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
                [0, '#4DD0E1'],
                [1, '#00BCD4']
            ]
        },
        area: '2📏 100 كم²',
        states: {
            hover: {
                color: '#4DD0E1'
            }
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
            pointFormat: '<b>{point.name}</b><br>المساحة: {point.area}'
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
                                    ${point.name} <br> مساحة ${point.area}
                                </a>`;
                },
                useHTML: true
            }
        }]
    });
})();