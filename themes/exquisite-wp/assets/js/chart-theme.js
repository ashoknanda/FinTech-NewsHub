Highcharts.theme = {
    colors: ['#212121', '#3d3b3b', '#0a4f83', '#1abdd4', '#99d7e0', '#0e72bd', 
             '#0fd8fc', '#436b8a', '#236a7c'],
    chart: {
        backgroundColor: {
            linearGradient: [0, 0, 0, 0],
            stops: [
                [0, 'rgb(255, 255, 255)'],
                [1, 'rgb(255, 255, 255)']
            ]
        },
    },
    title: {
        style: {
            color: '#000',
            font: 'bold 24px "Verdana, sans-serif'
        }
    },
    subtitle: {
        style: {
            color: '#666666',
            font: 'bold 12px "Verdana, sans-serif'
        }
    },

    legend: {
        itemStyle: {
            font: '12pt Verdana, sans-serif',
            color: 'black'
        },
        itemHoverStyle:{
            color: 'gray'
        }   
    }
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);